<?php
namespace app\controllers;

use Yii;
use core\services\auth\SignupService;
use yii\web\Controller;
use yii\filters\AccessControl;
use core\forms\auth\SignupForm;
class SignupController extends  Controller
{
    private $service;

    public function __construct($id,$module,SignupService $service,array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Проверьте свой email и проследуйте инструкции.');
                return $this->goHome();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'Извините, но мы не смогли отправить письмо на указанный email.');
            }
        }
        return $this->render('request', [
            'model' => $form,
        ]);
    }

    public function actionConfirm($token)
    {
        try {
            $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Ваш email подтвержден.');
            return $this->redirect(['auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }
    }


}