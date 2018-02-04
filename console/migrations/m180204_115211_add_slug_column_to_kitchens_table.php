<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `kitchens`.
 */
class m180204_115211_add_slug_column_to_kitchens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%kitchens}}', 'slug', $this->string()->notNull()->defaultValue(''));
        $this->execute('UPDATE {{%kitchens}} SET slug="russian" WHERE id=1');
        $this->execute('UPDATE {{%kitchens}} SET slug="ukrainian" WHERE id=2');
        $this->execute('UPDATE {{%kitchens}} SET slug="eastern" WHERE id=3');
        $this->execute('UPDATE {{%kitchens}} SET slug="georgian" WHERE id=4');
        $this->createIndex('idx-kitchens-slug', '{{%kitchens}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%kitchens}}', 'slug');
    }
}
