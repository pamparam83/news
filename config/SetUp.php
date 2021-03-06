<?php
namespace app\config;

use core\services\manage\news\NewsManageService;
use core\services\manage\UserManageService;
use yii\base\BootstrapInterface;
use core\services\auth\PasswordResetService;
use core\services\auth\SignupService;
use yii\rbac\ManagerInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class,[],[
            [$app->params['supportEmail'] => $app->name . ' robot'],
        ]);

        $container->setSingleton(SignupService::class,[],[
            [$app->params['supportEmail'] => $app->name . ' robot'],
        ]);

        $container->setSingleton(UserManageService::class,[],[
            [$app->params['supportEmail'] => $app->name . ' robot'],
        ]);
        $container->setSingleton(NewsManageService::class,[],[
            [$app->params['supportEmail'] => $app->name . ' robot'],
        ]);
        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(MailerInterface::class, function() use ($app){
            return $app->mailer;
        } );
    }
}