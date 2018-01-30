<?php

namespace core\repositories;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use yii\data\ActiveDataProvider;

class ArticleRepository
{
    public function get($id): Article
    {
        if (!$article = Article::findOne($id)) {
            throw new NotFoundException('Статья не найдена.');
        }
        return $article;
    }

    public function getBySlug($slug): Article
    {
        if (!$article = Article::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Статья не найдена.');
        }
        return $article;
    }

    public function getProvider(ArticleCategory $category, $search = null): ActiveDataProvider
    {
        $query = Article::find()->active();
        if (!$category->isRoot()) {
            $categoryIds[] = $category->id;
            foreach ($category->getDescendants()->all() as $child) {
                $categoryIds[] = $child->id;
            }
            $query->andWhere(['category_id' => $categoryIds]);
        }
        if ($search) {
            $query->andWhere(['like', 'title', $search]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 1, 'defaultPageSize' => 1],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function save(Article $article)
    {
        if (!$article->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Article $article)
    {
        if (!$article->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}