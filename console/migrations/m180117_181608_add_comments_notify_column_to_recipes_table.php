<?php

use yii\db\Migration;

/**
 * Handles adding comments_notify to table `recipes`.
 */
class m180117_181608_add_comments_notify_column_to_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%recipes}}', 'comments_notify', $this->boolean()->notNull()->defaultValue(true)->after('notes'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%recipes}}', 'comments_notify');
    }
}
