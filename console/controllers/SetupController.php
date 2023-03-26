<?php

namespace console\controllers;

use common\helpers\FolderManager;
use common\models\Admin;
use common\models\Provider;
use common\models\ProviderConfig;
use common\models\SystemApp;
use common\models\SystemConfig;
use common\models\WhatsAppProvider;
use console\setup\Development;
use yii\console\Controller;
use yii\helpers\Console;
use yii\rbac\Role;

class SetupController extends Controller
{
    public function actionInit()
    {
        $this->actionSystemApp();
        $this->actionSystemConfig();
        $this->actionAdmin();
        $this->actionInitFolder();
    }

    public function actionSystemApp()
    {
        $this->stdout("Prepare init data for development...\n");

        $this->stdout("\nCreating a new SystemApp...\n", Console::FG_BLUE);
        /** @var SystemApp $systemApp */
        $systemApp = Development::createSystemApp();
        $this->stdout($systemApp->name . " system app created!...\n", Console::FG_GREEN);

    }

    public function actionSystemConfig()
    {
        $configs = [SystemConfig::FIREBASE_TOKEN => 'AIzaSyBGmBwQgFXFdpptsDRAYU6Dlub0JopsuLo'];

        $this->stdout("Prepare init data for development...\n");

        foreach ($configs as $key => $value) {
            /** @var SystemConfig $systemConfig */
            $systemConfig = Development::createSystemConfig($key, $value);
            $this->stdout($systemConfig->key . " config created!...\n", Console::FG_GREEN);
        }
    }

    public function actionAdmin()
    {
        $this->stdout("\nCreating roles...\n", Console::FG_BLUE);
        /** @var Role[] $admins */
        $roles = Development::createRole();

        foreach ($roles as $role) {
            $this->stdout($role->name . " role created!...\n", Console::FG_GREEN);
        }

        $this->stdout("\nCreating admins...\n", Console::FG_BLUE);
        /** @var Admin[] $admins */
        $admins = Development::createAdmin();

        foreach ($admins as $admin) {
            $this->stdout($admin->name . " admin created!...\n", Console::FG_GREEN);
        }
    }


    public function actionInitFolder()
    {
        $this->stdout("Prepare init product image folder...\n");

        $this->stdout("\nCreating required folder...\n", Console::FG_BLUE);

        $ProductImageFolder = FolderManager::makeDirectory('@api', 'uploads' . DIRECTORY_SEPARATOR . 'product');

        $this->stdout("Folder product image created successfully!...\n", Console::FG_GREEN);
    }
}
