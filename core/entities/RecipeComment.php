<?php

namespace core\entities;

use core\entities\User\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%recipe_comments}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $author_id
 * @property int $reply_to
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property Recipe $recipe
 * @property User $replyTo
 */
class RecipeComment extends ActiveRecord
{
    public static function create($recipeId, $authorId, $content, $replyTo = null): RecipeComment
    {
        $comment = new self();
        $comment->recipe_id = $recipeId;
        $comment->author_id = $authorId;
        $comment->content = $content;
        $comment->reply_to = $replyTo;
        return $comment;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id', 'author_id', 'content'], 'required'],
            [['recipe_id', 'author_id', 'reply_to'], 'integer'],
            [['content'], 'string'],
            //[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            //[['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            //[['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reply_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Recipe ID',
            'author_id' => 'Author ID',
            'reply_to' => 'Reply To',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(User::className(), ['id' => 'reply_to']);
    }
}
