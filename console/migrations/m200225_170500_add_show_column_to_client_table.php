<?php
use yii\db\Migration;

class m200225_170500_add_show_column_to_client_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%client}}', 'update_uid', $this->integer()->notNull());
        $this->addColumn('{{%client}}', 'update_aid', $this->integer()->notNull());
        $this->addColumn('{{%client}}', 'show', $this->dateTime()->notNull());
        $this->addColumn('{{%client}}', 'show_u', $this->dateTime()->notNull());
        $this->addColumn('{{%client}}', 'show_a', $this->dateTime()->notNull());
        $this->addColumn('{{%client}}', 'show_uid', $this->integer()->notNull());
        $this->addColumn('{{%client}}', 'show_aid', $this->integer()->notNull());
        $this->addColumn('{{%client}}', 'created', $this->dateTime()->notNull());
        $this->addColumn('{{%client}}', 'created_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'update_uid');
        $this->dropColumn('{{%client}}', 'update_aid');
        $this->dropColumn('{{%client}}', 'show');
        $this->dropColumn('{{%client}}', 'show_u');
        $this->dropColumn('{{%client}}', 'show_a');
        $this->dropColumn('{{%client}}', 'show_uid');
        $this->dropColumn('{{%client}}', 'show_aid');
        $this->dropColumn('{{%client}}', 'created');
        $this->dropColumn('{{%client}}', 'created_id');
    }
}