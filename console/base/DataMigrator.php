<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 8/22/2018
 * Time: 6:42 PM
 */

namespace console\base;


use common\base\ActiveRecord;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class DataMigrator extends BaseObject
{

    public  $modelClass;
    public  $modelAttributes     = [];
    public  $fromLine            = 1;
    public  $csvPath;
    public  $attributeIndex;
    public  $ignoreColumnIndexes = [];
    private $_rows               = [];

    public function migrate()
    {

        $this->setRows();

        foreach ($this->_rows as $row) {
            /** @var ActiveRecord $model */
            $model = new $this->modelClass($this->modelAttributes);
            $model->setAttributes($this->modelAttributes);

            if (count($row) == count($this->attributeIndex)) {
                foreach ($this->attributeIndex as $index => $attribute) {
                    if (ArrayHelper::isIn($index, $this->ignoreColumnIndexes)) {
                        continue;
                    }
                    $model->setAttribute($attribute, $row[$index]);
                }

                echo 'inserting into table ' . $model->tableName() . ' (' . implode(', ', $row) . ')';
                $model->save(false);
                echo PHP_EOL;
            }

        }
    }

    private function setRows()
    {
        $fileHandler = fopen($this->csvPath, 'r');

        $iC = 1;
        while (!feof($fileHandler)) {
            if ($iC >= $this->fromLine) {
                $this->_rows[] = fgetcsv($fileHandler, 1024);
            }
            $iC++;
        }

        fclose($fileHandler);
    }


}