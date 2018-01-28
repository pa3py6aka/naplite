<?php

namespace core\entities\queries;


use core\entities\Recipe;
use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\core\entities\Recipe]].
 *
 * @see \core\entities\Recipe
 */
class RecipeQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;

    public function active()
    {
        return $this->andWhere(['status' => Recipe::STATUS_ACTIVE]);
    }
}
