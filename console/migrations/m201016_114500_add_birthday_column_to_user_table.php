<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:59
 */
use yii\db\Migration;

class m201016_114500_add_birthday_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'birthday', $this->dateTime()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'birthday');
    }
}