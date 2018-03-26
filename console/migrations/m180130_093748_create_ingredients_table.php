<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m180130_093748_create_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%ingredient_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-ingredient_categories-slug}}', '{{%ingredient_categories}}', 'slug', true);

        $this->insert('{{%ingredient_categories}}', [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'description' => null,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);

        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'prev_text' => $this->text()->notNull(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(40)->notNull()->defaultValue(''),
        ], $tableOptions);
        $this->createIndex('idx-ingredients-category_id', '{{%ingredients}}', 'category_id');
        $this->addForeignKey('fk-ingredients-category_id', '{{%ingredients}}', 'category_id', '{{%ingredient_categories}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%ingredients}}');
        $this->dropTable('{{%ingredient_categories}}');
    }
}
