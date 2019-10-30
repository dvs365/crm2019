<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 14.10.19
 * Time: 14:38
 */
use yii\db\Migration;

class m191014_104530_create_face_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%face}}', [
            'id' => $this->primaryKey(),
            'client' => $this->integer()->notNull(),
            'fullname' => $this->string()->notNull()->defaultValue(''),
            'position' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex(
            'idx-face-id',
            '{{%face}}',
            'id'
        );

        $this->createIndex(
            'idx-face-client',
            '{{%face}}',
            'client'
        );

        $this->addForeignKey(
            'fk-face-client',
            '{{%face}}',
            'client',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-face-client',
            '{{%face}}'
        );

        $this->dropIndex(
            'idx-face-id',
            '{{%face}}'
        );

        $this->dropIndex(
            'idx-face-client',
            '{{%face}}'
        );

        $this->dropTable('{{%face}}');
    }
}