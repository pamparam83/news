<?php

namespace core\entities\Blog\Post;

use core\entities\Blog\Post\Comment;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\behaviors\MetaBehavior;
use core\entities\Blog\Post\queries\CommentQuery;
use core\entities\Blog\Post\queries\PostQuery;
use core\entities\Meta;
use core\entities\Blog\Category;
use core\entities\Blog\Tag;
use core\services\WaterMarker;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $category_id
 * @property integer $created_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $photo
 * @property integer $status
 * @property integer $comments_count
 *
 * @property Meta $meta
 * @property Category $category
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property Comment[] $comments
 *
 * @mixin ImageUploadBehavior
 */
class Post extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $meta;

    public static function create($categoryId, $title, $description, $content, Meta $meta)
    {
        $post = new static();
        $post->category_id = $categoryId;
        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->meta = $meta;
        $post->status = self::STATUS_DRAFT;
        $post->created_at = time();
        $post->comments_count = 0;
        return $post;
    }

    public function setPhoto(UploadedFile $photo)
    {
        $this->photo = $photo;
    }


    public function edit($categoryId, $title, $description, $content, Meta $meta)
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Post is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Post is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function getSeoTitle()
    {
        return $this->meta->title ?: $this->title;
    }

    // Tags

    public function assignTag($id)
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id)
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags()
    {
        $this->tagAssignments = [];
    }

    // Comments

    public function addComment($userId, $parentId, $text)
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        if ($parent && !$parent->isActive()) {
            throw new \DomainException('Cannot add comment to inactive parent.');
        }
        $comments = $this->comments;
        $comments[] = $comment = Comment::create($userId, $parent ? $parent->id : null, $text);
        $this->updateComments($comments);
        return $comment;
    }

    public function editComment($id, $parentId, $text)
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->edit($parent ? $parent->id : null, $text);
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function activateComment($id)
    {
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->activate();
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function removeComment($id)
    {
        $comments = $this->comments;
        foreach ($comments as $i => $comment) {
            if ($comment->isIdEqualTo($id)) {
                if ($this->hasChildren($comment->id)) {
                    $comment->draft();
                } else {
                    unset($comments[$i]);
                }
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function getComment($id)
    {
        foreach ($this->comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                return $comment;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    private function hasChildren($id)
    {
        foreach ($this->comments as $comment) {
            if ($comment->isChildOf($id)) {
                return true;
            }
        }
        return false;
    }

    private function updateComments(array $comments)
    {
        $this->comments = $comments;
        $this->comments_count = count(array_filter($comments, function (Comment $comment) {
            return $comment->isActive();
        }));
    }

    ##########################

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getTagAssignments()
    {
        return $this->hasMany(TagAssignment::class, ['post_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    ##########################

    public static function tableName()
    {
        return '{{%blog_posts}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['tagAssignments', 'comments'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/uploads/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@static/uploads/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 700, 'height' => 300],
                    'widget_list' => ['width' => 228, 'height' => 228],
//                    'origin' => ['processor' => [new WaterMarker(1024, 768, '@public/images/logo.png'), 'process']],
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }
}