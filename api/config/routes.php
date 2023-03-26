<?php

use Ramsey\Uuid\Uuid;

$uuidPattern = trim(Uuid::VALID_PATTERN, '^$');

return [
    ''                        => 'site/index',
    'rsa'                     => 'site/rsa',
    'encoded'                 => 'site/encoded',
    'tokopedia/shop/showcase' => 'tokopedia/shop/showcase',

    'auth/register' => 'auth/register',
    'auth/login'    => 'auth/login',

    'account/profile'                       => 'account/profile',
//    ''                                 => 'site/index',
    'dummy'                                 => 'dummy',
];
