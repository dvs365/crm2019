<?php
use yii\db\Migration;

class m200124_144000_create_todo_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%todo}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'description' => $this->string()->notNull()->defaultValue(''),
            'nameclient' => $this->string()->notNull()->defaultValue(''),
            'date' => $this->dateTime()->notNull(),
            'dateto' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->createIndex(
            'idx-todo-id',
            '{{%todo}}',
            'id'
        );

        $this->createIndex(
            'idx-todo-date',
            '{{%todo}}',
            'date'
        );

        $this->createIndex(
            'idx-todo-client',
            '{{%todo}}',
            'client'
        );

        $this->addForeignKey(
            'fk-todo-client',
            '{{%todo}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-todo-client',
            '{{%todo}}'
        );

        $this->dropIndex(
            'idx-todo-id',
            '{{%todo}}'
        );

        $this->dropIndex(
            'idx-todo-client',
            '{{%todo}}'
        );

        $this->dropIndex(
            'idx-todo-date',
            '{{%todo}}'
        );
        $this->dropTable('{{%todo}}');
    }
}