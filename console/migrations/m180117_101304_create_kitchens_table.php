<?php

use yii\db\Migration;

/**
 * Handles the creation of table `kitchens`.
 */
class m180117_101304_create_kitchens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';

        $this->createTable('{{%kitchens}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->batchInsert('{{%kitchens}}', ['name'], [
            ['Русская'],
            ['Украинская'],
            ['Восточная'],
            ['Грузинская'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%kitchens}}');
    }
}
