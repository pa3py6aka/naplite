<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `blogs`.
 */
class m180125_011402_add_slug_column_to_blogs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%blogs}}', 'slug', $this->string()->notNull()->after('title'));
        $this->createIndex('ibs', '{{%blogs}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('ibs', '{{%blogs}}');
        $this->dropColumn('{{%blogs}}', 'slug');
    }
}
