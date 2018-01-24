<?php

use yii\db\Migration;

/**
 * Handles the creation of table `countries`.
 */
class m180122_150242_create_countries_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(2)->notNull()->defaultValue(''),
            'name' => $this->string(50)->notNull()->unique(),
        ], $tableOptions);

        $this->execute(file_get_contents(__DIR__ . '/dump/countries.sql'));

        $this->dropColumn('{{%users}}', 'country');
        $this->addColumn('{{%users}}', 'country_id', $this->integer()->after('username'));
        $this->addForeignKey('fk-users-country_id', '{{%users}}', 'country_id', '{{%countries}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-users-country_id', '{{%users}}');
        $this->dropColumn('{{%users}}', 'country_id');
        $this->addColumn('{{%users}}', 'country', $this->string(60)->notNull()->defaultValue(''));
        $this->dropTable('{{%countries}}');
    }
}
