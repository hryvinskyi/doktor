<?php

use yii\db\Migration;
use app\models\CompanyRegisterCodes;

class m170413_085958_CompanyRegisterCodes extends Migration
{
    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } else {
            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable(
            CompanyRegisterCodes::tableName(),
            [
                'id'             => $this->primaryKey(11),
                'company_fee_id' => $this->integer(11),
                'code'           => $this->string(32)->notNull(),
                'status'         => $this->boolean()->defaultValue(1),
            ],
            $tableOptions
        );

        $this->batchInsert(
            CompanyRegisterCodes::tableName(),
            ['company_fee_id', 'code'],
            [
                [
                    'company_fee_id' => 1,
                    'code'           => \Yii::$app->security->generateRandomString(),
                ],
                [
                    'company_fee_id' => 2,
                    'code'           => \Yii::$app->security->generateRandomString(),
                ]
            ]
        );
    }

    public function down()
    {
        $this->dropTable(CompanyRegisterCodes::tableName());
    }
}
