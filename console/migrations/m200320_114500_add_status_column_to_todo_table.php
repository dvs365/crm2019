<?php
use yii\db\Migration;

class m200320_114500_add_status_column_to_todo_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%todo}}', 'status', $this->integer(2)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%todo}}', 'status');
    }
}