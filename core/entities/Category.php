<?php

namespace core\entities;

use core\entities\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    public static function create($name, $slug, $title, $description)
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        return $category;
    }

    public function edit($name, $slug, $title, $description)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
    }

    public function getHeadingTile()
    {
        return $this->title ?: $this->name;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function behaviors()
    {
        return [
            NestedSetsBehavior::className(),
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(static::class);
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['name', 'slug', 'meta_json', 'lft', 'rgt', 'depth'], 'required'],
            [['description', 'meta_json'], 'string'],
            [['lft', 'rgt', 'depth'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Slug',
            'title' => 'Заголовок',
            'description' => 'Описание',
        ];
    }
}
