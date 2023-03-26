<?php


namespace common\models;


use common\base\ActiveRecord;
use Ramsey\Uuid\Uuid;
use yii\base\NotSupportedException;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;


/**
 * Class User
 *
 * @package common\models
 *
 * @property string                $id
 * @property string                $fileId
 * @property string                $identityCardNumber
 * @property string                $name
 * @property string                $phoneNumber
 * @property string                $email
 * @property string                $type
 * @property string                $birthDate
 * @property string                $address
 * @property string                $verified
 * @property string                $verifiedAt
 * @property string                $passwordHash
 * @property string                $passwordResetToken
 * @property string                $verificationToken
 * @property string                $status
 * @property string                $createdAt
 * @property string                $updatedAt
 *
 * @property Device                $currentDevice
 *
 * @property Device[]              $devices
 * @property Device[]              $activeDevices
 *
 * @property NotSupportedException $authKey
 */
class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
    const TYPE_OWNER    = 'owner';
    const TYPE_EMPLOYEE = 'employee';

    const STATUS_ACTIVE    = 'active';
    const STATUS_INACTIVE  = 'inactive';
    const STATUS_BANNED    = 'banned';
    const STATUS_SUSPENDED = 'suspended';

    public  $rateLimit            = 10;
    public  $allowance;
    public  $allowance_updated_at;
    private $requestCodeDuration  = 5;
    private $requestResetDuration = 60;
    private $codeExpiredDuration  = 5;

    /** @var Device */
    private $_currentDevice;

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE    => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE  => \Yii::t('app', 'Inactive'),
            self::STATUS_SUSPENDED => \Yii::t('app', 'Suspended'),
            self::STATUS_BANNED    => \Yii::t('app', 'Banned'),
        ];
    }

    public static function types()
    {
        return [
            self::TYPE_OWNER    => \Yii::t('app', 'Owner'),
            self::TYPE_EMPLOYEE => \Yii::t('app', 'Employee'),
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }

    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////
    // Local Variable Area ///////////////////////////////////////
    //////////////////////////////////////////////////////////////
    // $$ local password

    /**
     * @param int|string $id
     *
     * @return User|\yii\db\ActiveRecord|IdentityInterface
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->where(['id' => $id, 'verified' => 1])
            ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var Device $device */
        $device = Device::find()
            ->where([
                'accessToken'                   => $token,
                Device::tableName() . '.status' => Device::STATUS_ACTIVE,
            ])
            ->with(['user'])
            ->one();

        if ($device) {
            $user = $device->user;
            if ($user->status == User::STATUS_ACTIVE) {
                $user->currentDevice = $device;
                return $user;
            }
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'id'                 => \Yii::t('app', 'Id'),
            'outletId'           => \Yii::t('app', 'Outlet Code'),
            'identityCardNumber' => \Yii::t('app', 'Identity Card Number'),
            'type'               => \Yii::t('app', 'Type'),
            'name'               => \Yii::t('app', 'Name'),
            'email'              => \Yii::t('app', 'Email'),
            'phoneNumber'        => \Yii::t('app', 'PhoneNumber'),
            'passwordHash'       => \Yii::t('app', 'PasswordHash'),
            'birthDate'          => \Yii::t('app', 'BirthDate'),
            'verified'           => \Yii::t('app', 'Verified'),
            'status'             => \Yii::t('app', 'Status'),
            'createdAt'          => \Yii::t('app', 'Created At'),
            'updatedAt'          => \Yii::t('app', 'Updated At'),
        ];
    }

    public function attributeHints()
    {
        return [
            'id'               => \Yii::t('app', 'Id'),
            'userId'           => \Yii::t('app', 'User Id'),
            'quotaId'          => \Yii::t('app', 'quotaId'),
            'deviceIdentifier' => \Yii::t('app', 'deviceIdentifier'),
            'qrCode'           => \Yii::t('app', 'qrCode'),
            'point'            => \Yii::t('app', 'point'),
            'latitude'         => \Yii::t('app', 'latitude'),
            'longitude'        => \Yii::t('app', 'longitude'),
            'status'           => \Yii::t('app', 'Status'),
            'createdAt'        => \Yii::t('app', 'Created At'),
            'updatedAt'        => \Yii::t('app', 'Updated At'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['passwordHash']);

        return $fields;
    }

    public function setPassword($password)
    {
        $this->passwordHash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    /**
     * @return Device|null
     */
    public function getCurrentDevice()
    {
        return $this->_currentDevice;
    }

    /**
     * @param Device $currentDevice
     */
    public function setCurrentDevice($currentDevice)
    {
        $this->_currentDevice = $currentDevice;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(Uuid $id)
    {
        $this->id = $id;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    /**
     * @param string $authKey
     *
     * @return bool|void
     * @throws NotSupportedException
     * @since 2018-05-13 21:03:06
     *
     */

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    public function getDevices()
    {
        return $this->hasMany(Device::class, ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveDevices()
    {
        return $this->hasMany(Device::class, ['userId' => 'id'])
            ->andWhere([Device::tableName() . '.status' => Device::STATUS_ACTIVE]);
    }

    public function getForgotPasswords()
    {
        return $this->hasMany(ForgotPassword::class, ['userId', 'id']);
    }

    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, 20];
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance            = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }

    public function getShop()
    {
        return $this->hasOne(Shop::class, ['userId' => 'id']);
    }

}
