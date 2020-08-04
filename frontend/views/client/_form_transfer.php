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
echo ($flag)? $this->render('_popup') : '';
?>

<main>
    <div class="wrap2 control">
        <?=$this->render('menu')?>
        <div class="clear"></div>
    </div>
    <h1 class="wrap1">Передача клиентов</h1>
    <?=$this->render('_form_transfer_search', [
        'model' => $transferModel,
        'users' => $users,
    ])?>

    <?php $form = ActiveForm::begin(['action' => ['client/transfer'], 'method' => 'post', 'options' => ['class' => 'wrap1']]); ?>
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
			<? $models = $dataProvider->getModels();
				$template = '';
				foreach ($models as $model) {
                    $template .= '<tr>';
                    $template .= '<td class="w50 lh30">';
					$template .= '<label><input type="checkbox" name="Client[clientIDs][]" value="'.$model->id.'"><span class="checkbox"></span></label>';
					//$template .= $form->field($model, 'clientIDs[]', ['template' => "{input}{label}"])->checkbox(['value' => $model->id])->label('<span class="checkbox"></span>');
                    $template .= '</td>';
                    $template .= '<td><div class="wrap4">';
                    $template .= Html::tag('div', Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']).Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']),['class' => 'about']);
                    $firms = ArrayHelper::map($model->organizations, 'id', function ($element){
                        return Html::tag('div', Html::encode($element->formLabel.' '.$element['name']), ['class' => 'firm']);
                    });
                    $template .= Html::tag('div', implode('', $firms), ['class' => 'firms']);
                    $lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
                    $reason = $model->desclient0['reject'];
                    $template .= Html::tag('div', Html::tag('p', 'Открытие: ' . $lastTime).(($model->status == \common\models\Client::REJECT)?Html::tag('p', 'Причина отказа: ' . $reason):''), ['class' => 'wrap1']);
                    $discomment = Html::tag('span', Html::encode('Скидка: '.$model->discomment.' '.(($model->discount)?$model->discount.'%':'')), ['class' => (!$model->disconfirm)?'agreed_none':'']);
                    $delivery = Html::tag('p', 'Доставка: ' . Html::encode($model->address), ['class' => 'wrap3']);
                    $webArr = explode(',', $model->website);
                    foreach ($webArr as $web):
                        $webs[] = Html::a(Html::encode(trim($web)), '//'.Html::encode(trim($web)), ['target' => '_blank']);
                    endforeach;
                    $websites = Html::tag('p', implode(' ', $webs));
                    $disconfirm = (!$model->disconfirm && \Yii::$app->user->can('confirmDiscount'))? Html::a('Согласовать', ['disconfirm', 'id' => $model->id], ['class' => 'agreed']):'';
                    $template .= Html::tag('div', Html::tag('div', ($model->discount || $model->discomment)? $discomment.' '.$disconfirm : '', ['class' => 'wrap3']).$delivery.$websites, ['class' => 'wrap1']);
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
							<?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($managers, ['class' => 'w200'])?>
                        </div>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="lh30">Причина передачи</td>
                <td colspan="2">
                    <?=$form->field($desclient, 'transfer', ['template' => "{input}"])->textArea(['maxlength' => true]) ?>
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