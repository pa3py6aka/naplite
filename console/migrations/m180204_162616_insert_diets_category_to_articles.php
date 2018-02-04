<?php

use core\entities\Article\ArticleCategory;
use yii\db\Migration;

/**
 * Class m180204_162616_insert_diets_category_to_articles
 */
class m180204_162616_insert_diets_category_to_articles extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $parent = ArticleCategory::find()->where(['slug' => 'root'])->one();
        $category = ArticleCategory::create(
            'Диеты',
            'diets',
            ''
        );
        $category->appendTo($parent);
        $category->save();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180204_162616_insert_diets_category_to_articles cannot be reverted.\n";
        return false;
    }
}
