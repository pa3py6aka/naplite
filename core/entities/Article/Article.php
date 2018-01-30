<?php

namespace core\entities\Article;

use core\entities\Article\queries\ArticleQuery;
use core\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Zelenin\yii\behaviors\Slug;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $title [varchar(255)]
 * @property string $prev_text
 * @property string $content
 * @property string $image
 * @property string $slug [varchar(255)]
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property ArticleCategory $category
 * @property ArticleComment[] $comments
 */
class Article extends ActiveRecord
{
    public static function create($authorId, $categoryId, $title, $prevText, $content): Article
    {
        $article = new self();
        $article->author_id = $authorId;
        $article->category_id = $categoryId;
        $article->title = $title;
        $article->prev_text = $prevText;
        $article->content = $content;
        return $article;
    }

    public function edit($categoryId, $title, $prevText, $content): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->prev_text = $prevText;
        $this->content = $content;
    }

    public function saveImage(UploadedFile $image): void
    {
        $name = $this->id . '_' . time() . '.' . $image->extension;
        $thumbName = 'th_' . $name;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 231, 148, $path . $thumbName);
            Yii::$app->photoSaver->fitBySize($path . $name, 860, 560);
            if ($this->image && $this->image != $name) {
                $this->removeImages();
            }
            $this->image = $name;
        }
    }

    private function removeImages(): void
    {
        if ($this->image) {
            $path = $this->getImagePath();
            if (is_file($path . $this->image)) {
                unlink($path . $this->image);
            }
            if (is_file($path . 'th_' . $this->image)) {
                unlink($path . 'th_' . $this->image);
            }
        }
    }

    public function getImageUrl($thumb = true, $forCP = false): ?string
    {
        if (!$this->image) {
            return null;
        }
        return ($forCP ? Yii::$app->params['frontendHostInfo'] : '') . '/uploads/art/' . ($thumb ? 'th_' : '') . $this->image;
    }

    private function getImagePath(): string
    {
        return Yii::getAlias('@uploads') . '/art/';
    }

    public function getUrl($forCP = false)
    {
        return $forCP ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['/articles/view', 'slug' => $this->slug]) :
            Url::to(['/articles/view', 'slug' => $this->slug]);
    }

    public function afterDelete()
    {
        $this->removeImages();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'title',
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['author_id', 'category_id', 'title', 'prev_text', 'content'], 'required'],
            [['author_id', 'category_id'], 'integer'],
            [['title', 'prev_text', 'content'], 'string'],
            [['image'], 'string', 'max' => 40],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'title' => 'Заголовок',
            'prev_text' => 'Превью-текст',
            'content' => 'Контент',
            'image' => 'Изображение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(ArticleComment::className(), ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
