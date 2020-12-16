<?php
namespace app\components;

use Yii;
use yii\widgets\ActiveForm;

class CustomForm extends ActiveForm 
{
    public $layout;
    public $fieldClass = 'app\components\CustomFieldBootstrap';
}
