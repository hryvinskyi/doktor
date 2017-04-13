<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%company_fee}}".
 *
 * @property int $id
 * @property int $company_id
 * @property string $valid_till
 */
class CompanyFee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_fee}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id'], 'integer'],
            [['valid_till'], 'safe'],
        ];
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'valid_till' => 'Valid Till',
        ];
    }
}
