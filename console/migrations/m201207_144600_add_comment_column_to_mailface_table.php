<?php
use yii\db\Migration;

class m201207_144600_add_comment_column_to_mailface_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%mailface}}', 'comment', $this->string()->notNull()->defaultValue(''));
    }

    public function down(){
        $this->dropColumn('{{%mailface}}', 'comment');
    }
}