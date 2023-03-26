<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 8/29/2018
 * Time: 4:42 PM
 */

namespace common\translation;


use common\widgets\Select2;
use kartik\grid\EditableColumn;
use yii\base\Model;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class LanguageGrid extends Model
{
    public $pageSize = 25;

    public $sourceMessageCategory;
    public $sourceMessageValue;

    public $indonesiaTranslation;

    public function rules()
    {
        return [
            ['pageSize', 'integer'],
            [['sourceMessageCategory', 'sourceMessageValue', 'indonesiaTranslation'], 'safe'],
            [['sourceMessageCategory', 'sourceMessageValue', 'indonesiaTranslation'], 'string', 'max' => 255],
        ];
    }

    public function getDataProvider()
    {

        $filterAttributes = $this->filterAttributes();
        $query            = SourceMessage::find()->joinWith(['indonesiaLanguage indonesiaLanguage']);

        $requestParams = \Yii::$app->request->queryParams;

        $this->load($requestParams);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => $this->pageSize],
            'key'        => 'id'
        ]);


        if (!$this->validate()) {
            return $dataProvider;
        }


        foreach ($filterAttributes as $attributeKey => $filter) {

            $dataProvider->sort->attributes[$attributeKey] = [
                'asc'  => [$filterAttributes[$attributeKey] => SORT_ASC],
                'desc' => [$filterAttributes[$attributeKey] => SORT_DESC],
            ];

            $query->andFilterWhere(['like', $filterAttributes[$attributeKey], $this->$attributeKey]);
        }


        return $dataProvider;
    }

    public function filterAttributes()
    {
        return [
            'sourceMessageCategory' => SourceMessage::tableName() . '.category',
            'sourceMessageValue'    => SourceMessage::tableName() . '.message',
            'indonesiaTranslation'  => 'indonesiaLanguage.translation',
        ];

    }

    public function getColumns()
    {
        $sourceMessageCategories = (new \yii\db\Query())
            ->select('category')
            ->from(SourceMessage::tableName())
            ->distinct()
            ->all(SourceMessage::getDb());

        return [
            [
                'attribute'           => 'sourceMessageCategory',
                'filterType'          => Select2::class,
                'filterWidgetOptions' => [
                    'data' => ArrayHelper::map($sourceMessageCategories, 'category', 'category')
                ],
                'value'               => 'category',

            ],
            [
                'attribute' => 'sourceMessageValue',
                'value'     => 'message',
            ],
            [
                'class'           => EditableColumn::class,
                'attribute'       => 'indonesiaTranslation',
                'value'           => 'indonesiaLanguage.translation',
                'refreshGrid'     => true,
                'editableOptions' => [
                    'submitButton' => [
                        'class' => 'btn btn-themecolor waves-effect waves-light',
                        'icon'  => Html::icon('floppy')
                    ],
                    'resetButton'  => [
                        'class' => 'btn btn-primary waves-effect waves-light',
                        'icon'  => Html::icon('refresh')
                    ],
                    'formOptions'  => [
                        'action' => ['language/translate'],
                    ]
                ]
            ],
        ];
    }
}