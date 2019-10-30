<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 22.10.19
 * Time: 17:10
 */
use yii\db\Migration;

class m191022_133000_rename_username_column_to_user_table extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%user}}', 'username', 'surname');

        $this->dropIndex(
            'username',
            '{{%user}}'
        );
    }

    public function down()
    {
        $this->renameColumn('{{%user}}', 'surname', 'username');

        $this->createIndex(
            'username',
            '{{%user}}',
            'username',
            true);
    }
}