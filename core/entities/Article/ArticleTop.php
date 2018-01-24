<?php

namespace core\entities\Article;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%articles_top}}".
 *
 * @property int $id
 * @property int $article_id
 * @property int $sort
 *
 * @property Article $article
 */
class ArticleTop extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles_top}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'sort'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => false, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
