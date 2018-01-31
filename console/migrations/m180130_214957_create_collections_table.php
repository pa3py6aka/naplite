<?php

use yii\db\Migration;

/**
 * Handles the creation of table `collections`.
 */
class m180130_214957_create_collections_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%collections}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'image' => $this->string(40)->notNull()->defaultValue(''),
            'category_id' => $this->integer()->null(),
            'sort' => $this->integer()->null()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-collections-slug', '{{%collections}}', 'slug', true);
        $this->addForeignKey('fk-collections-category_id', '{{%collections}}', 'category_id', '{{%categories}}', 'id', 'RESTRICT', 'CASCADE');

        $this->createTable('{{%collections_recipes}}', [
            'collection_id' => $this->integer()->notNull(),
            'recipe_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('pk-collections_recipes', '{{%collections_recipes}}', ['recipe_id', 'collection_id']);
        $this->createIndex('idx-collections_recipes-collection_id', '{{%collections_recipes}}', 'collection_id');
        $this->addForeignKey('fk-collections_recipes-collection_id', '{{%collections_recipes}}', 'collection_id', '{{%collections}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-collections_recipes-recipe_id', '{{%collections_recipes}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%collections_recipes}}');
        $this->dropTable('{{%collections}}');
    }
}
