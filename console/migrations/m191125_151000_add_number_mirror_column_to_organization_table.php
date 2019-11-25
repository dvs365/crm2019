<?php
use yii\db\Migration;

class m191125_151000_add_number_mirror_column_to_organization_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%organization}}', 'number_mirror', $this->integer(13)->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn('{{%organization}}', 'number_mirror');
    }
}
