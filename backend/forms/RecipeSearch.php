<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Recipe\Recipe;

/**
 * RecipeSearch represents the model behind the search form of `core\entities\Recipe\Recipe`.
 */
class RecipeSearch extends Recipe
{
    public $author;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'author_id', 'category_id', 'kitchen_id', 'main_photo_id', 'cooking_time', 'preparation_time', 'persons', 'complexity', 'rate', 'comments_count', 'comments_notify', 'created_at', 'updated_at'], 'integer'],
            [['name', 'introductory_text', 'notes', 'status'], 'safe'],
            ['author', 'string'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d.m.Y'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param bool $forCollection
     *
     * @return ActiveDataProvider
     */
    public function search($params, $forCollection = false)
    {
        $query = Recipe::find()->alias('r')->with('category');
        if (!$forCollection) {
            $query->joinWith('author u');
        } else {
            $query->with('collectionRecipes');
        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['author'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'r.id' => $this->id,
            'r.author_id' => $this->author_id,
            'r.category_id' => $this->category_id,
            'r.kitchen_id' => $this->kitchen_id,
            'r.main_photo_id' => $this->main_photo_id,
            'r.cooking_time' => $this->cooking_time,
            'r.preparation_time' => $this->preparation_time,
            'r.persons' => $this->persons,
            'r.complexity' => $this->complexity,
            'r.rate' => $this->rate,
            'r.comments_count' => $this->comments_count,
            'r.comments_notify' => $this->comments_notify,
            'r.status' => $this->status,
            //'r.created_at' => $this->created_at,
            //'r.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'r.name', $this->name])
            ->andFilterWhere(['like', 'r.introductory_text', $this->introductory_text])
            ->andFilterWhere(['like', 'r.notes', $this->notes])
            ->andFilterWhere(['like', 'u.username', $this->author])
            ->andFilterWhere(['>=', 'r.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'r.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
