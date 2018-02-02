<?php

use yii\db\Migration;

/**
 * Class m180202_211215_insert_default_categories
 */
class m180202_211215_insert_default_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/dump/categories.sql'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->execute('DELETE FROM {{%categories}} WHERE id > 1');
    }
}
