<?php
namespace app\components;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

class TableOptions 
{
    static $template = ['date-filter', 'download'];
    static $searchModel;
    static $export;
    static $export_format = [
        'xlsx','xls', 'pdf'
    ];
    public function __construct($config=null)
    {
        if ($config['export']!=null) {

            $export = $config['export'];
            
            if (!array_key_exists('items', $config['export'])) {
                $config['export']['items'] = self::$export_format;
            }
            self::$export = $config['export'];
        }
        if ($config['searchModel'] != null) {
            self::$export = $config['export'];
        }
        self::$searchModel = $config['searchModel'];
    }

    // public function widget(Array $config)
    // {
    //     if (isset($config['template'])) {
    //         self::$template = $config['template'];
    //     }
    //     if (isset($config['model'])) {
    //         self::$model = $config['model'];
    //     }
    // }
    
	public function getCleanUrl($item, $url)
	{
		return (!strpos($url, '?')) ? '?export='.$item : $url.'&export='.$item ;
	}
	public function createItem($item, $url)
    {
		$url = self::getCleanUrl($item, $url);
		$widget = '<a class="dropdown-item" href="'.$url.'">'.$item.'</a>';
        return $widget;
    }
    public function createDownloadBtn()
    {
        $items = self::$export['items'];
        $label = self::$export['label'];
        $url = self::$export['url'];
        $url = self::getCleanUrl($items[0], $url);
		// $str_item = implode('</a><a class="dropdown-item" href="#">', $items);'</a>';
		foreach ($items as $key => $value) {
			$newArr[] = self::createItem($value, $url);
		}
		$str_item = implode(' ', $newArr);
		$btn = '<div class="download dropdown">
			<button role="button" data-toggle="dropdown" aria-expanded="false" class="btn btn-light dropdown-toggle">'.$label.' </button> 
			<ul class="dropdown-menu">
			  '.$str_item.'
			</ul>
        </div>';
        echo $btn;
    }
    public function createDateFilter()
    {
        $searchModel = self::$searchModel;
        $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]);
        echo '<div class="form-group row filter ">
            <label class="col-md-1 mr-1 col-form-label">Period</label>
            <div class="col-md-4 position-relative form-parent">
                '.Html::activeTextInput($searchModel, 'start_date', ['id'=>'start_date','placeholder' => 'Start Date', 'class' => 'form-control pickadate', 'data-date-format' => "yyyy-mm-dd"], ['inputOptions' => ['autocomplete' => 'off']]) .'
                <span class="form-icon fa fa-calendar"></span>
            </div>
            <p class="col-form-label">-</p>
            <div class="col-md-4 position-relative form-parent">
                '.Html::activeTextInput($searchModel, 'end_date', ['id'=>'end_date','placeholder' => 'End Date', 'class' => 'form-control pickadate', 'data-date-format' => "yyyy-mm-dd"], ['inputOptions' => ['autocomplete' => 'off']]).'

                <span class="form-icon fa fa-calendar"></span>
            </div>
            <div class="col-md-2 position-relative">
            '. Html::submitButton('Search', ['id'=>'searchButton','name'=>'tombol', 'value'=>'search','class' => 'btn btn-primary hide-button']).'
            </div>
        </div>';
        ActiveForm::end();
    }
}
