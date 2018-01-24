<?php

namespace core\entities\Article\queries;

/**
 * This is the ActiveQuery class for [[\core\entities\Article\Article]].
 *
 * @see \core\entities\Article\Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this;
    }

    /**
     * @inheritdoc
     * @return \core\entities\Article\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \core\entities\Article\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
