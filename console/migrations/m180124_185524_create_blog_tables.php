<?php

use yii\db\Migration;

/**
 * Class m180124_185524_create_blog_tables
 */
class m180124_185524_create_blog_tables extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $tableOptionsMb4 = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-blog_categories-slug', '{{%blog_categories}}', 'slug', true);

        $this->createTable('{{%blogs}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'views' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'comments_count' => $this->integer()->unsigned()->notNull()->defaultValue(0),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptionsMb4);
        $this->createIndex('ibaui', '{{%blogs}}', 'author_id');
        $this->addForeignKey('fbai', '{{%blogs}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('ibci', '{{%blogs}}', 'category_id');
        $this->addForeignKey('fbci', '{{%blogs}}', 'category_id', '{{%blog_categories}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%blog_comments}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'reply_to' => $this->integer(),
            'content' => $this->text()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptionsMb4);
        $this->createIndex('ibcbi', '{{%blog_comments}}', 'blog_id');
        $this->addForeignKey('fbcbi', '{{%blog_comments}}', 'blog_id', '{{%blogs}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fbcai', '{{%blog_comments}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fbcrt', '{{%blog_comments}}', 'reply_to', '{{%users}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%blog_comments}}');
        $this->dropTable('{{%blogs}}');
        $this->dropTable('{{%blog_categories}}');
    }
}
