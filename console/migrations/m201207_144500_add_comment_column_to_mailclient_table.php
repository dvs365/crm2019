<?php
use yii\db\Migration;

class m201207_144500_add_comment_column_to_mailclient_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%mailclient}}', 'comment', $this->string()->notNull()->defaultValue(''));
    }

    public function down(){
        $this->dropColumn('{{%mailclient}}', 'comment');
    }
}