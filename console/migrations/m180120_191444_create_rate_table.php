<?php

use yii\db\Migration;

/**
 * Class m180120_191444_create_rate_tables
 */
class m180120_191444_create_rate_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%recipe_user_rates}}', [
            'recipe_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'value' => $this->smallInteger()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-recipe_user_rates-recipe_id', '{{%recipe_user_rates}}', 'recipe_id');
        $this->addPrimaryKey('pk-recipe_user_rates', '{{%recipe_user_rates}}', ['recipe_id', 'user_id']);
        $this->addForeignKey('fk-recipe_user_rates-recipe_id', '{{%recipe_user_rates}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-recipe_user_rates-user_id', '{{%recipe_user_rates}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('{{%recipes}}', 'rate', $this->integer()->notNull()->defaultValue(0)->after('notes'));
    }

    public function down()
    {
        $this->dropColumn('{{%recipes}}', 'rate');
        $this->dropTable('{{%recipe_user_rates}}');
    }
}
