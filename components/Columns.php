<?php
namespace app\components;
use Closure;
use yii\base\BaseObject;
use yii\helpers\Html;

class Columns extends \yii\grid\DataColumn
{
    public $label = 'Search';
    public $filter = 'text';
    public function init()
    {
        $model = $this->grid->filterModel;
        if ($this->filter) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            $this->header = $this->filter . $error; 
            if ($this->filter == 'text') {
                $this->header = '
                <div class="form__group">
                    '.Html::activeTextInput($model, $this->attribute, ['class' => 'form__field', 'id' => null, 'placeholder' => $this->label]) . $error.'
                    <label for="" class="form__label">'. $this->label .'</label>
                    <span class="icon-form feather fe-search"></span>
                </div>';
            }elseif($this->filter == 'pickadate'){
                $this->header = '
                <div class="form__group">
                    '.Html::activeTextInput($model, $this->attribute, ['class' => 'form__field pickadate', 'id' => null, 'placeholder' => $this->label]) . $error.'
                    <label for="" class="form__label">'. $this->label .'</label>
                    <span class="icon-form feather fe-calendar"></span>
                </div>';
            }
        }
        parent::init();
    }
}
