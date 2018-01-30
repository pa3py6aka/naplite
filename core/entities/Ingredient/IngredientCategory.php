<?php

namespace core\entities\Ingredient;

use core\entities\Ingredient\queries\IngredientCategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%ingredient_categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property Ingredient[] $ingredients
 * @property IngredientCategory $parent
 * @property IngredientCategory[] $parents
 * @property IngredientCategory[] $children
 * @property IngredientCategory $prev
 * @property IngredientCategory $next
 *
 * @mixin NestedSetsBehavior
 */
class IngredientCategory extends ActiveRecord
{
    public static function create($name, $slug, $description): IngredientCategory
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->description = $description;
        return $category;
    }

    public function edit($name, $slug, $description): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
    }

    public function getIcon($onlySelf = false): ?string
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
        return Yii::$app->params['frontendHostInfo'] . '/img/ico-ing.png';
    }

    private function getIconName($slug = null): string
    {
        return 'ico_ing_cat-' . ($slug ?: $this->slug) . '.png';
    }

    public function getUrl(): string
    {
        return Url::to(['/ingredients/index', 'category' => $this->slug]);
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
        return '{{%ingredient_categories}}';
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

    public function getIngredients(): ActiveQuery
    {
        return $this->hasMany(Ingredient::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return IngredientCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IngredientCategoryQuery(static::class);
    }
}
