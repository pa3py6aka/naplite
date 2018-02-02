<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Blog\Blog;

/**
 * BlogSearch represents the model behind the search form of `core\entities\Blog\Blog`.
 */
class BlogSearch extends Blog
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
            [['id', 'author_id', 'category_id', 'views', 'comments_count', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'content'], 'safe'],
            [['author'], 'string'],
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
        $query = Blog::find()
            ->alias('b')
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
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'b.id' => $this->id,
            'b.author_id' => $this->author_id,
            'b.category_id' => $this->category_id,
            'b.views' => $this->views,
            'b.comments_count' => $this->comments_count,
        ]);

        $query->andFilterWhere(['like', 'b.title', $this->title])
            ->andFilterWhere(['like', 'b.slug', $this->slug])
            ->andFilterWhere(['like', 'b.content', $this->content])
            ->andFilterWhere(['like', 'u.username', $this->author])
            ->andFilterWhere(['>=', 'b.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'b.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
