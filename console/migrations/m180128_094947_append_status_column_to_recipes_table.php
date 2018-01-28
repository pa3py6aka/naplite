<?php

use yii\db\Migration;

/**
 * Class m180128_094947_append_status_column_to_recipes_table
 */
class m180128_094947_append_status_column_to_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%recipes}}', 'status', $this->smallInteger()
            ->notNull()
            ->defaultValue(\core\entities\Recipe::STATUS_ACTIVE)
            ->after('comments_notify'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%recipes}}', 'status');
    }
}
