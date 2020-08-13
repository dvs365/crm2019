<?php
/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 11.10.19
 * Time: 19:37
 */
use yii\db\Migration;

class m200813_192005_create_session_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

		$this->createTable('session', [
			'id' => $this->char(40)->notNull(),
			'expire' => $this->integer(),
			'data' => $this->binary(),
			'user_id' => $this->integer()
		]);

		$this->addPrimaryKey('session_pk', 'session', 'id');
    }

    public function down()
    {
        $this->dropIndex(
            'session_pk',
            '{{%session}}'
        );

        $this->dropTable('{{%session}}');
    }
}