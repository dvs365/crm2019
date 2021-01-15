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
    <?$users = \common\models\User::find()->indexBy('id')->all();?>
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
        'viewParams' => ['statuses' => $statuses, 'users' => $users],
        'itemOptions' => ['class' => 'wrap4'],
        'itemView' => function ($model, $key, $index, $widget) {
            //$widget->viewParams['users'][$model->user]->surnameNP
			if (\Yii::$app->user->can('user') && $model->user != Yii::$app->user->identity->id) {
				$nameClient = Html::tag('span', Html::encode($model->name), ['class' => 'about_client']);
				$whoseClient = '';
			} else {
				$nameClient = Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']);
				$whoseClient = $model->user ? Html::encode($widget->viewParams['users'][$model->user]->surnameNP):'';
			}
            $pAbout = Html::tag('p', $nameClient.Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']), ['class' => 'about']);
            $firms = ArrayHelper::map($model->organizations, 'id', function ($element){
                return Html::tag('li', Html::encode($element->formLabel.' '.$element['name']), ['class' => 'firm']);
            });
			$ulFirms = Html::tag('ul', implode('', $firms), ['class' => 'firms']);
			//комментарий по клиенту
			$divComm = Html::tag('div', $model->comment, ['class' => 'client_comment']);
            $reject = $model->status == $widget->viewParams['statuses']['reject'] ? Html::tag('p', 'Причина отказа: '.Html::encode($model->desclient0['reject'])) : '';
            $template = Html::tag('div', Html::tag('div', $pAbout.$ulFirms.$reject, ['class' => 'wrap3']).$divComm, ['class' => 'wrap1']);
            $lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
            $template .= Html::tag('div', Html::tag('p', $whoseClient.' ' . Html::tag('span', 'Открытие: '. $lastTime, ['class' => 'color_grey'])), ['class' => 'wrap1']);
            $disconfirm = (!$model->disconfirm && \Yii::$app->user->can('confirmDiscount'))? Html::a('Согласовать', ['disconfirm', 'id' => $model->id], ['class' => 'agreed']):'';
            $discount = Html::tag('span', $model->discount.'%', ['class' => (!$model->disconfirm)?'agreed_none':'']);
			$trDiscount = Html::tag('tr', Html::tag('th', 'Скидка:').Html::tag('td', $discount.$disconfirm.Html::tag('br').Html::tag('span', $model->discomment, ['class' => (!$model->disconfirm)?'agreed_none':'']))); 
			$template .= ($model->discount || $model->discomment)?Html::tag('div', Html::tag('table', $trDiscount, ['class' => 'client_discount']), ['class' => 'wrap1']):'';
            $liDelivery = Html::tag('li', Html::encode($model->address));
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
