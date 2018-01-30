<?php

use yii\db\Migration;

/**
 * Class m180130_150746_add_title_to_ingredients_table
 */
class m180130_150746_add_title_to_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%ingredients}}', 'title', $this->string()->notNull()->after('category_id'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ingredients}}', 'title');
    }
}
