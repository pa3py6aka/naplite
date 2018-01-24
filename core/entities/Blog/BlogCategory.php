<?php

namespace core\entities\Blog;

use core\validators\SlugValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%blog_categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class BlogCategory extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%blog_categories}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['slug', SlugValidator::class],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Slug',
        ];
    }
}
