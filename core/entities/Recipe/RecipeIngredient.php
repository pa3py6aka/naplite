<?php

namespace core\entities\Recipe;

use core\entities\Uom;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property int $id
 * @property string $section_id
 * @property string $name
 * @property double $quantity
 * @property string $uom
 * @property int $uom_id [int(11)]
 *
 * @property IngredientSection $section
 * @property Uom $uomEntity
 */
class RecipeIngredient extends ActiveRecord
{
    public function getUomForm($form = 1)
    {
        if (!$this->uom_id) {
            return Html::encode($this->uom);
        }

        switch ($form) {
            case 1:
                return $this->uomEntity->name;
            case 2:
                return $this->uomEntity->f2 ?: $this->uomEntity->name;
            case 5:
                return $this->uomEntity->f5 ?: $this->uomEntity->name;
            default: return Html::encode($this->uom);
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_ingredients}}';
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['section_id', 'name', 'quantity', 'uom'], 'required'],
            [['section_id'], 'integer'],
            [['quantity'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['uom'], 'string', 'max' => 50],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => IngredientSection::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Раздел',
            'name' => 'Название',
            'quantity' => 'Количество',
            'uom' => 'Ед. измерения',
        ];
    }

    public function getSection(): ActiveQuery
    {
        return $this->hasOne(IngredientSection::className(), ['id' => 'section_id']);
    }

    public function getUomEntity(): ActiveQuery
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
    }
}
