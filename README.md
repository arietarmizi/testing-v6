    • php init
    • composer install
    • setup your db configuration on "common/main-local" 
    • php yii migrate     
    • php yii migrate --migrationPath=@yii/i18n/migrations
    • php yii migrate --migrationPath=@nadzif/yii2-file-core/src/migrations
    • php yii message common/config/i18n.php
    • php yii setup/system-app
    • php yii setup/provider
