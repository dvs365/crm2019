<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:18
 */
use yii\db\Migration;

class m191022_134500_add_name_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'name', $this->string()->notNull());
    }

    public function down(){
        $this->dropColumn('{{%user}}', 'name');
    }
}