<?php

use yii\db\Migration;
use app\models\Objects;

class m170413_113215_Objects extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } else {
            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable(
            Objects::tableName(),
            [
                'id' => $this->primaryKey(11),
                'name' => $this->string(255),
                'description' => $this->text(),
                'type' => $this->boolean(),
                'company_id' => $this->integer(11),
                'file' => $this->string(255),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable(Objects::tableName());
        return false;
    }
}
