<?php

use yii\db\Migration;

/**
 * Class m180130_093012_rename_ingredients_table
 */
class m180130_093012_rename_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameTable('{{%ingredients}}', '{{%recipe_ingredients}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameTable('{{%recipe_ingredients}}', '{{%ingredients}}');
    }
}
