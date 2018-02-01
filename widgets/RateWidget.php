<?php

namespace widgets;


use core\entities\Recipe\RecipeUserRate;
use Yii;
use yii\base\Widget;

class RateWidget extends Widget
{
    public $recipe;

    public function run()
    {
        $userRate = 0;
        if (!Yii::$app->user->isGuest) {
            $userRate = RecipeUserRate::find()
                ->select('value')
                ->where(['recipe_id' => $this->recipe->id, 'user_id' => Yii::$app->user->id])
                ->scalar();
        }

        $this->view->registerJs($this->getJs());
        return $this->render('rate-block', [
            'userRate' => $userRate,
            'currentRate' => $this->recipe->rate,
            'recipeId' => $this->recipe->id]);
    }

    private function getJs()
    {
        return <<<JS
            $('.rateLink').on('click', function (e) {
                var value = $(this).attr('data-value');
                var recipeId = $(this).parent().attr('data-recipe-id');
                
                $('.rateLink').removeClass('active');
                $('.rateLink:lt(' + value + ')').addClass('active');
                
                $.ajax({
                    url: '/recipes/rate',
                    method: "post",
                    dataType: "json",
                    data: {value: value, id: recipeId},
                    success: function(data, textStatus, jqXHR) {
                        if (data.result === 'success') {
                            $('[data-rate-total]').attr('data-rate-total', data.rate)
                                .html(data.rate);
                        }
                    }
                });
            });
JS;
    }
}