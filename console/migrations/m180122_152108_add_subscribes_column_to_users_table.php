<?php

use yii\db\Migration;

/**
 * Handles adding subscribes to table `users`.
 */
class m180122_152108_add_subscribes_column_to_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%users}}', 'subscribes', $this->text()->notNull()->after('avatar'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%users}}', 'subscribes');
    }
}
