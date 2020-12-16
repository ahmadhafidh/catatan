<?php
namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;

class RandomHelpers
{
	public static function beauty_json($data)
    {
		$arr = json_decode($data, false);
		if (is_array($arr)) {
			return json_encode($arr, JSON_PRETTY_PRINT); 
		} else {
			return $data;
		}
	}
	
	public static function sendMailCredential($model, $subject = "(no replay)")
	{
		Yii::$app->mailer->compose(
			['html' => '@common/mail/new-merchant-html', 'text' => 'new-merchant-text'],
			['merchant' => $model])
        ->setFrom(['no-reply@paymentspc.com' => 'Student Payment Center'])
        ->setTo($model->pic_email)
        ->setSubject($subject)
        ->send();
	}

	public static function sendMail($model, $subject = "(no replay)")
	{
		Yii::$app->mailer->compose(
			['html' => '@common/mail/new-merchant-html', 'text' => 'new-merchant-text'],
			['merchant' => $model])
        ->setFrom(['no-reply@paymentspc.com' => 'Student Payment Center'])
        ->setTo($model->pic_email)
        ->setSubject($subject)
        ->send();
	}
	public static function sendMailUserMerch($model, $user, $subject = "(no replay)")
	{
		Yii::$app->mailer->compose(
			['html' => '@common/mail/emailVerify-html', 'text' => 'emailVerify-text'],
			['merchant' => $model, 'user' => $user])
        ->setFrom(['no-reply@paymentspc.com' => 'Student Payment Center'])
        ->setTo($user->email)
        ->setSubject($subject)
        ->send();
	}
	public static function getCleanUrl($item, $url)
	{
		return (!strpos($url, '?')) ? '?export='.$item : $url.'&export='.$item ;
	}
	public static function createItem($item, $url)
    {
		$url = self::getCleanUrl($item, $url);
		$widget = '<a class="dropdown-item" href="'.$url.'">'.$item.'</a>';
        return $widget;
    }
	public function exportBtn(Array $items, String $label, $url=null)
	{
		$url = self::getCleanUrl($items[0], $url);
		// $str_item = implode('</a><a class="dropdown-item" href="#">', $items);'</a>';
		foreach ($items as $key => $value) {
			$newArr[] = self::createItem($value, $url);
		}
		$str_item = implode(' ', $newArr);
		$btn = '<div class="download dropdown">
			<span>'.$label.' </span> 
			<a class="download-btn" href="'.$url.'">
				'.$items[0].'  
			</a>
			<a role="button" data-toggle="dropdown" aria-expanded="false" class="download-btn arrow" href="#">
				<span class="feather fe-chevron-down"></span>  
			</a>
			<ul class="dropdown-menu">
				'.$str_item.'
			</ul>
		</div>';
		return $btn;
	}

	public function filterDate($view, $label)
	{
		$btn = '';
		$view->registerJs("
		$('.pickadate').pickadate();
		", \yii\web\View::POS_END);
		return $btn;
	}

	public static function getPagerOptions()
	{
		$linkOptions = ['class' => 'page-link'];
		$activePageCssClass = 'page-item active';
		$disabledPageCssClass = 'page-link disabled text-muted';
		$options = [
			'class' => 'pagination justify-content-end mr-2',
		];
		return [
            'firstPageLabel' => \yii\helpers\Html::tag('i', '', ['class' => 'feather fe-chevrons-left']),
			'lastPageLabel' => \yii\helpers\Html::tag('i', '', ['class' => 'feather fe-chevrons-right']),
			'prevPageLabel' => '<i class="feather fe-chevron-left"></i>',
			'nextPageLabel' => '<i class="feather fe-chevron-right"></i>',
			'prevPageCssClass' => 'prev np-btn',
			'nextPageCssClass' => 'next np-btn',
            'linkOptions' => $linkOptions,
            'activePageCssClass' => $activePageCssClass,
            'disabledPageCssClass' => $disabledPageCssClass,
            'options' => $options
        ];
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
