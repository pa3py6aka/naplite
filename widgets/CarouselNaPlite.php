<?php

namespace widgets;


use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CarouselNaPlite extends Carousel
{
    public function renderItem($item, $index)
    {
        if (is_string($item)) {
            $content = $item;
            $caption = null;
            $options = [];
        } elseif (isset($item['content'])) {
            $content = $item['content']
                . '<span class="top_articles_box_grad"></span>'
                . '<a href="' . $item['url'] . '" class="top_articles_box_cover"></a>';
            $caption = ArrayHelper::getValue($item, 'caption');
            if ($caption !== null) {
                $caption = Html::tag('span', $caption, ['class' => 'top_articles_box_th']);
            }
            $options = ArrayHelper::getValue($item, 'options', []);
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }

        Html::addCssClass($options, ['widget' => 'item']);
        if ($index === 0) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('div', $content . "\n" . $caption, $options);
    }

    public function renderControls()
    {
        if (isset($this->controls[0], $this->controls[1])) {
            return '<span class="top_articles_box_arrows">'
                . Html::a($this->controls[0], '#' . $this->options['id'], [
                    'class' => 'top_articles_box_arrows_left',
                    'data-slide' => 'prev',
                ]) . "\n"
                . '<span class="top_articles_box_arrows_center">1/' . (count($this->items)) . '</span>'
                . Html::a($this->controls[1], '#' . $this->options['id'], [
                    'class' => 'top_articles_box_arrows_right',
                    'data-slide' => 'next',
                ])
                . '</span>';
        } elseif ($this->controls === false) {
            return '';
        } else {
            throw new InvalidConfigException('The "controls" property must be either false or an array of two elements.');
        }
    }
}