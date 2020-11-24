<?php
use yii\db\Migration;

class m201124_154500_add_valid_column_to_organization_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%organization}}', 'valid', $this->integer(2)->notNull());
    }

    public function down(){
        $this->dropColumn('{{%organization}}', 'valid');
    }
}