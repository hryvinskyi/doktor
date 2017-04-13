<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

namespace app\models\form;

use app\components\behaviors\UploadImageBehavior;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;

/**
 * Class RegisterForm
 *
 * @mixin UploadImageBehavior
 */
class RegisterForm extends User
{
    /** @var string */
    public $avatarPath = '@webroot/uploads/user/avatars';

    /** @var UploadedFile */
    public $avatarFile;

    public function init()
    {
        parent::init();
        $this->avatarPath = \Yii::getAlias($this->avatarPath);
    }

    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class'       => UploadImageBehavior::className(),
                'attribute'   => 'file',
                'scenarios'   => ['insert', 'update'],
                'placeholder' => '@web/images/accounts.png',
                'path'        => '@webroot/uploads/user/{id}/images',
                'url'         => '@web/uploads/user/{id}/images',
                'thumbPath'   => '@webroot/uploads/user/{id}/images/thumb',
                'thumbUrl'    => '@web/uploads/user/{id}/images/thumb',
                'thumbs'      => [
                    'thumb'   => ['width' => 100, 'height' => 100],
                    'preview' => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['email', 'full_name'], 'required'],
                ['avatar', 'file', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
            ]
        );
    }

    /**
     * Upload Avatar
     * @return bool
     */
    /*
     It is noted that add Upload Behavior
    public function uploadAvatar()
    {
        if (file_exists($this->avatarPath) === false) {
            BaseFileHelper::createDirectory($this->avatarPath, 0775, true);
        }

        if ($this->validate() && isset($this->avatarFile)) {
            $avatarFileName = $this->avatarPath . DIRECTORY_SEPARATOR . uniqid('avatar_')
                . '.' . $this->avatarFile->extension;
            if($this->avatarFile->saveAs($avatarFileName)) {
                $this->avatarFile = null;
                $this->avatar = $avatarFileName;
            }

            return true;
        } else {
            return false;
        }
    }
    */
}
