<?php

use core\entities\Recipe\Recipe;
use yii\db\Migration;
use Zelenin\Ddd\String\Domain\Model\TransformerCollection;
use Zelenin\Ddd\String\Infrastructure\Service\Transformer;
use Zelenin\Ddd\String\Infrastructure\Service\Transformer\IntlTransliterateTransformer;
use Zelenin\Ddd\String\Infrastructure\Service\Transformer\UrlifyTransformer;

/**
 * Handles adding slug to table `recipes`.
 */
class m180205_170356_add_slug_column_to_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%recipes}}', 'slug', $this->string()->notNull()->defaultValue('')->after('name'));

        $transformer = new Transformer(new TransformerCollection([
            new IntlTransliterateTransformer('Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'),
            new UrlifyTransformer()
        ]));
        foreach (Recipe::find()->all() as $recipe) {
            $recipe->updateAttributes(['slug' => $transformer->transform($recipe->name)]);
        }

        $this->createIndex('idx-recipes-slug', '{{%recipes}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%recipes}}', 'slug');
    }
}
