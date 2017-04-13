<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

use yii\db\Migration;
use app\models\User;

class m170413_072339_User extends Migration
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
            User::tableName(),
            [
                'id'            => $this->primaryKey(11),
                'full_name'     => $this->string(255)->notNull(),
                'email'         => $this->string(255)->notNull(),
                'avatar'        => $this->string(255)->defaultValue(''),
                'status'        => $this->boolean()->defaultValue(1),
                'auth_key'      => $this->string(32)->null()->defaultValue(null),
                'password_hash' => $this->string(255)->notNull(),
                'company_id'    => $this->integer(11)->notNull()
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable(User::tableName());
    }
}
