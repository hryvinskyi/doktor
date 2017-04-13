<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

use yii\db\Migration;
use app\models\Company;

class m170413_074152_Company extends Migration
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
            Company::tableName(),
            [
                'id'            => $this->primaryKey(11),
                'name'          => $this->string(255)->notNull()
            ],
            $tableOptions
        );

        $this->batchInsert(
            Company::tableName(),
            ['name'],
            [
                ['name' => 'Company A'],
                ['name' => 'Company B'],
            ]
        );
    }

    public function down()
    {
        $this->dropTable(Company::tableName());
    }
}
