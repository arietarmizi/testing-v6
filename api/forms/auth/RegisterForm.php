<?php

namespace api\forms\auth;

use api\components\BaseForm;
use Carbon\Carbon;
use common\models\User;
use common\validators\PhoneNumberValidator;

class RegisterForm extends BaseForm
{
    public $id;
    public $fileId;
    public $merchantId;
    public $identityCardNumber;
    public $name;
    public $phoneNumber;
    public $email;
    public $type;
    public $birthDate;
    public $address;
    public $verified;
    public $verifiedAt;
    public $password;
    public $confirmPassword;
    public $passwordResetToken;
    public $verifiedToken;
    public $status;

    /** @var User */
    protected $_user;

    public function init()
    {
        parent::init();
    }

    public function validateEmail($attribute, $params)
    {
        $email = User::find()
            ->where(['email' => $this->email])
            ->one();
        if ($email) {
            $this->addError($attribute, \Yii::t('app', '{attribute} "{value}" have registered.', [
                'attribute' => $attribute,
                'value'     => $this->email
            ]));
        }
    }

    public function validatePhoneNumber($attribute, $params = [])
    {
        $count = User::find()
            ->where(['phoneNumber' => $this->phoneNumber])
            ->count();
        if ($count > 0) {
            $this->addError($attribute, \Yii::t('app', '{attribute} "{value}" has already registered.', [
                'attribute' => $attribute,
                'value'     => $this->phoneNumber
            ]));
        }
    }

    public function rules()
    {
        return [
            [['identityCardNumber', 'name', 'phoneNumber', 'email', 'birthDate', 'address', 'password', 'confirmPassword'], 'required'],
            ['type', 'in', 'range' => array_keys(User::types())],
            ['phoneNumber', PhoneNumberValidator::class],
            ['phoneNumber', 'validatePhoneNumber'],
            ['email', 'string', 'max' => 255],
            ['email', 'validateEmail'],
            [['password', 'confirmPassword'], 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function submit()
    {
        return $this->_createUser();
    }

    protected function _createUser()
    {
        $transaction = \Yii::$app->db->beginTransaction();

        $user                     = new User();
        $user->identityCardNumber = $this->identityCardNumber;
        $user->name               = $this->name;
        $user->phoneNumber        = $this->phoneNumber;
        $user->email              = $this->email;
        $user->type               = $this->type ? $this->type : User::TYPE_OWNER;
        $user->birthDate          = $this->birthDate;
        $user->address            = $this->address;
        $user->verified           = true;
        $user->verifiedAt         = Carbon::now()->format('Y-m-d');
        $user->setPassword($this->password);
        if ($user->save()) {
            $user->refresh();
            $this->_user = $user;
            $transaction->commit();
            return true;
        } else {
            $this->addErrors($this->getErrors());
            $transaction->rollBack();
            return false;
        }
    }

    public function response()
    {
        $query = $this->_user->toArray();

        unset($query['createdAt']);
        unset($query['updatedAt']);

        return ['user' => $query];
    }
}