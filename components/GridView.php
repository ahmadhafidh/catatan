<?php

namespace app\components;

use Yii;
use kartik\grid\GridView as BaseGridView;
use app\components\RandomHelpers;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class GridView extends BaseGridView
{
    public $includeModule = false;
    public $layout = "{summary}<div class='table-responsive'>{items}</div>\n{pager}";
    public $tableOptions = ['class' => 'table table-bordered'];
    public $pager;
    public $summary = '<div style="font-size: 12px" class="summary float-right mr-2">Menampilkan {count} dari <span id="totalCount">{totalCount}</span> data</div>';
    public $responsive = false;
    public $responsiveWrap = false;
    public $floatHeader = true;
    public $floatHeaderOptions = [
        'top' => 73,
        'scrollingTop' => '0',
        'position' => 'absolute',
    ];
    public function init()
    {
        $this->pager = RandomHelpers::getPagerOptions();
        parent::init();
    }
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
