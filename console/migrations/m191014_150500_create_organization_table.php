<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 18:30
 */
use yii\db\Migration;

class m191014_150500_create_organization_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'form' => $this->integer(2)->notNull()->defaultValue(10),
            'jadds' => $this->string()->notNull()->defaultValue(''),
            'fadds' => $this->string()->notNull()->defaultValue(''),
            'director' => $this->string()->notNull()->defaultValue(''),
            'nds' => $this->integer(1)->notNull()->defaultValue(0),
            'phone' => $this->string()->notNull()->defaultValue(''),
            'mail' => $this->string()->notNull()->defaultValue(''),
            'inn' => $this->string()->notNull()->defaultValue(''),
            'ogrn' => $this->string()->notNull()->defaultValue(''),
            'kpp' => $this->string()->notNull()->defaultValue(''),
            'payment' => $this->string()->notNull()->defaultValue(''),
            'bank' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex(
            'idx-organization-id',
            '{{%organization}}',
            'id'
        );

        $this->createIndex(
            'idx-organization-client',
            '{{%organization}}',
            'client'
        );

        $this->addForeignKey(
            'fk-organization-client',
            '{{%organization}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-organization-client',
            '{{%organization}}'
        );

        $this->dropIndex(
            'idx-organization-id',
            '{{%organization}}'
        );

        $this->dropIndex(
            'idx-organization-client',
            '{{%organization}}'
        );

        $this->dropTable('{{%organization}}');
    }
}