<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%company_register_codes}}".
 *
 * @property int $id
 * @property int $company_fee_id
 * @property string $code
 * @property int $status
 */
class CompanyRegisterCodes extends \yii\db\ActiveRecord
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_register_codes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_fee_id', 'code', 'status'], 'required'],
            [['code'], 'string', 'max' => 32],
            [['company_fee_id', 'status'], 'integer'],
        ];
    }

    public function getCompanyFee() {
        return $this->hasOne(CompanyFee::className(), ['id' => 'company_fee_id']);
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])
            ->via('companyFee');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_fee_id' => 'Company Fee',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }
}
