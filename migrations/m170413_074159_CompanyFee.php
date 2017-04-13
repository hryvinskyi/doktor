<?php

use yii\db\Migration;
use app\models\CompanyFee;

class m170413_074159_CompanyFee extends Migration
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
            CompanyFee::tableName(),
            [
                'id'         => $this->primaryKey(11),
                'company_id' => $this->integer(1)->notNull(),
                'valid_till' => $this->date(),
            ],
            $tableOptions
        );

        $this->batchInsert(
            CompanyFee::tableName(),
            ['company_id', 'valid_till'],
            [
                [
                    'company_id' => 1,
                    'valid_till' => '2018-01-01',
                ],
                [
                    'company_id' => 2,
                    'valid_till' => '2017-12-30',
                ],
            ]
        );
    }

    public function down()
    {
        $this->dropTable(CompanyFee::tableName());
    }
}
