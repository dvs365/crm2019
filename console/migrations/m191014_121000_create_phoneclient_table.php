<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 15:59
 */
use yii\db\Migration;

class m191014_121000_create_phoneclient_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%phoneclient}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer(11)->notNull(),
            'number' => $this->string()->notNull()->defaultValue(''),
            'number_mirror' => $this->string()->notNull()->defaultValue(''),
            'comment' =>$this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-phoneclient-id',
            '{{%phoneclient}}',
            'id'
        );

        $this->createIndex(
            'idx-phoneclient-client',
            '{{%phoneclient}}',
            'client'
        );

        $this->createIndex(
            'idx-phoneclient-number_mirror',
            '{{%phoneclient}}',
            'number_mirror'
        );

        $this->addForeignKey(
            'fk-phoneclient-client',
            '{{%phoneclient}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-phoneclient-client',
            '{{%phoneclient}}'
        );

        $this->dropIndex(
            'idx-phoneclient-id',
            '{{%phoneclient}}'
        );

        $this->dropIndex(
            'idx-phoneclient-client',
            '{{%phoneclient}}'
        );

        $this->dropIndex(
            'idx-phoneclient-number_mirror',
            '{{%phoneclient}}'
        );

        $this->dropTable('{{%phoneclient}}');
    }
}