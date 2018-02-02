<?php

namespace backend\forms;


use core\entities\Ingredient\IngredientCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class IngredientCategorySearch extends Model
{
    public $id;
    public $name;
    public $slug;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = IngredientCategory::find()->andWhere(['>', 'depth', 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['lft' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);
        return $dataProvider;
    }
}