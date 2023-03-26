<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 8/22/2018
 * Time: 6:20 PM
 */

namespace console\controllers;


use console\base\DataMigrator;
use console\models\City;
use console\models\District;
use console\models\Province;
use console\models\SubDistrict;
use yii\console\Controller;

class DataController extends Controller
{
//
//
//    public function actions()
//    {
//        if (\Yii::$app->params['consoleData']) {
//            return parent::actions();
//        }
//
//        return null;
//    }

    public function actionRegion()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/region.csv',
            'modelClass'     => null,
            'attributeIndex' => ['id', 'name'],
        ]);

        $migrator->migrate();
    }

    public function actionRunAll()
    {
        $this->actionProvinces();
        $this->actionCities();
        $this->actionDistricts();
        $this->actionSubDistricts();
    }

    public function actionProvinces()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/locations/provinces.csv',
            'modelClass'     => Province::class,
            'attributeIndex' => ['id', 'code', 'name'],
        ]);

        $migrator->migrate();
    }

    public function actionCities()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/locations/cities.csv',
            'modelClass'     => City::class,
            'attributeIndex' => ['id', 'provinceId', 'code', 'name'],
        ]);

        $migrator->migrate();
    }

    public function actionDistricts()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/locations/districts.csv',
            'modelClass'     => District::class,
            'attributeIndex' => ['id', 'cityId', 'name'],
        ]);

        $migrator->migrate();
    }

    public function actionSubDistricts()
    {
        $migrator = new DataMigrator([
            'csvPath'        => __DIR__ . '/data/locations/sub-districts.csv',
            'modelClass'     => SubDistrict::class,
            'attributeIndex' => ['districtId', 'name', 'postalCode'],
        ]);

        $migrator->migrate();
    }


}