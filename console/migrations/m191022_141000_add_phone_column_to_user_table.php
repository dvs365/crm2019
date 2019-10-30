<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:59
 */
use yii\db\Migration;

class m191022_141000_add_phone_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'phone', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'phone');
    }
}