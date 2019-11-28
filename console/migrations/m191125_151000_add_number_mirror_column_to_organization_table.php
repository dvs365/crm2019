<?php
use yii\db\Migration;

class m191125_151000_add_number_mirror_column_to_organization_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%organization}}', 'number_mirror', $this->string()->notNull()->defaultValue(''));
        $this->createIndex('idx-organization-number_mirror','{{%organization}}','number_mirror');
    }

    public function down()
    {
        $this->dropColumn('{{%organization}}', 'number_mirror');
        $this->dropIndex('idx-organization-number_mirror', '{{%organization}}');
    }
}
