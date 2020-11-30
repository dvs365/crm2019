<?php
use yii\db\Migration;

class m201130_134500_add_main_column_to_face_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%face}}', 'main', $this->integer(2)->notNull());
    }

    public function down(){
        $this->dropColumn('{{%face}}', 'comment');
    }
}