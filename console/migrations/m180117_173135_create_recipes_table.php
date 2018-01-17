<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recipes`.
 */
class m180117_173135_create_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%recipes}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'kitchen_id' => $this->integer()->notNull(),
            'main_photo_id' => $this->integer(),
            'introductory_text' => $this->text()->notNull(),
            'cooking_time' => $this->smallInteger()->notNull()->defaultValue(0),
            'preparation_time' => $this->smallInteger()->notNull()->defaultValue(0),
            'persons' => $this->smallInteger()->notNull()->defaultValue(1),
            'complexity' => $this->smallInteger()->notNull()->defaultValue(1),
            'notes' => $this->text(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-recipes-author_id', '{{%recipes}}', 'author_id');
        $this->addForeignKey('fk-recipes-author_id-users-id', '{{%recipes}}', 'author_id', '{{%users}}', 'id', 'CASCADE');
        $this->createIndex('idx-recipes-category_id', '{{%recipes}}', 'category_id');
        $this->addForeignKey('fk-recipes-category_id-categories-id', '{{%recipes}}', 'category_id', '{{%categories}}', 'id', 'RESTRICT');
        $this->createIndex('idx-recipes-kitchen_id', '{{%recipes}}', 'kitchen_id');
        $this->addForeignKey('fk-recipes-kitchen_id-kitchens-id', '{{%recipes}}', 'kitchen_id', '{{%kitchens}}', 'id', 'RESTRICT');

        $this->createTable('{{%recipe_photos}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-recipe_photos-recipe_id}}', '{{%recipe_photos}}', 'recipe_id');
        $this->addForeignKey('{{%fk-recipe_photos-recipe_id-recipes-id}}', '{{%recipe_photos}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%recipe_steps}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'photo' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-recipe_steps-recipe_id}}', '{{%recipe_steps}}', 'recipe_id');
        $this->addForeignKey('{{%fk-recipe_steps-recipe_id-recipes-id}}', '{{%recipe_steps}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%recipe_steps}}');
        $this->dropTable('{{%recipe_photos}}');
        $this->dropTable('{{%recipes}}');
    }
}
