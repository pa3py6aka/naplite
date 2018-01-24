<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m180123_101922_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%article_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-article_categories-slug}}', '{{%article_categories}}', 'slug', true);

        $this->insert('{{%article_categories}}', [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'description' => null,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);

        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'prev_text' => $this->text()->notNull(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(40)->notNull()->defaultValue(''),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-articles-author_id', '{{%articles}}', 'author_id');
        $this->addForeignKey('fk-articles-author_id', '{{%articles}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx-articles-category_id', '{{%articles}}', 'category_id');
        $this->addForeignKey('fk-articles-category_id', '{{%articles}}', 'category_id', '{{%article_categories}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%articles}}');
        $this->dropTable('{{%article_categories}}');
    }
}
