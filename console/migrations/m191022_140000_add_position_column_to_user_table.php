<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:34
 */
use yii\db\Migration;

class m191022_140000_add_position_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'position', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'position');
    }
}