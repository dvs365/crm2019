<?php
use yii\db\Migration;

class m200729_163000_add_close_id_column_to_todo_table extends Migration
{
    public function up()
    {
		$this->dropColumn('{{%todo}}', 'nameclient');
		$this->addColumn('{{%todo}}', 'created_id', $this->integer()->notNull());
		$this->addColumn('{{%todo}}', 'closed', $this->dateTime()->notNull());
        $this->addColumn('{{%todo}}', 'closed_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%todo}}', 'created_id');
        $this->dropColumn('{{%todo}}', 'closed');		
        $this->dropColumn('{{%todo}}', 'closed_id');
    }
}