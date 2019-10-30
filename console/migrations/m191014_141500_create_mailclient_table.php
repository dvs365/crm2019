<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 18:09
 */
use yii\db\Migration;

class m191014_141500_create_mailclient_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mailclient}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer(4)->notNull(),
            'mail' =>$this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-mailclient-id',
            '{{%mailclient}}',
            'id'
        );

        $this->createIndex(
            'idx-mailclient-client',
            '{{%mailclient}}',
            'client'
        );

        $this->addForeignKey(
            'fk-mailclient-client',
            '{{%mailclient}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-mailclient-client',
            '{{%mailclient}}'
        );

        $this->dropIndex(
            'idx-mailclient-id',
            '{{%mailclient}}'
        );

        $this->dropIndex(
            'idx-mailclient-client',
            '{{%mailclient}}'
        );

        $this->dropTable('{{%mailclient}}');
    }
}