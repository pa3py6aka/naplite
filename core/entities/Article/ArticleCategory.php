<?php

namespace core\entities\Article;

use core\entities\Article\queries\ArticleCategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property Article[] $articles
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $parents
 * @property ArticleCategory[] $children
 * @property ArticleCategory $prev
 * @property ArticleCategory $next
 *
 * @mixin NestedSetsBehavior
 */
class ArticleCategory extends ActiveRecord
{
    public static function create($name, $slug, $description)
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->description = $description;
        return $category;
    }

    public function edit($name, $slug, $description)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
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
        return Yii::$app->params['frontendHostInfo'] . '/img/ico-book.png';
    }

    private function getIconName($slug = null)
    {
        return 'ico_art_cat-' . ($slug ?: $this->slug) . '.png';
    }

    public function getUrl(): string
    {
        return Url::to(['/articles/index', 'category' => $this->slug]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            if (isset($changedAttributes['slug']) && is_file(Yii::getAlias('@uploads/') . $this->getIconName($changedAttributes['slug']))) {
                rename(Yii::getAlias('@uploads/') . $this->getIconName($changedAttributes['slug']), Yii::getAlias('@uploads/') . $this->getIconName());
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        if (is_file(Yii::getAlias('@uploads/') . $this->getIconName())) {
            unlink(Yii::getAlias('@uploads/') . $this->getIconName());
        }
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_categories}}';
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

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['name', 'slug', 'lft', 'rgt', 'depth'], 'required'],
            [['description'], 'string'],
            [['lft', 'rgt', 'depth'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Slug',
            'description' => 'Описание',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ArticleCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleCategoryQuery(static::class);
    }
}
