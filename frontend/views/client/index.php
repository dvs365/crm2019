<?php

use yii\helpers\Html;
use frontend\widgets\ListViewPager;
use yii\helpers\ArrayHelper;
use frontend\assets\ClientAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients:' . \common\models\User::findOne(Yii::$app->user->identity->id)->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);

$request = Yii::$app->request;
?>

<main>
    <div class="wrap2 control">
        <?=$this->render('menu')?>
        <div class="clear"></div>
    </div>

    <?=$this->render('_search', [
        'model' => $searchModel,
        'users' => $users,
        'role' => $role,
		'sort' => $request->get('sort'),
    ])?>

    <div ID="sort" class="right">
			<?$sort = (!$request->get('sort') || $request->get('sort') == 'show')?'-show':'show';?>
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
        'viewParams' => ['statuses' => $statuses],
        'itemOptions' => ['class' => 'wrap4'],
        'itemView' => function ($model, $key, $index, $widget) {
            //$widget->viewParams['users'][$model->user]->surnameNP
            $template = Html::tag('div', Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']).Html::tag('span', Html::encode($model->user0->surnameNP), ['class' => 'manager color_grey']).Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']), ['class' => 'about']);
            $firms = ArrayHelper::map($model->organizations, 'id', function ($element){
                return Html::tag('div', Html::encode($element->formLabel.' '.$element['name']), ['class' => 'firm']);
            });
            $template .= Html::tag('div', implode('', $firms), ['class' => 'firms']);
            $lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
            $reject = Html::encode($model->desclient0['reject']);
            $reject = $model->status == $widget->viewParams['statuses']['reject'] ? Html::tag('p', 'Причина отказа: '.$reject) : '';
            $template .= Html::tag('div', Html::tag('p', 'Открытие: ' . $lastTime).$reject, ['class' => 'wrap1']);
            $delivery = Html::tag('p', 'Доставка: ' . Html::encode($model->address));
            $discomment = Html::tag('span', Html::encode('Скидка: '.$model->discomment.' '.(($model->discount)?$model->discount.'%':'')), ['class' => (!$model->disconfirm)?'agreed_none':'']);
            $disconfirm = (!$model->disconfirm && \Yii::$app->user->can('confirmDiscount'))? Html::a('Согласовать', ['disconfirm', 'id' => $model->id], ['class' => 'agreed']):'';
            $template .= Html::tag('div', Html::tag('div', ($model->discount || $model->discomment)? $discomment.' '.$disconfirm : '', ['class' => 'wrap3']).$delivery, ['class' => 'wrap1']);
            $contacts = ArrayHelper::map($model->faces, 'id', function ($element){
                $fullname = Html::tag('div', Html::encode($element['fullname']));
                $position = Html::tag('div', Html::encode($element['position']), ['class' => 'color_grey']);
                $facephones = ArrayHelper::map($element->phonefaces, 'id', function ($phoneface){
                    return Html::tag('div', Html::a(Html::encode($phoneface->number), 'tel:'.Html::encode($phoneface->number)),['class' => 'contact_item']);
                });
                $facemails = ArrayHelper::map($element->mailfaces, 'id', function ($mailface){
                    return Html::tag('div', Html::a(Html::encode($mailface->mail), 'mailto:'.Html::encode($mailface->mail)), ['class' => 'contact_item']);
                });
                return Html::tag('div', $fullname.$position.implode('',$facephones).implode('',$facemails), ['class' => 'wrap2 contact']);
            });
            $template .= implode('', $contacts);
            $webArr = explode(',', $model->website);
            foreach ($webArr as $web):
                $webs[] = Html::a(Html::encode(trim($web)), '//'.Html::encode(trim($web)));
            endforeach;
            $template .= Html::tag('div', implode(' ', $webs), ['class' => 'contact_site wrap3']);
            return $template;
        },
		'layout' => "{pager}\n".'<div class="clear"></div>'."{summary}\n{items}"."{pager}",
    ])?>

    <div ID="up" class="right"><a href="#header">Наверх<div class="arrow_up"></div></a></div>
    <div class="clear"></div>
</main>
