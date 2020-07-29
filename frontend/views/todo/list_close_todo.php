<?
use yii\helpers\Html;
use frontend\widgets\ListViewPager;

?>
<h1 class="wrap1">Закрытые дела</h1>
<?= $this->render('_search', [
	'model' => $searchModel,
	'status' => $status,
])?>

<div ID="sort" class="right">
		<?$request = Yii::$app->request;
		$sort = (!$request->get('sort') || $request->get('sort') == 'date')?'-date':'date';?>
		Сначала закрытые давно
		<?= Html::a('', ['todo/index', 'status' => $status, 'sort' => $sort], ['class' => 'checkbox', 'sort' => $sort])?>
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
	'itemOptions' => ['class' => 'wrap4'],
	'itemView' => function ($model, $key, $index, $widget) {
		$t_client = $model->client ? Html::tag('span', Html::encode($model->client0['name']), ['class' => 'task_item_client']) : '';
		$t_p1 = Html::tag('p', Html::a(Html::encode($model->name), ['view', 'id' => $model->id]).$t_client);
		$t_desc = $model->description ? Html::tag('p', Html::encode($model->description)) : '';
		$t_fromTo = Html::tag('p', date('d.m.y в H:i',strtotime($model->date)).' До '.date('d.m.y',strtotime($model->date)));
		$t_close = Html::tag('p', 'Закрыто: '.date('d.m.y в H:i',strtotime($model->closed)));
		$template = Html::tag('div', $t_p1.$t_desc.$t_fromTo.$t_close, ['class' => 'task_item wrap1']);
		return $template;
	},
	'layout' => "{pager}\n".'<div class="clear"></div><div class="task">'."{summary}\n{items}".'</div>'."{pager}",
])?>

<div ID="up" class="right"><a href="#header">Наверх<div class="arrow_up"></div></a></div>
<div class="clear"></div>