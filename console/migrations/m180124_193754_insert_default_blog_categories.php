<?php

use yii\db\Migration;

/**
 * Class m180124_193754_insert_default_blog_categories
 */
class m180124_193754_insert_default_blog_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->batchInsert('{{%blog_categories}}', ['name', 'slug'], [
            ['Обсуждение Рецептов', 'recipes-discussion'],
            ['Основы кулинарии', 'cooking-basic'],
            ['Юмор на кухне', 'humor'],
            ['О жизни', 'life'],
            ['Блог проекта', 'project'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->truncateTable('{{%blog_categories}}');
    }
}
