<?php

use yii\db\Migration;

/**
 * Handles the creation of table `uoms`.
 */
class m180117_170820_create_uoms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%uoms}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
        ], $tableOptions);

        $this->batchInsert('{{%uoms}}', ['name'], [
            ['ед.'],
            ['шт.'],
            ['ч. ложек'],
            ['грамм']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%uoms}}');
    }
}
