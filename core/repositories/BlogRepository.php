<?php

namespace core\repositories;


use core\entities\Blog\Blog;
use core\entities\Blog\BlogCategory;
use yii\data\ActiveDataProvider;

class BlogRepository
{
    /**
     * @param $id
     * @return Blog
     */
    public function get($id): Blog
    {
        if (!$blog = Blog::findOne($id)) {
            throw new NotFoundException('Пост не найден.');
        }
        return $blog;
    }

    public function getBySlug($slug): Blog
    {
        if (!$blog = Blog::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Пост не найден.');
        }
        return $blog;
    }

    public function getByCategoryAndSlug($categoryId, $slug): Blog
    {
        if (!$blog = Blog::find()->where(['slug' => $slug, 'category_id' => $categoryId])->limit(1)->one()) {
            throw new NotFoundException('Пост не найден.');
        }
        return $blog;
    }

    public function getCategoryBySlug($slug): BlogCategory
    {
        if (!$category = BlogCategory::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Раздел не найден.');
        }
        return $category;
    }

    public static function getCategories(): array
    {
        return BlogCategory::find()->all();
    }

    public function getProvider($categoryId = null, $search = null): ActiveDataProvider
    {
        $query = Blog::find()
            ->with('author', 'category');
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }
        if ($search) {
            $query->andWhere(['or', ['like', 'title', $search], ['like', 'content', $search]]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 1, 'defaultPageSize' => 1],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public static function getLast($count = 5)
    {
        return Blog::find()
            ->with('author', 'category')
            ->orderBy(['id' => SORT_DESC])
            ->limit($count)
            ->all();
    }

    public function updateViews(Blog $blog): void
    {
        $blog->updateCounters(['views' => 1]);
    }

    public function save(Blog $blog): void
    {
        if (!$blog->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Blog $blog): void
    {
        if (!$blog->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}