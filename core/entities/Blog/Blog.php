<?php

namespace core\entities\Blog;

use core\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use Zelenin\yii\behaviors\Slug;

/**
 * This is the model class for table "{{%blogs}}".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id [int(11)]
 * @property string $title
 * @property string $slug [varchar(255)]
 * @property string $content
 * @property string $views
 * @property string $comments_count
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlogComment[] $blogComments
 * @property User $author
 * @property BlogCategory $category
 */
class Blog extends ActiveRecord
{
    public static function create($authorId, $categoryId, $title, $content): Blog
    {
        $blog = new self();
        $blog->author_id = $authorId;
        $blog->category_id = $categoryId;
        $blog->title = $title;
        $blog->content = $content;
        return $blog;
    }

    public function edit($categoryId, $title, $content): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->content = $content;
    }

    public function getUrl($forCP = false, $anchor = null): string
    {
        $url = ['/blog/view', 'category' => $this->category->slug, 'post' => $this->slug];
        if ($anchor) {
            $url['#'] = $anchor;
        }
        return $forCP ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl($url) :
            Url::to($url);
    }

    public static function tableName(): string
    {
        return '{{%blogs}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'title',
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    public function rules(): array
    {
        return [
            [['author_id', 'title', 'content'], 'required'],
            [['author_id', 'views', 'comments_count'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            //[['author_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => false, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'content' => 'Контент',
            'views' => 'Просмотры',
            'comments_count' => 'Комментариев',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getBlogComments(): ActiveQuery
    {
        return $this->hasMany(BlogComment::className(), ['blog_id' => 'id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category_id']);
    }
}
