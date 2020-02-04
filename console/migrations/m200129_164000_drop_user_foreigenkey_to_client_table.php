<?php
use yii\db\Migration;

class m200129_164000_drop_user_foreigenkey_to_client_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->dropForeignKey(
            'fk-client-user',
            '{{%client}}'
        );
    }

    public function down()
    {
        $this->addForeignKey(
            'fk-client-user',
            '{{%client}}',
            'user',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}