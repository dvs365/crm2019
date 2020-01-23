<?php
use yii\db\Migration;

class m200113_125010_add_website_column_to_client_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%client}}', 'website', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'website');
    }
}