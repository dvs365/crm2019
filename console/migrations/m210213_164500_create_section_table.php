<?php

use yii\db\Migration;

class m210213_164500_create_section_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%section}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex(
            'idx-section-id',
            '{{%section}}',
            'id'
        );

        $this->createIndex(
            'idx-section-pid',
            '{{%section}}',
            'pid'
        );
    }

    public function down()
    {
        $this->dropIndex(
            'idx-section-id',
            '{{%section}}'
        );

        $this->dropIndex(
            'idx-section-pid',
            '{{%section}}'
        );

        $this->dropTable('{{%section}}');
    }
}