<?php

use yii\db\Migration;

/**
 * Class m180121_175444_add_columns_to_categories_table
 */
class m180121_175444_add_columns_to_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories}}', 'seo_text', $this->text()->after('description'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories}}', 'seo_text');
    }
}
