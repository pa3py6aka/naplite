<?php

namespace core\entities\Recipe;

use core\access\Rbac;
use core\entities\Holiday;
use core\entities\Kitchen;
use core\entities\Recipe\Collection\Collection;
use core\entities\Recipe\Collection\CollectionRecipe;
use core\entities\Recipe\queries\RecipeQuery;
use core\entities\User\User;
use core\helpers\ContentHelper;
use core\jobs\MailJob;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Zelenin\yii\behaviors\Slug;

/**
 * This is the model class for table "{{%recipes}}".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $name
 * @property string $slug [varchar(255)]
 * @property int $kitchen_id
 * @property int $main_photo_id
 * @property string $introductory_text
 * @property int $cooking_time
 * @property int $preparation_time
 * @property int $persons
 * @property int $complexity
 * @property string $notes
 * @property int $rate [int(11)]
 * @property int $comments_count [int(11)]
 * @property int $favorites_count [int(11) unsigned]
 * @property bool $comments_notify [tinyint(1)]
 * @property int $status [smallint(6)]
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string|null $mainPhoto
 * @property string $url
 *
 * @property CollectionRecipe[] $collectionRecipes
 * @property Collection[] $collections
 * @property IngredientSection[] $ingredientSections
 * @property PhotoReport[] $photoReports
 * @property RecipeComment[] $recipeComments
 * @property Photo[] $recipePhotos
 * @property Photo|null $mainPhotoEntity
 * @property RecipeHoliday[] $recipeHolidays
 * @property Holiday[] $holidays
 * @property RecipeStep[] $recipeSteps
 * @property User $author
 * @property Category $category
 * @property Kitchen $kitchen
 */
class Recipe extends ActiveRecord
{
    const COMPLEXITY_EASY = 1;
    const COMPLEXITY_MIDDLE = 2;
    const COMPLEXITY_HARD = 3;

    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 5;

    public $complexityName;

    public static function create(
        $categoryId,
        $name,
        $kitchenId,
        $introductoryText,
        $cookingTime,
        $preparationTime,
        $persons,
        $complexity,
        $notes,
        $commentsNotify,
        $photos,
        $holidays,
        $steps
    ): Recipe
    {
        $recipe = new self();
        $recipe->author_id = Yii::$app->user->id;
        $recipe->category_id = $categoryId;
        $recipe->name = $name;
        $recipe->kitchen_id = $kitchenId;
        $recipe->introductory_text = $introductoryText;
        $recipe->cooking_time = $cookingTime;
        $recipe->preparation_time = $preparationTime;
        $recipe->persons = $persons;
        $recipe->complexity = $complexity;
        $recipe->notes = $notes;
        $recipe->comments_notify = $commentsNotify;
        $recipe->recipePhotos = $photos;
        $recipe->recipeHolidays = $holidays;
        $recipe->recipeSteps = $steps;
        $recipe->status = self::STATUS_ACTIVE;

        return $recipe;
    }

    public function edit(
        $categoryId,
        $name,
        $kitchenId,
        $introductoryText,
        $cookingTime,
        $preparationTime,
        $persons,
        $complexity,
        $notes,
        $commentsNotify,
        $photos,
        $steps
    ): void
    {
        $this->category_id = $categoryId;
        $this->name = $name;
        $this->kitchen_id = $kitchenId;
        $this->introductory_text = $introductoryText;
        $this->cooking_time = $cookingTime;
        $this->preparation_time = $preparationTime;
        $this->persons = $persons;
        $this->complexity = $complexity;
        $this->notes = $notes;
        $this->comments_notify = $commentsNotify;
        $this->recipePhotos = $photos;
        $this->recipeSteps = $steps;
    }

    public static function complexities(): array
    {
        return [
            self::COMPLEXITY_EASY => 'Легко',
            self::COMPLEXITY_MIDDLE => 'Средне',
            self::COMPLEXITY_HARD => 'Сложно',
        ];
    }

    public function getMainPhoto($small = false): ?string
    {
        if ($this->main_photo_id) {
            if ($photo = $this->mainPhotoEntity) {
                return Yii::$app->params['frontendHostInfo'] . '/photos/' . ($small ? 'sm_' : '') . $photo->file;
            }
        }
        if (count($this->recipePhotos)) {
            return Yii::$app->params['frontendHostInfo'] . '/photos/' . ($small ? 'sm_' : '') . $this->recipePhotos[0]->file;
        }
        return null;
    }

