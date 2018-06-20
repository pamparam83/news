<?php

namespace app\controllers;

use core\repositories\news\NewsReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class NewsController extends Controller
{

    private $posts;

    public function __construct(
        $id,
        $module,
        NewsReadRepository $posts,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->posts = $posts;

    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index','item'],
                'rules' => [
                    [
                        'actions' => ['item'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],

        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->posts->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionItem($id)
    {
        if (!$post = $this->posts->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('news', [
            'news' => $post,
        ]);
    }

}