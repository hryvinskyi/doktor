<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $company_id
 * @property string  $full_name
 * @property string  $auth_key
 * @property string  $email
 * @property string  $avatar
 * @property string  $password_hash
 *
 * @property string  $authKey
 * @property string  $statusName
 * @property string  $passwordHash
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'status'], 'integer'],

            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => self::className(),
                'message'     => \Yii::t('user', 'A user with this email is already registered'),
            ],
            ['email', 'string', 'max' => 255],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            ['full_name', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * Status name
     * @return string|null
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * Statuses
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => \Yii::t('user', 'Blocked'),
            self::STATUS_ACTIVE  => \Yii::t('user', 'Active'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     *
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePasswordHash($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPasswordHash($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }

            return true;
        }

        return false;
    }
}
