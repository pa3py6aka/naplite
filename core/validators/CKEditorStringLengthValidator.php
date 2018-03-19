<?php

namespace core\validators;


use yii\validators\Validator;

class CKEditorStringLengthValidator extends Validator
{
    public $min;
    public $max;

    public function init()
    {
        parent::init();
        $this->message = 'Текст должен быть от ' . $this->min . ' до ' . $this->max . ' символов';
    }

    public function validateAttribute($model, $attribute)
    {
        $value = strlen(strip_tags($model->$attribute));
        if ($value < 20 || $value > 500) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
var html = CKEDITOR.instances['{$attribute}'].ui.editor.getSnapshot(),
    dom = document.createElement("DIV");
dom.innerHTML=html;
var plain_text = (dom.textContent || dom.innerText);
if (plain_text.length < {$this->min} || plain_text.length > {$this->max}) {
    messages.push({$message});
}
JS;
    }
}