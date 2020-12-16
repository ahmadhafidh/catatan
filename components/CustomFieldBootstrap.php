<?php
namespace app\components;

use Yii;
use yii\bootstrap4\ActiveField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


class CustomFieldBootstrap extends ActiveField 
{
    public $options = ['class' => ['widget' => 'form__group']];
    public $template = "{input}\n{label}\n{hint}\n{error}";


    public function dateInput($options = [])
    {
        if (!array_key_exists('class', $options)) {
            $options['class'] = "form__field pickadate";
        }
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function switch($options = [], $enclosedByLabel = true){
        $options['label'] = null;
        $isChecked = $this->model[$this->attribute] ? 'tp-checked' : null;
        $isDisabled = array_key_exists('disabled', $options) ? ( $options['disabled'] ? 'disabled' : '' ) : '';
        $options['class'] = "tp-inp";
        $this->parts['{label}'] = '';
        $this->parts['{error}'] = '';
        unset($options['labelOptions']);
        $options['hidden'] = true;
        $this->parts['{input}'] = '<div class="tap-toggle '.$isChecked.' '.$isDisabled.'">'.
        Html::activeCheckbox($this->model, $this->attribute, $options)
        .'</div>';
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        // d($options);
        // dd($this->attribute);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }
    
    public function fileInput($options = [])
    {
        
        $this->options = ['class' => ['widget' => '']];
        Html::addCssClass($options, ['widget' => 'form-control-file']);
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeFileInput($this->model, $this->attribute, $options);
        return $this;
    }
    public function dropDownList($items, $options = [])
    {
        if (!array_key_exists('class', $options)) {
            $options['class'] = "form__field select2";
        }
        $options = array_merge($this->inputOptions, $options);
        
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    protected function createLayoutConfig($instanceConfig)
    {
        $config = [
            'hintOptions' => [
                'tag' => 'small',
                'class' => ['form-text', 'text-muted'],
            ],
            'errorOptions' => [
                'tag' => 'div',
                'class' => 'invalid-feedback',
            ],
            'inputOptions' => [
                'class' => 'form__field',
                'placeholder' => "plc"
            ],
            'labelOptions' => [
                'class' => ['form__label']
            ]
        ];

        $layout = $instanceConfig['form']->layout;

        if ($layout === ActiveForm::LAYOUT_HORIZONTAL) {
            $config['template'] = "{beginWrapper}\n{input}\n{label}\n{error}\n{hint}\n{endWrapper}";
            $config['wrapperOptions'] = [];
            $config['labelOptions'] = [];
            $config['options'] = [];
            $cssClasses = [
                'offset' => ['col-sm-10', 'offset-sm-2'],
                'label' => ['col-sm-2', 'col-form-label'],
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
                'field' => 'form-group row'
            ];
            if (isset($instanceConfig['horizontalCssClasses'])) {
                $cssClasses = ArrayHelper::merge($cssClasses, $instanceConfig['horizontalCssClasses']);
            }
            $config['horizontalCssClasses'] = $cssClasses;

            Html::addCssClass($config['wrapperOptions'], $cssClasses['wrapper']);
            Html::addCssClass($config['labelOptions'], $cssClasses['label']);
            Html::addCssClass($config['errorOptions'], $cssClasses['error']);
            Html::addCssClass($config['hintOptions'], $cssClasses['hint']);
            Html::addCssClass($config['options'], $cssClasses['field']);
        } elseif ($layout === ActiveForm::LAYOUT_INLINE) {
            $config['inputOptions']['placeholder'] = true;
            $config['enableError'] = false;

            Html::addCssClass($config['labelOptions'], 'sr-only');
        }

        return $config;
    }
    public static function currency($num)
	{
		if($num) {
			return "Rp. ".number_format($num, 0, ",", ".");
		}
		else{
			return "Rp. 0";
		}
	}
}
