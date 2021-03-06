<?php

use yii\helpers\Html;
use frontend\widgets\ListViewPager;
use yii\helpers\ArrayHelper;
use frontend\assets\ClientAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты:' . Yii::$app->user->identity->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);
$request = Yii::$app->request;
?>

<main>
    <div class="wrap4">
        <?=$this->render('menuStatus')?>
		<?=$this->render('menuAddTransfer')?>
        <div class="clear"></div>
    </div>

    <?=$this->render('_search', [
        'model' => $searchModel,
        'users' => $users,
        'role' => $role,
		'sort' => $request->get('sort'),
    ])?>

    <div ID="sort" class="right">
			<?$sort = (!$request->get('sort') || $request->get('sort') == '-show')?'show':'-show';?>
            Сначала открытые давно
			<?= Html::a('', ['client/index', 
				'ClientSearch[disconfirm]' => $searchModel->disconfirm,
				'ClientSearch[task]' => $searchModel->task,
				'ClientSearch[user]' => $searchModel->user,
				'ClientSearch[search]' => $searchModel->search,
				'ClientSearch[permonth]' => $searchModel->permonth,
				'role' => $request->get('role'),
				'sort' => $sort], ['class' => 'checkbox', 'sort' => $sort])?>
    </div>
    <?$up = Html::tag('div', Html::a('Наверх' . Html::tag('div', '', ['class' => 'arrow_up']), '#header', ), ['id' => 'up','class' => 'right'])?>
	
	<?= ListViewPager::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'pager' => [
            'firstPageLabel' => true,
            'lastPageLabel' => true,
            'prevPageLabel' => 'Назад',
            'nextPageLabel' => 'Вперед',
            'maxButtonCount' => 3,
			// Customzing options for pager container tag
			'options' => [
				'tag' => 'div',
				'class' => 'paginator',
			],
			// Customzing CSS class for pager link
			//'linkOptions' => ['class' => 'mylink'],
			'activePageCssClass' => 'active-page',
			'disabledPageCssClass' => 'mydisable',
			// Customzing CSS class for navigating link
			'prevPageCssClass' => 'none410',
			'nextPageCssClass' => 'none410',		
        ],
        'viewParams' => ['statuses' => $statuses, 
						'users' => $users, 
						'deliveries' => $deliveries, 
						'orgs' => $orgs, 
						'desclient' => $desclient,
						'managersIDs' => $managersIDs,
						],
        'itemOptions' => ['class' => 'wrap4'],
        'itemView' => function ($model, $key, $index, $widget) {
			if (array_search($model->user, $widget->viewParams['managersIDs']) !== false || $model->user == Yii::$app->user->identity->id || $model->status == $model::REJECT) {
				$nameClient = Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']);
				$surnameNP = isset($widget->viewParams['users'][$model->user]) ? $widget->viewParams['users'][$model->user]->surnameNP : '';
				$whoseClient = $model->user ? Html::encode($surnameNP) : '';
				$disconfirm = (!$model->disconfirm && \Yii::$app->user->can('confirmDiscount'))? Html::a('Согласовать', ['disconfirm', 'id' => $model->id], ['class' => 'agreed']):'';
				$discount = Html::tag('span', $model->discount.'%', ['class' => (!$model->disconfirm)?'agreed_none':'']);
				$trDiscount = Html::tag('tr', Html::tag('th', 'Скидка:').Html::tag('td', $discount.$disconfirm.Html::tag('br').Html::tag('span', $model->discomment, ['class' => (!$model->disconfirm)?'agreed_none':'']))); 
				$divDiscount = ($model->discount || $model->discomment)?Html::tag('div', Html::tag('table', $trDiscount, ['class' => 'client_discount']), ['class' => 'wrap1']):'';			
			} else {
				$nameClient = Html::tag('span', Html::encode($model->name), ['class' => 'about_client']);
				$whoseClient = '';
				$divDiscount = '';
			}
            $pAbout = Html::tag('p', $nameClient.Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']), ['class' => 'about']);
			
			$liFirm = '';
            if (isset($widget->viewParams['orgs'][$model->id])) {
				$orgs = $widget->viewParams['orgs'][$model->id];
				foreach ($orgs as $org):
					$liFirm .= Html::tag('li', Html::encode($org->formLabel . ' ' . $org->name), ['class' => 'firm']);
				endforeach;				
			}
			
			$ulFirms = Html::tag('ul', $liFirm, ['class' => 'firms']);
			//комментарий по клиенту
			$divComm = Html::tag('div', $model->comment, ['class' => 'client_comment']);
			$rejectCom = isset($widget->viewParams['desclient'][$model->id]->reject) ? $widget->viewParams['desclient'][$model->id]->reject : '';
            $reject = $model->status == $widget->viewParams['statuses']['reject'] ? Html::tag('p', 'Причина отказа: '.Html::encode($rejectCom)) : '';
            $template = Html::tag('div', Html::tag('div', $pAbout.$ulFirms.$reject, ['class' => 'wrap3']).$divComm, ['class' => 'wrap1']);
			$lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
            $template .= Html::tag('div', Html::tag('p', $whoseClient.' ' . Html::tag('span', 'Открытие: '. $lastTime, ['class' => 'color_grey'])), ['class' => 'wrap1']);
			$template .= $divDiscount; 
			$liDelivery = '';
			if (isset($widget->viewParams['deliveries'][$model->id])) {
				$deliveries = $widget->viewParams['deliveries'][$model->id];
				foreach ($deliveries as $delivery):
					$liDelivery .= Html::tag('li', Html::encode($delivery->address));
				endforeach;				
			}
			$trDelivery = Html::tag('tr', Html::tag('td', Html::tag('b', 'Доставка:')).Html::tag('td', Html::tag('ul', $liDelivery)));
			$template .= Html::tag('div', Html::tag('table', $trDelivery, ['class' => 'clients_list_delivery']),['class' => 'wrap1']);
			$webArr = explode(',', $model->website);
            foreach ($webArr as $web):
				$web = ($web && strpos($web, '://') === false)?'http://'.$web:$web;
                $webs[] = Html::a(Html::encode(trim($web)), Html::encode(trim($web)), ['target' => '_blank']);
            endforeach;
            $template .= Html::tag('div', implode(' ', $webs), ['class' => 'contact_site']);
            return $template;
        },
		'layout' => "{pager}\n".'<div class="clear"></div><div class="wrap_clients_list">'."{summary}\n{items}</div>".'<div class="wrap4">'."{pager}".$up. '</div><div class="clear"></div>',
    ])?>
</main>
