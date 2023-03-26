<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 5/29/2018
 * Time: 2:04 AM
 */

namespace common\widgets;


use yii\helpers\Html;

class Select2 extends \kartik\select2\Select2
{

    public $theme         = self::THEME_BOOTSTRAP;
    public $pluginOptions = [
        'closeOnSelect' => true,
        'allowClear'    => true
    ];

    public function __construct($config = array())
    {
        $config['toggleAllSettings'] = [
            'selectLabel'   => Html::tag('i', false, ['class' => 'fa fa-check']) . \Yii::t('app',
                    'Select all'),
            'unselectLabel' => Html::tag('i', false, ['class' => 'fa fa-close']) . \Yii::t('app',
                    'Deselect all'),
            'options'       => ['class' => 's2-togall-button']
        ];

        parent::__construct($config);

        $multiple = isset($this->options['multiple']) && $this->options['multiple'];


        if (!$multiple) {
            if (!$this->initValueText) {
                $this->initValueText = \Yii::t('app', 'Choose ...');
            }

            if (!isset($this->options['placeholder'])) {
                $this->options['placeholder'] = \Yii::t('app', 'Choose ...');
            }
        }
    }

}