<?php
use yii\db\Migration;

class m201214_114500_add_bik_column_to_organization_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%organization}}', 'bik', $this->string()->notNull()->defaultValue(''),);
    }

    public function down(){
        $this->dropColumn('{{%organization}}', 'bik');
    }
}