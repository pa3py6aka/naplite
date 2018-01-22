<?php

namespace widgets;


use Yii;
use yii\bootstrap\Widget;

class ModalAlertWidget extends Widget
{
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $messages = [];
        $show = false;
        $title = null;
        foreach ($flashes as $type => $data) {
            $data = (array) $data;
            foreach ($data as $message) {
                if ($message) {
                    $show = true;
                }
                if (is_array($message)) {
                    if (count($message) > 1) {
                        $mTitle = array_shift($message);
                        $title = $title ?: $mTitle;
                    }
                    $message = array_shift($message);
                }
                $messages[] = $message;
            }
            $session->removeFlash($type);
        }
        if ($show) {
            $this->showModal(implode('<br />', $messages), $title);
        }
    }

    private function showModal(string $message, string $title)
    {
        $js = <<<JS
    NaPlite.public.messageModal('{$title}', '{$message}');
JS;
        $this->view->registerJs($js);
    }
}