<?php

use yii\db\Migration;

/**
 * Handles the creation of table `weights`.
 */
class m180129_072655_create_weights_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%weights}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'glass250' => $this->integer()->notNull()->defaultValue(0),
            'glass200' => $this->integer()->notNull()->defaultValue(0),
            'spoon_big' => $this->integer()->notNull()->defaultValue(0),
            'spoon_tea' => $this->integer()->notNull()->defaultValue(0),
            'piece' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%weights}}');
    }
}
