<?php

use yii\db\Migration;

/**
 * Handles adding title to table `articles`.
 */
class m180123_141623_add_title_column_to_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%articles}}', 'title', $this->string()->notNull()->after('category_id'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%articles}}', 'title');
    }
}
