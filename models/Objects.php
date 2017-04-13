<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

namespace app\models;

use app\components\behaviors\UploadBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $type
 * @property int $company_id
 * @property string $file
 *
 * @mixin UploadBehavior
 */
class Objects extends \yii\db\ActiveRecord
{
    const TYPE_PRIVATE = 0;
    const TYPE_PUBLIC = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%objects}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],

            [['type', 'company_id'], 'integer'],

            [['name'], 'string', 'max' => 255],

            ['file', 'file', 'extensions' => 'doc, docx, pdf, xlsx, xls, csv', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'file',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/uploads/objects/{id}',
                'url' => '@web/uploads/objects/{id}',
            ],
        ];
    }

    /**
     * Status name
     * @return string|null
     */
    public function getTypeName()
    {
        return ArrayHelper::getValue(self::getTypesArray(), $this->type);
    }

    /**
     * Statuses
     * @return array
     */
    public static function getTypesArray()
    {
        return [
            self::TYPE_PRIVATE => \Yii::t('objects', 'Private'),
            self::TYPE_PUBLIC  => \Yii::t('objects', 'Public'),
        ];
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->type == self::TYPE_PUBLIC) {
                $this->company_id = null;
            } elseif($this->type == self::TYPE_PRIVATE) {
                $this->company_id = \Yii::$app->user->identity->company_id;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Upload Avatar
     * @return bool
     */
    /*
    It is noted that add Upload Behavior
    public function uploadFile()
    {
        if (file_exists($this->filePath) === false) {
            BaseFileHelper::createDirectory($this->filePath, 0775, true);
        }

        if ($this->validate() && isset($this->fileUpload)) {
            $fileName = $this->filePath . DIRECTORY_SEPARATOR . uniqid('avatar_')
                . '.' . $this->fileUpload->extension;
            if($this->fileUpload->saveAs($fileName)) {
                $this->fileUpload = null;
                $this->file = $fileName;
            }

            return true;
        } else {
            return false;
        }
    }
    */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
            'company_id' => 'Company',
            'file' => 'File',
        ];
    }
}
