<?php
return [
    'components' => [
        'db' => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'sqlsrv:Server=X\SQLEXPRESS;Database=e_commerce_enabler',
            'username' => 'sa',
            'password' => 'p4ssw0rd##',
            'charset'  => 'utf8',
        ],
    ],
];
