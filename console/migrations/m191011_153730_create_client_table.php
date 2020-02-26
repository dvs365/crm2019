<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 11.10.19
 * Time: 19:37
 */
use yii\db\Migration;

class m191011_153730_create_client_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%client}}', [
           'id' => $this->primaryKey(),
           'user' => $this->integer(4)->notNull(),
           'name' => $this->string()->notNull()->defaultValue(''),
           'address' => $this->string()->notNull()->defaultValue(''),
           'status' => $this->integer(1)->notNull(),
           'discount' =>$this->integer(2)->notNull(),
           'disconfirm' =>$this->integer(1)->notNull()->defaultValue(0),
           'discomment' =>$this->string()->notNull(),
           'update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
           'update_u' => $this->dateTime()->notNull(),
           'update_a' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-client-user',
            '{{%client}}',
            'user'
        );

        $this->addForeignKey(
            'fk-client-user',
            '{{%client}}',
            'user',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-client-user',
            '{{%client}}'
        );

        $this->dropIndex(
            'idx-client-id',
            '{{%client}}'
        );

        $this->dropIndex(
            'idx-client-user',
            '{{%client}}'
        );

        $this->dropTable('{{%client}}');
    }
}