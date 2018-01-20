<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recipe_holidays`.
 */
class m180117_183703_create_recipe_holidays_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%recipe_holidays}}', [
            'recipe_id' => $this->integer()->notNull(),
            'holiday_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-recipe_holidays', '{{%recipe_holidays}}', ['recipe_id', 'holiday_id']);
        $this->createIndex('{{%idx-recipe_holidays-recipe_id}}', '{{%recipe_holidays}}', 'recipe_id');
        $this->addForeignKey('{{%fk-recipe_holidays-recipe_id-recipes-id}}', '{{%recipe_holidays}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-recipe_holidays-holiday_id-holidays-id}}', '{{%recipe_holidays}}', 'holiday_id', '{{%holidays}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%recipe_holidays}}');
    }
}
