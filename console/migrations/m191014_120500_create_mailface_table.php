<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 15:40
 */
use yii\db\Migration;

class m191014_120500_create_mailface_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mailface}}', [
            'id' => $this->primaryKey(),
            'face' => $this->integer(4)->notNull(),
            'mail' =>$this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-mailface-id',
            '{{%mailface}}',
            'id'
        );

        $this->createIndex(
            'idx-mailface-face',
            '{{%mailface}}',
            'face'
        );

        $this->addForeignKey(
            'fk-mailface-face',
            '{{%mailface}}',
            'face',
            '{{%face}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-mailface-face',
            '{{%mailface}}'
        );

        $this->dropIndex(
            'idx-mailface-id',
            '{{%mailface}}'
        );

        $this->dropIndex(
            'idx-mailface-face',
            '{{%mailface}}'
        );

        $this->dropTable('{{%mailface}}');
    }
}