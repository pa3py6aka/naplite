<?php

namespace widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class Pager extends LinkPager
{
    public $options = ['class' => 'paginator'];

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();
        list($beginPage, $endPage) = $this->getPageRange();

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = Html::tag(
                'div',
                $this->renderPageButton('<i class="fa fa-arrow-left"></i>', $page, 'b_brown', $currentPage <= 0, false),
                ['class' => 'paginator_left']
            );
        }

        $centerButtons = [];
        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $centerButtons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
            if ($beginPage > 1) {
                $centerButtons[] = '<li>' . $this->renderPageButton('...', 0, $this->firstPageCssClass, true, false) . '</li>';
            }
        }

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $centerButtons[] = '<li>' . $this->renderPageButton($i + 1, $i, null, $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage) . '</li>';
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            if ($endPage < $pageCount - 2) {
                $centerButtons[] = '<li>' . $this->renderPageButton('...', 0, $this->lastPageCssClass, true, false) . '</li>';
            }
            $centerButtons[] = '<li>' . $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false) . '</li>';
        }

        $buttons[] = Html::tag(
            'div',
            Html::tag('ul', implode("\n", $centerButtons)),
            ['class' => 'paginator_center']
        );

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = Html::tag(
                'div',
                $this->renderPageButton(
                    '<span class="hidden1000">Следующая страница</span><i class="fa fa-arrow-right"></i>',
                    $page,
                    'b_brown',
                    $currentPage >= $pageCount - 1,
                    false
                ),
                ['class' => 'paginator_right']
            );
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        return Html::tag('div', implode("\n", $buttons), $options);
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'span');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $this->disabledListItemSubTagOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $linkOptions['class'] = 'pjax';
        if ($class) {
            $linkOptions['class'] .= ' ' . $class;
        }

        if ($active) {
            $linkOptions['class'] .= ' paginator_active';
        }

        return Html::a($label, $this->pagination->createUrl($page), $linkOptions);
    }
}