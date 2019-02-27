<?php

namespace core\entities\Recipe\queries;


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

    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => Recipe::STATUS_ACTIVE]);
    }

    public function hidden($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => Recipe::STATUS_HIDDEN]);
    }
}
