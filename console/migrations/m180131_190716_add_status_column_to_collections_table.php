<?php

use yii\db\Migration;

/**
 * Handles adding status to table `collections`.
 */
class m180131_190716_add_status_column_to_collections_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%collections}}', 'status', $this->boolean()->notNull()->defaultValue(true)->after('sort'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%collections}}', 'status');
    }
}
