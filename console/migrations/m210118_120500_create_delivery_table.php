<?php

use yii\db\Migration;

class m210118_120500_create_delivery_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%delivery}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer()->notNull(),
            'address' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex(
            'idx-delivery-id',
            '{{%delivery}}',
            'id'
        );

        $this->createIndex(
            'idx-delivery-client',
            '{{%delivery}}',
            'client'
        );

        $this->addForeignKey(
            'fk-delivery-client',
            '{{%delivery}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-delivery-client',
            '{{%delivery}}'
        );

        $this->dropIndex(
            'idx-delivery-id',
            '{{%delivery}}'
        );

        $this->dropIndex(
            'idx-delivery-client',
            '{{%delivery}}'
        );

        $this->dropTable('{{%delivery}}');
    }
}