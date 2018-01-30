<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `articles`.
 */
class m180130_073650_add_slug_column_to_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%articles}}', 'slug', $this->string()->notNull()->after('image'));
        $this->createIndex('idx-articles-slug', '{{%articles}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%articles}}', 'slug');
    }
}
