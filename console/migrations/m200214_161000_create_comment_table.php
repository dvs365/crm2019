<?php
use yii\db\Migration;

class m200214_161000_create_comment_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'client' => $this->integer()->notNull(),
            'text' => $this->string()->notNull()->defaultValue(''),
            'date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-comment-id',
            '{{%comment}}',
            'id'
        );

        $this->createIndex(
            'idx-comment-client',
            '{{%comment}}',
            'client'
        );

        $this->addForeignKey(
            'fk-comment-client',
            '{{%comment}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-comment-client',
            '{{%comment}}'
        );

        $this->dropIndex(
            'idx-comment-id',
            '{{%comment}}'
        );

        $this->dropIndex(
            'idx-comment-client',
            '{{%comment}}'
        );

        $this->dropTable('{{%comment}}');
    }
}