<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 15:26
 */
use yii\db\Migration;

class m191014_114530_create_phoneface_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%phoneface}}', [
            'id' => $this->primaryKey(),
            'face' => $this->integer(4)->notNull(),
            'number' => $this->integer()->notNull(),
            'number_mirror' => $this->integer()->notNull(),
            'comment' =>$this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-phoneface-id',
            '{{%phoneface}}',
            'id'
        );

        $this->createIndex(
            'idx-phoneface-face',
            '{{%phoneface}}',
            'face'
        );

        $this->addForeignKey(
            'fk-phoneface-face',
            '{{%phoneface}}',
            'face',
            '{{%face}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-phoneface-face',
            '{{%phoneface}}'
        );

        $this->dropIndex(
            'idx-phoneface-id',
            '{{%phoneface}}'
        );

        $this->dropIndex(
            'idx-phoneface-face',
            '{{%phoneface}}'
        );

        $this->dropTable('{{%phoneface}}');
    }
}