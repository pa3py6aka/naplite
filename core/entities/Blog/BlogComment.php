<?php

namespace core\entities\Blog;

use core\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%blog_comments}}".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $author_id
 * @property int $reply_to
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property Blog $blog
 * @property User $replyTo
 */
class BlogComment extends ActiveRecord
{
    public static function create($blogId, $authorId, $content, $replyTo = null): BlogComment
    {
        $comment = new self();
        $comment->blog_id = $blogId;
        $comment->author_id = $authorId;
        $comment->content = $content;
        $comment->reply_to = $replyTo;
        return $comment;
    }

    public static function tableName(): string
    {
        return '{{%blog_comments}}';
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
            [['blog_id', 'author_id', 'content'], 'required'],
            [['blog_id', 'author_id', 'reply_to'], 'integer'],
            [['content'], 'string'],
            //[['author_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            //[['blog_id'], 'exist', 'skipOnError' => false, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
            //[['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reply_to' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Блог ID',
            'author_id' => 'Автор ID',
            'reply_to' => 'Ответ к ID',
            'content' => 'Контент',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getBlog(): ActiveQuery
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    public function getReplyTo(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'reply_to']);
    }
}
