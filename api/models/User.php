<?php


namespace api\models;


use phpDocumentor\Reflection\Types\This;
use yii\base\Model;
use yii\web\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public $Id;
    public $Identity;
    public $AccessToken;
    public $FirebaseToken;
    public $Role;
    public $AllowedPlatform;

    public function getId()
    {
        return $this->Id;
    }

    public static function findIdentity($id)
    {
    }
}