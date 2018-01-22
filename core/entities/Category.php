<?php

namespace core\entities;

use core\entities\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $seo_text
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property string|null $imageUrl
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 *
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    public static function create($name, $slug, $title, $description, $seoText)
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->seo_text = $seoText;
        return $category;
    }

    public function edit($name, $slug, $title, $description, $seoText)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->seo_text = $seoText;
    }

    public function getHeadingTile()
    {
        return $this->title ?: $this->name;
    }

    public function getIcon($onlySelf = false)
    {
        if (is_file(Yii::getAlias('@uploads/') . $this->getIconName())) {
            return Yii::$app->params['frontendHostInfo'] . '/uploads/' . $this->getIconName();
        }
        if ($onlySelf) {
            return null;
        }
        if ($this->depth > 1){
            foreach ($this->parents as $parent) {
                if (!$parent->isRoot()) {
                    if (is_file(Yii::getAlias('@uploads/') . $parent->getIconName())) {
                        return Yii::$app->params['frontendHostInfo'] . '/uploads/' . $parent->getIconName();
                    }
                }
            }
        }
        return Yii::$app->params['frontendHostInfo'] . '/img/bg_dashed.png';
    }

    private function getIconName()
    {
        return 'ico_cat-' . $this->slug . '.png';
    }

    public function getImageUrl($fromCP = false)
    {
        return is_file(Yii::getAlias('@uploads') . '/cat-' . $this->slug . '.jpg') ?
            Yii::$app->params['frontendHostInfo'] . '/uploads/cat-' . $this->slug . '.jpg' :
            ($fromCP ? null : Yii::$app->params['frontendHostInfo'] . '/img/category-empty.jpg');
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
