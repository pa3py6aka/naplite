<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%weights}}".
 *
 * @property int $id
 * @property string $name
 * @property int $glass250
 * @property int $glass200
 * @property int $spoon_big
 * @property int $spoon_tea
 * @property int $piece
 */
class Weight extends ActiveRecord
{
    public function afterFind()
    {
        $this->glass250 = $this->glass250 ?: '-';
        $this->glass200 = $this->glass200 ?: '-';
        $this->spoon_big = $this->spoon_big ?: '-';
        $this->spoon_tea = $this->spoon_tea ?: '-';
        $this->piece = $this->piece ?: '-';
        parent::afterFind();
    }

    public function beforeValidate()
    {
        $this->glass250 = (int) $this->glass250;
        $this->glass200 = (int) $this->glass200;
        $this->spoon_big = (int) $this->spoon_big;
        $this->spoon_tea = (int) $this->spoon_tea;
        $this->piece = (int) $this->piece;
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weights}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['glass250', 'glass200', 'spoon_big', 'spoon_tea', 'piece'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'glass250' => 'Стакан 250г',
            'glass200' => 'Стакан 200г',
            'spoon_big' => 'Столовая ложка',
            'spoon_tea' => 'Чайная ложка',
            'piece' => '1 шт.',
        ];
    }
}
