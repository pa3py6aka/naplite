<?php

use yii\db\Migration;

/**
 * Class m180315_200221_add_uom_id_column_to_recipe_ingredients
 */
class m180315_200221_add_uom_id_column_to_recipe_ingredients extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%recipe_ingredients}}', 'uom_id', $this->integer());
        $this->addForeignKey('fk-recipe_ingredients-uom_id', '{{%recipe_ingredients}}', 'uom_id', '{{%uoms}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-recipe_ingredients-uom_id', '{{%recipe_ingredients}}');
        $this->dropColumn('{{%recipe_ingredients}}', 'uom_id');
    }
}
