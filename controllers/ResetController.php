<?php


namespace frontend\controllers\auth;

use core\forms\auth\ResetPasswordForm;
use Yii;
use core\services\auth\PasswordResetService;
use yii\web\Controller;
use core\forms\auth\PasswordResetRequestForm;
use yii\web\BadRequestHttpException;

class ResetController extends Controller
{
    private $service;

    public function __construct($id,$module,PasswordResetService $service,array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        return $this->render('request', [
            'model' => $form,
        ]);
    }

    public function actionConfirm($token)
    {
        try{
           $this->service->validateToken($token);
        }catch (\DomainException $e){
            throw new BadRequestHttpException($e->getMessage());
        }
        $form = new ResetPasswordForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            try {
                $this->service->reset($token,$form);
                Yii::$app->session->setFlash('success', 'New password saved.');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->goHome();
        }

        return $this->render('confirm', [
            'model' => $form,
        ]);
    }
}