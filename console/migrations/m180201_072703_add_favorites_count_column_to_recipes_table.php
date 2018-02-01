<?php

use yii\db\Migration;

/**
 * Handles adding favorites_count to table `recipes`.
 */
class m180201_072703_add_favorites_count_column_to_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%recipes}}', 'favorites_count', $this->integer()->unsigned()->notNull()->defaultValue(0)->after('comments_count'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%recipes}}', 'favorites_count');
    }
}
