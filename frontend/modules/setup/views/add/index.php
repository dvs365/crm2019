<?php
use yii\helpers\Html;
?>

<main>
	<div class="wrap4">
		<div class="control left">
			<?=$this->render('/layouts/menu')?>
		</div>
		<div class="clear"></div>
	</div>
	<ul>
		<li><?=Html::a('Статистика', ['add/statistic'])?></li>
		<li><?=Html::a('Стоимость доставки', ['add/costdelivery'])?></li>
	</ul>
</main>