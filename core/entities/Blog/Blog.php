<?php

namespace core\entities\Blog;

use core\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%blogs}}".
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $content
 * @property string $views
 * @property string $comments_count
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlogComment[] $blogComments
 * @property User $author
 */
class Blog extends ActiveRecord
{
    public function create($authorId, $title, $content): Blog
    {
        $blog = new self();
        $blog->author_id = $authorId;
        $blog->title = $title;
        $blog->content = $content;
        return $blog;
    }

    public function edit($title, $content): void
    {
        $this->title = $title;
        $this->content = $content;
    }

    public static function tableName(): string
    {
        return '{{%blogs}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
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
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'title' => 'Заголовк',
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
}
