<?php

namespace core\entities\queries;


use core\entities\Recipe\Recipe;
use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\core\entities\Recipe\Recipe]].
 *
 * @see \core\entities\Recipe\Recipe
 */
class RecipeQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;

    public function active()
    {
        return $this->andWhere(['status' => Recipe::STATUS_ACTIVE]);
    }
}
