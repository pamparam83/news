<?php

namespace core\helpers;

use core\entities\News;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NewsHelper
{
    public static function statusList(): array
    {
        return [
            News::STATUS_DRAFT => 'Draft',
            News::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case News::STATUS_DRAFT:
                $class = 'label label-default draft';
                break;
            case News::STATUS_ACTIVE:
                $class = 'label label-success activeNews';
                break;
            default:
                $class = 'label label-default draft';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function isAuthor($author)
    {
        $role = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id);
        if(reset($role)->name == 'admin'){
            return true;
        }
        if($author == \Yii::$app->user->id){
            return true;
        }
        return false;
    }
}