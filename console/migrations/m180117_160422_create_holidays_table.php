<?php

use yii\db\Migration;

/**
 * Handles the creation of table `holidays`.
 */
class m180117_160422_create_holidays_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%holidays}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ], $tableOptions);

        $this->batchInsert('{{%holidays}}', ['name'], [
            ['Для детей'],
            ['Детский праздник'],
            ['Новый год'],
            ['Рождество'],
            ['День влюбленных'],
            ['На 23 февраля'],
            ['На 8 марта'],
            ['Пасха'],
            ['День рождения'],
            ['Для пикника'],
            ['Застолье на скорую руку'],
            ['Экономный праздник'],
            ['Полезное питание'],
            ['Постный вечер'],
            ['Для диеты'],
            ['Для беременных и кормящих'],
            ['Вегетарианский ужин'],
            ['Для мультиварки'],
            ['Для аэрогриля'],
            ['Для хлебопечки'],
            ['Для микроволновки'],
            ['На завтрак'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%holidays}}');
    }
}
