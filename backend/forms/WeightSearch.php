<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Weight;

/**
 * WeightSearch represents the model behind the search form of `core\entities\Weight`.
 */
class WeightSearch extends Weight
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'glass250', 'glass200', 'spoon_big', 'spoon_tea', 'piece'], 'safe'],
            [['name'], 'safe'],
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
        $query = Weight::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);

        $this->load($params);

        /*if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'glass250' => $this->glass250,
            'glass200' => $this->glass200,
            'spoon_big' => $this->spoon_big,
            'spoon_tea' => $this->spoon_tea,
            'piece' => $this->piece,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
