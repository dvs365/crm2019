<?php
use yii\db\Migration;

class m200226_170500_add_note_column_to_client_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%client}}', 'note', $this->string()->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'note');
    }
}