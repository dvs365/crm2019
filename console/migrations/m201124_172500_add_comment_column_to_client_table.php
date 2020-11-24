<?php
use yii\db\Migration;

class m201124_172500_add_comment_column_to_client_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%client}}', 'comment', $this->string()->notNull()->defaultValue(''));
    }

    public function down(){
        $this->dropColumn('{{%client}}', 'comment');
    }
}