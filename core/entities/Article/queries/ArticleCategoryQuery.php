<?php

namespace core\entities\Article\queries;

/**
 * This is the ActiveQuery class for [[\core\entities\Article\ArticleCategory]].
 *
 * @see \core\entities\Article\ArticleCategory
 */
class ArticleCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \core\entities\Article\ArticleCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \core\entities\Article\ArticleCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
