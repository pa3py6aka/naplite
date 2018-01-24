<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles_top`.
 */
class m180123_224825_create_articles_top_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%articles_top}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'sort' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('fk-articles_top-article_id', '{{%articles_top}}', 'article_id', '{{%articles}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%articles_top}}');
    }
}
