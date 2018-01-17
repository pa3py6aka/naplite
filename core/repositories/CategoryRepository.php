<?php

namespace core\repositories;


use core\entities\Category;

class CategoryRepository
{
    /**
     * @param $id
     * @return Category
     */
    public function get($id)
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('категория не найдена.');
        }
        return $category;
    }

    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}