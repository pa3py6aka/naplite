<?php

use yii\db\Migration;

/**
 * Class m180115_153622_add_user_email_confirm_token
 */
class m180115_153622_add_user_email_confirm_token extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'email_confirm_token', $this->string()->unique()->after('status'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'email_confirm_token');
    }
}
