<?php

use yii\db\Migration;

/**
 * Class m180120_150444_fix_primary_key_in_ingredient_sections_table
 */
class m180120_150444_fix_primary_key_in_ingredient_sections_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-ingredients-section_id-ingredient_sections-id', '{{%ingredients}}');
        $this->dropPrimaryKey('pk-ingredient_sections', '{{%ingredient_sections}}');
        $this->alterColumn('{{%ingredient_sections}}', 'id', $this->primaryKey());
        $this->alterColumn('{{%ingredients}}', 'section_id', $this->integer()->notNull());
        $this->addForeignKey('fk-ingredients-section_id-ingredient_sections-id', '{{%ingredients}}', 'section_id', '{{%ingredient_sections}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180120_150444_fix_primary_key_in_ingredient_sections_table cannot be reverted.\n";
        return false;
    }
}
