<?php
namespace app\components;

use Yii;
use yii\grid\GridView;
use app\components\RandomHelpers;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class CustomGridView extends GridView
{

    public $includeModule = false;
    public $layout = '{summary} <div class="table-responsive collapse-tr scrollable"><div class="table-container">{items}</div></div>{pager} ';
    public $tableOptions = ['class' => 'table table-bordered'];
    public $pager;
    public $summary = '<div style="font-size: 12px" class="summary float-right mb-3 mr-2 mt-4">Menampilkan {count} dari <span id="totalCount">{totalCount}</span> data</div>';
    public function init()
    {
        $this->pager =  RandomHelpers::getPagerOptions();
        parent::init();
    }
    // public function renderTableHeader()
    // {
    //     $cells = [];
    //     foreach ($this->columns as $column) {
    //         /* @var $column Column */
    //         $cells[] = $column->renderHeaderCell();
    //     }
    //     $content = Html::tag('tr', implode('', $cells), $this->headerRowOptions);
    //     if ($this->filterPosition === self::FILTER_POS_HEADER) {
    //         $content = $this->renderFilters() . $content;
    //     } elseif ($this->filterPosition === self::FILTER_POS_BODY) {
    //         $content .= $this->renderFilters();
    //     } elseif ($this->filterPosition === 'headerAsFilter'){
    //         $content = $content;
    //     }
    //     return "<thead>\n" . $content . "\n</thead>";
    // }
    // public function renderTableRow($model, $key, $index)
    // {
        
    //     $cells = [];
    //     /* @var $column Column */
    //     foreach ($this->columns as $column) {
    //         $cells[] = $column->renderDataCell($model, $key, $index);
    //     }
    //     if ($this->rowOptions) {
    //         $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
    //         if (isset($options['data-href'])) {
    //             $m_id = Yii::$app->controller->module->id;
    //             $c_id = Yii::$app->controller->id;
    //             if ($this->includeModule) {
    //                 $options['data-href'] = '/'.$m_id.'/'.$c_id.'/'.$options['data-href'];   
    //             }
    //             else{
    //                 $options['data-href'] = '/'.$c_id.'/'.$options['data-href'];
    //             }
    //         }
    //         $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;
    //     }
    //     else{
    //         $options = $this->rowOptions;
    //     }
    //     return Html::tag('tr', implode('', $cells), $options);
    // }
    public function renderSummary()
    {
        $count = $this->dataProvider->getCount();
        if ($count <= 0) {
            return '';
        }
        $summaryOptions = $this->summaryOptions;
        $tag = ArrayHelper::remove($summaryOptions, 'tag', 'div');
        if (($pagination = $this->dataProvider->getPagination()) !== false) {
            $totalCount = "<i class='fa fa-spinner  fa-spin'></i>";
            $begin = $pagination->getPage() * $pagination->pageSize + 1;
            $end = $begin + $count - 1;
            if ($begin > $end) {
                $begin = $end;
            }
            $page = $pagination->getPage() + 1;
            $pageCount = $pagination->pageCount;
            if (($summaryContent = $this->summary) === null) {
                return Html::tag($tag, Yii::t('yii', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{item} other{items}}.', [
                        'begin' => $begin,
                        'end' => $end,
                        'count' => $count,
                        'totalCount' => $totalCount,
                        'page' => $page,
                        'pageCount' => $pageCount,
                    ]), $summaryOptions);
            }
        } else {
            $begin = $page = $pageCount = 1;
            $end = $totalCount = $count;
            if (($summaryContent = $this->summary) === null) {
                return Html::tag($tag, Yii::t('yii', 'Total <b>{count, number}</b> {count, plural, one{item} other{items}}.', [
                    'begin' => $begin,
                    'end' => $end,
                    'count' => $count,
                    'totalCount' => $totalCount,
                    'page' => $page,
                    'pageCount' => $pageCount,
                ]), $summaryOptions);
            }
        }

        return Yii::$app->getI18n()->format($summaryContent, [
            'begin' => $begin,
            'end' => $end,
            'count' => $count,
            'totalCount' => $totalCount,
            'page' => $page,
            'pageCount' => $pageCount,
        ], Yii::$app->language);
    }
}