    public function getUrl($absolute = false): string
    {
        return $absolute ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['recipes/view', 'slug' => $this->slug]) :
            Url::to(['recipes/view', 'slug' => $this->slug]);
    }

    public static function statusesArray(): array
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Опубликован',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->introductory_text = ContentHelper::optimize($this->introductory_text);
            $this->notes = ContentHelper::optimize($this->notes);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if (!Yii::$app->user->can(Rbac::ROLE_MODERATOR)) {
                Yii::$app->queue->push(new MailJob([
                    'mailType' => MailJob::TYPE_NEW_RECIPE,
                    'recipeId' => $this->id,
                ]));
            }
        } else {
            if (isset($changedAttributes['rate'])) {
                $totalRate = Recipe::find()->active()->andWhere(['author_id' => $this->author_id])->sum('rate');
                User::updateAll(['rate' => $totalRate], ['id' => $this->author_id]);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        $this->complexityName = ArrayHelper::getValue(self::complexities(), $this->complexity);
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%recipes}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => [
                    'recipePhotos',
                    'recipeHolidays',
                    'recipeSteps',
                    'ingredientSections',
                ],
            ],
            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ],
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
     */
    public function rules(): array
    {
        return [
            //[['author_id', 'category_id', 'name', 'kitchen_id', 'introductory_text'], 'required'],
            //[['author_id', 'category_id', 'kitchen_id', 'main_photo_id', 'cooking_time', 'preparation_time', 'persons', 'complexity'], 'integer'],
            //[['introductory_text', 'notes'], 'string'],
            //[['name'], 'string', 'max' => 255],
            //[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            //[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            //[['kitchen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kitchen::className(), 'targetAttribute' => ['kitchen_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'category_id' => 'Категория',
            'name' => 'Название',
            'kitchen_id' => 'Кухня',
            'main_photo_id' => 'Главное фото',
            'introductory_text' => 'Вводный текст',
            'cooking_time' => 'Время приготовления',
            'preparation_time' => 'Время подготовки',
            'persons' => 'Кол-во персон',
            'complexityName' => 'Сложность',
            'notes' => 'Заметки',
            'rate' => 'Рейтинг',
            'comments_count' => 'Кол-во комментариев',
            'comments_notify' => 'Уведомления автору о новых комментариях',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getCollectionRecipes(): ActiveQuery
    {
        return $this->hasMany(CollectionRecipe::className(), ['recipe_id' => 'id'])
            ->indexBy('collection_id');
    }

    public function getCollections(): ActiveQuery
    {
        return $this->hasMany(Collection::className(), ['id' => 'collection_id'])
            ->viaTable('{{%collections_recipes}}', ['recipe_id' => 'id']);
    }

    public function getIngredientSections(): ActiveQuery
    {
        return $this->hasMany(IngredientSection::className(), ['recipe_id' => 'id']);
    }

    public function getPhotoReports(): ActiveQuery
    {
        return $this->hasMany(PhotoReport::className(), ['recipe_id' => 'id']);
    }

    public function getRecipeComments(): ActiveQuery
    {
        return $this->hasMany(RecipeComment::className(), ['recipe_id' => 'id']);
    }

    public function getRecipePhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::className(), ['recipe_id' => 'id'])
            ->orderBy(['sort' => SORT_ASC]);
    }

    public function getMainPhotoEntity(): ActiveQuery
    {
        return $this->hasOne(Photo::className(), ['id' => 'main_photo_id']);
    }

    public function getRecipeSteps(): ActiveQuery
    {
        return $this->hasMany(RecipeStep::className(), ['recipe_id' => 'id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getKitchen(): ActiveQuery
    {
        return $this->hasOne(Kitchen::className(), ['id' => 'kitchen_id']);
    }

    public function getRecipeHolidays(): ActiveQuery
    {
        return $this->hasMany(RecipeHoliday::className(), ['recipe_id' => 'id']);
    }

    public function getHolidays(): ActiveQuery
    {
        return $this->hasMany(Holiday::className(), ['id' => 'holiday_id'])->viaTable('{{%recipe_holidays}}', ['recipe_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \core\entities\Recipe\queries\RecipeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecipeQuery(get_called_class());
    }
}
