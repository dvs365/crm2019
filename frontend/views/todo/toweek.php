<?
use frontend\assets\TodoAsset;
use yii\helpers\Html;

$this->title = 'Дела на неделю';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
TodoAsset::register($this);
?>
<main>
	<div class="task left">
		<div class="wrap1 control">
			<?=$this->render('menu')?>
		</div>
		<?=$this->render('_form', [
			'model' => new common\models\Todo,
			'action' => ['todo/create'],
			'clients' => $clients,
		])?>
	</div>
	<?if(\Yii::$app->user->can('admin')):?>
	<?=$this->render('_form_user', [
		'model' => new common\models\Todo,
		'user' => $user,
		'userID' => $userID,
		'status' => $status,
		'action' => ['todo/toweek'],
	])?>
	<?endif;?>
	<div class="clear"></div>

	<div class="nav_works_week"><h1>Дела на неделю</h1>
		<?= Html::a('', ['todo/toweek', 'week' => $week-1], ['class' => 'arrow_left'])?>
		<?= Html::a('', ['todo/toweek', 'week' => $week+1], ['class' => 'arrow_right'])?>
	</div>
	<form action="/asd.php" id="choise-date" class="right f128" method="POST" onsubmit="send(this)">
		<label><input type="text" name="date" class="task_date__s w0" readonly onClick="par={class:'xcalend2', to:'choise-date'};xCal(this)" ><span class="color_blue">Выбрать дату</span></label>
	</form>
	<div class="clear"></div>

	<div class="outer">
		<div class="inner">
			<table class="tweek">
				<thead>
				<tr>
					<th class="tweek_frow"></th>
					<? $days = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'];?>
					<? foreach ($day as $key => $date):?>
					<th class="tweek_frow"><?= $days[$key].', '.$date->format('d.m')?></th>
					<? endforeach;?>
				</tr>
				</thead>
				<tbody>
				<?foreach ($modelsTime as $time => $todos):?>
					<tr>
						<td class="tweek_fcol"><?=$time?></td>
						<?foreach ($day as $key => $date):?>
							<?if (!empty($todos[$key])):?>
								<td>
							<?foreach ($todos[$key] as $todo):?>
								<?= Html::a($todo->name, ['todo/view', 'id' => $todo->id])?>
							<?endforeach;?>
								</td>
							<?else:?>
								<td></td>
							<?endif;?>
						<?endforeach;?>
					</tr>
				<?endforeach;?>
						<?foreach ($day as $key => $date):?>
							<?if (!empty($modelsLong[$key])):?>
								<?foreach ($modelsLong[$key] as $todo):?>
									<? $delay = count($cntID[$todo->id]);?>
									<tr>
										<td class="tweek_fcol"></td>
										<?for ($i=0; $i<$key; $i++):?>
											<td></td>
										<?endfor;?>
										<td colspan="<?=$delay?>">
											<div class="work_long<?= ($key+$delay == 7)?'__transit':''?>">
												<?= Html::a($todo->name, ['todo/view', 'id' => $todo->id])?>
												<?if ($key+$delay == 7):?>
												<span class="color_grey">До <?= date('d.m', strtotime($todo->dateto))?></span>
												<?endif;?>
											</div>
										</td>
										<?for ($j=6; $j > $key+$delay-1; $j--):?>
											<td></td>
										<?endfor;?>										
									</tr>
								<?endforeach;?>
							<?else:?>
									
							<?endif;?>
						<?endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</main>