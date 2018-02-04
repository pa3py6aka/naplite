<?php

use yii\db\Migration;

/**
 * Class m180204_111039_add_columns_to_kitchens_table
 */
class m180204_111039_add_columns_to_kitchens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%kitchens}}', 'description', $this->text());
        $this->addColumn('{{%kitchens}}', 'image', $this->string(40)->notNull()->defaultValue(''));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%kitchens}}', 'description');
        $this->dropColumn('{{%kitchens}}', 'image');
    }
}
