<?php

namespace core\repositories;


use core\entities\Recipe\PhotoReport;
use core\entities\Recipe\Recipe;
use core\entities\User\User;
use yii\data\ActiveDataProvider;

class PhotoReportsRepository
{
    /**
     * @param $id
     * @return PhotoReport
     */
    public function get($id)
    {
        if (!$report = PhotoReport::findOne($id)) {
            throw new NotFoundException('Фото не найдено.');
        }
        return $report;
    }

    public function getUserPhotos($id): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => PhotoReport::find()
                ->andWhere(['user_id' => $id]),
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество фото на странице у пользователя
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function getPhotos(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => PhotoReport::find(),
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество фото на странице
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function save(PhotoReport $report)
    {
        if (!$report->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(PhotoReport $report)
    {
        if (!$report->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}