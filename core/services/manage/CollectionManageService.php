<?php

namespace core\services\manage;


use core\entities\Recipe\Collection\Collection;
use core\forms\manage\CollectionForm;
use core\repositories\CollectionRepository;
use yii\web\UploadedFile;

class CollectionManageService
{
    private $repository;

    public function __construct(CollectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CollectionForm $form): Collection
    {
        $collection = Collection::create($form->title, $form->description, $form->categoryId ?: null);
        $this->repository->save($collection);

        if ($form->image instanceof UploadedFile) {
            $collection->saveImage($form->image);
            $this->repository->save($collection);
        }

        return $collection;
    }

    public function edit(Collection $collection, CollectionForm $form): void
    {
        $collection->edit($form->title, $form->description, $form->categoryId ?: null);
        $this->repository->save($collection);

        if ($form->image instanceof UploadedFile) {
            $collection->saveImage($form->image);
            $this->repository->save($collection);
        }
    }
}