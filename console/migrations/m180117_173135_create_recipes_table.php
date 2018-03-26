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
        $tableOptionsMb4 = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

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
        ], $tableOptionsMb4);

        $this->createIndex('irai', '{{%recipes}}', 'author_id');
        $this->addForeignKey('fraiui', '{{%recipes}}', 'author_id', '{{%users}}', 'id', 'CASCADE');
        $this->createIndex('irci', '{{%recipes}}', 'category_id');
        $this->addForeignKey('frcici', '{{%recipes}}', 'category_id', '{{%categories}}', 'id', 'RESTRICT');
        $this->createIndex('irki', '{{%recipes}}', 'kitchen_id');
        $this->addForeignKey('frkiki', '{{%recipes}}', 'kitchen_id', '{{%kitchens}}', 'id', 'RESTRICT');

        $this->createTable('{{%recipe_photos}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-recipe_photos-recipe_id', '{{%recipe_photos}}', 'recipe_id');
        $this->addForeignKey('fk-recipe_photos-recipe_id-recipes-id', '{{%recipe_photos}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%recipe_steps}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'photo' => $this->string()->notNull(),
        ], $tableOptionsMb4);

        $this->createIndex('irsri}}', '{{%recipe_steps}}', 'recipe_id');
        $this->addForeignKey('frsriri}}', '{{%recipe_steps}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%recipe_steps}}');
        $this->dropTable('{{%recipe_photos}}');
        $this->dropTable('{{%recipes}}');
    }
}
