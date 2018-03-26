<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m180117_165050_create_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%ingredient_sections}}', [
            'id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull()
        ], $tableOptions);
        $this->addPrimaryKey('pk-ingredient_sections', '{{%ingredient_sections}}', 'id');

        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'quantity' => $this->float()->notNull(),
            'uom' => $this->string(50)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-ingredients-section_id', '{{%ingredients}}', 'section_id');
        $this->addForeignKey('fk-ingredients-section_id-ingredient_sections-id', '{{%ingredients}}', 'section_id', '{{%ingredient_sections}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%ingredients}}');
        $this->dropTable('{{%ingredient_sections}}');
    }
}
