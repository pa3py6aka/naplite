<?php

use yii\db\Migration;

/**
 * Class m180315_193622_add_pluralization_to_uoms
 */
class m180315_193622_add_pluralization_to_uoms extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%uoms}}', 'f2', $this->string(50)->notNull()->defaultValue(''));
        $this->addColumn('{{%uoms}}', 'f5', $this->string(50)->notNull()->defaultValue(''));

        $this->update('{{%uoms}}', ['name' => 'ч. ложка', 'f2' => 'ч. ложки', 'f5' => 'ч. ложек'], ['name' => 'ч. ложек']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%uoms}}', 'f2');
        $this->dropColumn('{{%uoms}}', 'f5');
    }
}
