<?php

namespace console\setup;

use common\models\Admin;
use common\models\SystemApp;
use common\models\SystemConfig;
use yii\base\BaseObject;
use yii\rbac\DbManager;

class Development extends BaseObject
{

    public static function createSystemApp()
    {
        $userService            = new SystemApp();
        $userService->name      = 'System App';
        $userService->appKey    = 'appKey';
        $userService->appSecret = 'appSecret';
        $userService->status    = SystemApp::STATUS_ACTIVE;
        $userService->type      = SystemApp::TYPE_DEVICE;
        $userService->save();

        return $userService;
    }

    public static function createSystemConfig($key, $value)
    {
        $systemConfig        = new SystemConfig();
        $systemConfig->key   = $key;
        $systemConfig->value = $value;
        $systemConfig->save();

        return $systemConfig;
    }

    public static function createRole()
    {
        /** @var DbManager $authManager */
        $authManager = \Yii::$app->authManager;

        $superuser              = $authManager->createRole(Admin::ROLE_SUPERUSER);
        $superuser->description = 'Site Superuser';

        $administrator              = $authManager->createRole(Admin::ROLE_ADMINISTRATOR);
        $administrator->description = 'Site Administrator';

        $authManager->add($superuser);
        $authManager->add($administrator);

        return [$superuser, $administrator];
    }

    public static function createAdmin()
    {
        /** @var DbManager $authManager */
        $authManager       = \Yii::$app->authManager;
        $roleSuperuser     = $authManager->getRole(Admin::ROLE_SUPERUSER);
        $roleAdministrator = $authManager->getRole(Admin::ROLE_ADMINISTRATOR);

        $superuser        = new Admin();
        $superuser->name  = 'Superuser PTPL';
        $superuser->email = 'admin@admin.com';
        $superuser->setPassword('p4ssw0rd##');
        $superuser->phoneNumber = '081111111111';
        $superuser->save();

        $authManager->assign($roleSuperuser, $superuser->id);

        $administrator        = new Admin();
        $administrator->name  = 'Admin PTPL';
        $administrator->email = 'admin2@admin.com';
        $administrator->setPassword('p4ssw0rd##');
        $administrator->phoneNumber = '082222222222';
        $administrator->save();

        $authManager->assign($roleAdministrator, $administrator->id);

        return [$superuser, $administrator];

    }
}
