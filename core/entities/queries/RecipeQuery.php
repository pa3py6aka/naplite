<?php

namespace core\entities\queries;


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
        return $this;
    }
}
