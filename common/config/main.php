<?php

return [
    'aliases'    => [
        '@bower'  => '@vendor/bower-asset',
        '@npm'    => '@vendor/npm-asset',
        '@nadzif' => '@vendor/nadzif',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter'         => [
            'dateFormat'             => 'dd MMMM yyyy',
            'decimalSeparator'       => ',',
            'thousandSeparator'      => '.',
            'currencyCode'           => 'IDR',
            'numberFormatterOptions' => [
                7 => 0,
                6 => 0,
            ],
            'numberFormatterSymbols' => [
                8 => 'Rp. ',
            ]
        ],
        'cache'             => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'       => [
            'class' => yii\rbac\DbManager::className(),
        ],
        'i18n'              => [
            'translations' => [
                'app*' => [
                    'class'           => \yii\i18n\DbMessageSource::class,
                    'sourceLanguage'  => 'en',
                    'db'              => 'db',
                    'cachingDuration' => 24 * 3600,
                    'enableCaching'   => true
                ],

            ],
        ],
        'fileManager'       => [
            'class'                     => \nadzif\file\FileManager::className(),
            'db'                        => 'db',
            'alias'                     => \nadzif\file\models\File::ALIAS_API,
            'defaultImageThumbnail'     => '@frontend/web/images/thumb-image.jpg',
            'defaultDocumentThumbnail'  => '@frontend/web/images/thumb-document.jpg',
            'defaultAudioThumbnail'     => '@frontend/web/images/thumb-audio.jpg',
            'defaultVideoThumbnail'     => '@frontend/web/images/thumb-video.jpg',
            'defaultOtherThumbnail'     => '@frontend/web/images/thumb-other.jpg',
            'allowedDocumentExtensions' => ['txt', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'csv']
        ],
    ],
];
