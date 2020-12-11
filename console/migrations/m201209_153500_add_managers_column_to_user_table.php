<?php
use yii\db\Migration;

class m201209_153500_add_managers_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'managers', $this->string()->notNull()->defaultValue(''));
    }

    public function down(){
        $this->dropColumn('{{%user}}', 'managers');
    }
}