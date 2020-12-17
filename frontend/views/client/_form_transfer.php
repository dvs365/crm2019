<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\assets\ClientAsset;

$this->title = 'Clients:' . \common\models\User::findOne(Yii::$app->user->identity->id)->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);
echo ($flag)? $this->render('_popup', []) : '';
?>

<main>
    <div class="wrap4">
        <?=$this->render('menuStatus')?>
		<?=$this->render('menuAddTransfer')?>
        <div class="clear"></div>
    </div>
    <h1 class="wrap1">Передача клиентов</h1>
    <?=$this->render('_form_transfer_search', [
        'model' => $transferModel,
        'users' => $users,
    ])?>

    <?php $form = ActiveForm::begin(['action' => ['client/transfer'], 'method' => 'post', 'options' => ['class' => 'wrap1']]); ?>
        <!--<div class="paginator"><a class="none410" href="/">Назад</a><a href="/">1</a><a href="/">...</a><a href="/">9</a><a href="/">10</a><span class="active-page">11</span><a href="/">12</a><a href="/">13</a><a href="/">...</a><a href="/">55</a><a class="none410" href="/">Вперед</a></div>-->
		<table class="clients_table wrap1">
            <tr>
                <td class="w50">
                    <label>
                        <input type="checkbox" name="select-all">
                        <span class="checkbox" title="Выбрать все"></span>
                    </label>
                </td>
                <td><p>Выбрать все</p></td>
            </tr>
        </table>
        <div class="clear"></div>
        <table ID="elements" class="clients_table">
			<?$users = \common\models\User::find()->indexBy('id')->all();?>
			<? $models = $dataProvider->getModels();
			    $clientIDs = array_keys($models);
				$org = \common\models\Organization::find()->select('id,client,name,form')->where(['client' => $clientIDs])->asArray()->all();

				$result = [];
				foreach($org as $v) {
					if (array_key_exists($v['client'], $result)) {
						$result[$v['client']][] = $v;
					} else {
						$result[$v['client']] = array($v);        
					}
				}
				$template = '';
				$formLabels = \common\models\Organization::getFormLabels();
				foreach ($models as $model) {
                    $template .= '<tr>';
                    $template .= '<td class="w50 lh30">';
					$template .= $form->field($transfer, 'clientIDs[]')->checkbox(['label' => '<span class="checkbox"></span>', 'value' => $model->id, ]);
					$template .= $form->field($transfer, 'users['.$model->user.'][]')->label(false)->hiddenInput(['value' => $model->id]);
					$template .= '</td>';
                    $template .= '<td><div class="wrap4">';
					$status = Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']);
					$nameA = Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']);
					$firms = isset($result[$model->id]) ? ArrayHelper::map($result[$model->id], 'id', function ($element) use ($formLabels){
                        return Html::tag('li', Html::encode($formLabels[$element['form']].' '.$element['name']), ['class' => 'firm']);
                    }) : [];
					$firmsUl = Html::tag('ul', implode('', $firms), ['class' => 'firms']);
                    $template .= Html::tag('div', Html::tag('p', $nameA.$status, ['class' => 'about']).$firmsUl,['class' => 'wrap1']);

                    $lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
					$user = Html::tag('p', $users[$model->user]->surnameNP.Html::tag('span', ' Открытие: ' . $lastTime, ['class' => 'color_grey']));
                    $template .= Html::tag('div', $user, ['class' => 'wrap1']);
					$confirmClass = (!$model->disconfirm && ($model->discount || $model->discomment)) ? 'agreed_none' : '';
					$discount = Html::tag('span', Html::encode($model->discount.'%'), ['class' => $confirmClass]);
					$discomment = Html::tag('br').Html::tag('span', Html::encode($model->discomment), ['class' => $confirmClass]);
					$disconfirm = (!$model->disconfirm && ($model->discount || $model->discomment) && \Yii::$app->user->can('confirmDiscount'))? Html::a('Согласовать', ['disconfirm', 'id' => $model->id], ['class' => 'agreed']):'';
					$template .= Html::tag('div', Html::tag('p', Html::tag('b','Скидка: ').$discount.$disconfirm.$discomment), ['class' => 'wrap1']);
					$td1 = Html::tag('td', Html::tag('b', 'Доставка:'));
					$deliveryLi = Html::tag('li', $model->address);
					$td2 = Html::tag('td', Html::tag('ul', $deliveryLi));
					$delivery = Html::tag('table', Html::tag('tr', $td1.$td2), ['class' => 'clients_list_delivery']);
					$template .= Html::tag('div', $delivery, ['class' => 'wrap1']);
                    $webArr = explode(',', $model->website);
					$webs = [];
                    foreach ($webArr as $web):
                        $webs[] = Html::a(Html::encode(trim($web)), '//'.Html::encode(trim($web)), ['target' => '_blank']);
                    endforeach;
                    $websites = Html::tag('p', implode(' ', $webs));                    
                    $template .= '</div></td>';					
				}
				echo $template;
			?>

        </table>

        <table class="clients_transfer">
            <tr><td></td><td></td><td></td></tr>
            <tr>
                <td colspan="2">Передать <span class="none360">выбранных клиентов</span> менеджеру</td>
                <td class="wrap_select">
                    <label>

                        <div class="select w200">
                            <div class="dropdown"></div>
							<?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
							<?=$form->field($transfer, 'userID', ['template' => "{input}"])->dropDownList($managers, ['class' => 'w200', 'prompt' => ['text' => '...', 'options' => ['value' => '']]])?>
                        </div>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="lh30">Причина передачи</td>
                <td colspan="2">
                    <?=$form->field($transfer, 'transfer', ['template' => "{input}"])->textArea(['maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" class="btn right" value="Передать">
                </td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>


    <div ID="up" class="right"><a href="#header">Наверх<div class="arrow_up"></div></a></div>
    <div class="clear wrap1"></div>

</main>