<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:25
 */
use yii\db\Migration;

class m191022_135500_add_patronymic_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'patronymic', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'patronymic');
    }
}