<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Recipe;

/**
 * RecipeSearch represents the model behind the search form of `core\entities\Recipe`.
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
            [['name', 'introductory_text', 'notes'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Recipe::find()
            ->alias('r')
            ->joinWith('author u')
            ->with('category');

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'kitchen_id' => $this->kitchen_id,
            'main_photo_id' => $this->main_photo_id,
            'cooking_time' => $this->cooking_time,
            'preparation_time' => $this->preparation_time,
            'persons' => $this->persons,
            'complexity' => $this->complexity,
            'r.rate' => $this->rate,
            'comments_count' => $this->comments_count,
            'comments_notify' => $this->comments_notify,
            //'r.created_at' => $this->created_at,
            //'r.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'introductory_text', $this->introductory_text])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'u.username', $this->author])
            ->andFilterWhere(['>=', 'r.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'r.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
