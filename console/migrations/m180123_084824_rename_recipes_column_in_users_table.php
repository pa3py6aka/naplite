<?php

use yii\db\Migration;

/**
 * Class m180123_084824_rename_recipes_column_in_users_table
 */
class m180123_084824_rename_recipes_column_in_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameColumn('{{%users}}', 'recipes', 'recipes_count');
        $this->alterColumn('{{%users}}', 'recipes_count', $this->integer()->unsigned()->notNull()->defaultValue(0)->after('status'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameColumn('{{%users}}', 'recipes_count', 'recipes');
        $this->alterColumn('{{%users}}', 'recipes', $this->integer()->notNull()->defaultValue(0)->after('experience_id'));
    }
}
