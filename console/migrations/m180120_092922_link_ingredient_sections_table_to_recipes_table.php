<?php

use yii\db\Migration;

/**
 * Class m180120_092922_link_ingredient_sections_table_to_recipes_table
 */
class m180120_092922_link_ingredient_sections_table_to_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%ingredient_sections}}', 'recipe_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx-ingredient_sections-recipe_id', '{{%ingredient_sections}}', 'recipe_id');
        $this->addForeignKey('fk-ingredient_sections-recipe_id', '{{%ingredient_sections}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-ingredient_sections-recipe_id', '{{%ingredient_sections}}');
        $this->dropColumn('{{%ingredient_sections}}', 'recipe_id');
    }
}
