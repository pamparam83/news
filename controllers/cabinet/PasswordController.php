<?php

namespace app\controllers\cabinet;

use core\forms\auth\PasswordChangeForm;
use core\services\auth\PasswordResetService;
use yii\filters\AccessControl;
use yii\web\Controller;
use core\entities\User;
use Yii;

class PasswordController extends Controller
{
    protected $service;

    public function __construct(string $id, $module, PasswordResetService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

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

    public function actionIndex()
    {
        $user = $this->findModel();
        $form = new PasswordChangeForm($user);


        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->changePassword($user,$form);
            Yii::$app->session->setFlash('success', 'Password changed. Check your email and follow the instructions');
            return $this->redirect(['index']);
        } else {
            return $this->render('index', [
                'model' => $form,
            ]);
        }
    }

    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }


}