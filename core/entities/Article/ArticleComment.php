<?php

namespace core\entities\Article;

use core\entities\User\User;
use core\helpers\ContentHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%blog_comments}}".
 *
 * @property int $id
 * @property int $article_id
 * @property int $author_id
 * @property int $reply_to
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property Article $article
 * @property User $replyTo
 */
class ArticleComment extends ActiveRecord
{
    public static function create($articleId, $authorId, $content, $replyTo = null): ArticleComment
    {
        $comment = new self();
        $comment->article_id = $articleId;
        $comment->author_id = $authorId;
        $comment->content = $content;
        $comment->reply_to = $replyTo;
        return $comment;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->content = ContentHelper::optimize($this->content);
            return true;
        }
        return false;
    }

    public static function tableName(): string
    {
        return '{{%article_comments}}';
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
            [['article_id', 'author_id', 'content'], 'required'],
            [['article_id', 'author_id', 'reply_to'], 'integer'],
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
            'article_id' => 'Статья ID',
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

    public function getArticle(): ActiveQuery
    {
        return $this->hasOne(Article::className(), ['id' => 'blog_id']);
    }

    public function getReplyTo(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'reply_to']);
    }
}
