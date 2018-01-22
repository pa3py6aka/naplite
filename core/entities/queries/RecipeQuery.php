<?php

namespace core\entities\queries;

/**
 * This is the ActiveQuery class for [[\core\entities\Recipe]].
 *
 * @see \core\entities\Recipe
 */
class RecipeQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this;
    }

    /**
     * @inheritdoc
     * @return \core\entities\Recipe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \core\entities\Recipe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
