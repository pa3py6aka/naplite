<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Recipe\PhotoReport;

/**
 * PhotoReportSearch represents the model behind the search form of `core\entities\Recipe\PhotoReport`.
 */
class PhotoReportSearch extends PhotoReport
{
    public $user;
    public $recipe;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'recipe_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['file'], 'safe'],
            [['user', 'recipe'], 'string'],
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
        $query = PhotoReport::find()
            ->alias('pr')
            ->joinWith('user u')
            ->joinWith('recipe r');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['recipe'] = [
            'asc' => ['r.name' => SORT_ASC],
            'desc' => ['r.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pr.id' => $this->id,
            'pr.recipe_id' => $this->recipe_id,
            'pr.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'pr.file', $this->file])
            ->andFilterWhere(['like', 'u.username', $this->user])
            ->andFilterWhere(['like', 'r.name', $this->recipe])
            ->andFilterWhere(['>=', 'pr.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'pr.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
