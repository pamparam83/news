<?php
namespace app\controllers\cabinet;

use yii\filters\AccessControl;
use yii\web\Controller;
use core\entities\User;
use Yii;
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionPassword()
    {
        Yii::$app->session->setFlash('success', 'Password changed.');
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $model = $this->findModel();
        return $this->render('index',[
            'model' => $model,
        ]);
    }

    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}