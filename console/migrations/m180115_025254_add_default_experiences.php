<?php

use yii\db\Migration;

/**
 * Class m180115_025254_add_default_experiences
 */
class m180115_025254_add_default_experiences extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->batchInsert('{{%experiences}}', ['name', 'rate', 'recipes', 'system'], [
            ['Новичок', 0, 0, 1],
            ['Бывалый', 50, 15, 1],
            ['Опытный кулинар', 200, 30, 1],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->truncateTable('{{%experiences}}');
    }
}
