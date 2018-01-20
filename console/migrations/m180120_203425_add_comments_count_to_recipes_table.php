<?php

use yii\db\Migration;

/**
 * Class m180120_203425_add_comments_count_to_recipes_table
 */
class m180120_203425_add_comments_count_to_recipes_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%recipes}}', 'comments_count', $this->integer()->notNull()->defaultValue(0)->after('rate'));
    }

    public function down()
    {
        $this->dropColumn('{{%recipes}}', 'comments_count');
    }
}
