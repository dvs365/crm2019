<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use frontend\assets\ClientAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients:' . \common\models\User::findOne(Yii::$app->user->identity->id)->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);

?>

<main>
    <div class="wrap2 control">
        <?=Html::a('Потенциальные', ['index', 'role' => \common\models\Client::TARGET])?>
        <?=Html::a('Рабочие', ['index', 'role' => \common\models\Client::LOAD])?>
        <?=Html::a('Отказные', ['index', 'role' => \common\models\Client::REJECT])?>
        <?=Html::a('Добавить клиента', ['create'], ['class' => 'btn w160 right ml20'])?>
        <?=Html::a('Передать клиентов', ['create'], ['class' => 'btn w160 right'])?>
        <div class="clear"></div>
    </div>

    <?=$this->render('_search', [
        'model' => $searchModel,
        'users' => $users,
        'role' => $role,
    ])?>

    <div ID="sort" class="right">
        <form action="/" method="GET" onsubmit="send(this)">
            <input type="checkbox" name="sort" value="1">
            Сначала открытые давно
            <button class="checkbox"></button>
        </form>
    </div>
    <div class="paginator"><a class="none410" href="/">Назад</a><a href="/">1</a><a href="/">...</a><a href="/">9</a><a href="/">10</a><span class="active-page">11</span><a href="/">12</a><a href="/">13</a><a href="/">...</a><a href="/">55</a><a class="none410" href="/">Вперед</a></div>
    <div class="clear"></div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'pager' => [
            'firstPageLabel' => 'Назад',
            'lastPageLabel' => 'Вперед',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
            'maxButtonCount' => 3,
        ],
        //'viewParams' => ['users' => $users],
        'itemOptions' => ['class' => 'wrap4'],
        'itemView' => function ($model, $key, $index, $widget) {
            //$widget->viewParams['users'][$model->user]->surnameNP
            $template = Html::tag('div', Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'about_client']).Html::tag('span', Html::encode($model->user0->surnameNP), ['class' => 'manager color_grey']).Html::tag('span', $model->statusLabel.' клиент', ['class' => 'about_status color_grey']), ['class' => 'about']);
            $firms = ArrayHelper::map($model->organizations, 'id', function ($element){
                return Html::tag('div', Html::encode($element['name']), ['class' => 'firm']);
            });
            $template .= Html::tag('div', implode('', $firms), ['class' => 'firms']);
            $lastTime = Yii::$app->formatter->asRelativeTime($model->show, date('Y-m-d H:i:s'));
            $template .= Html::tag('div', Html::tag('p', 'Открытие: ' . $lastTime), ['class' => 'wrap1']);
            $delivery = Html::tag('p', 'Доставка: ' . Html::encode($model->address));
            $discomment = Html::tag('span', Html::encode($model->discomment.' '.$model->discount).'%', ['class' => (!$model->disconfirm)?'agreed_none':'']);
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
        }
    ])?>

    <div class="paginator left"><a class="none410" href="/">Назад</a><a href="/">1</a><a href="/">...</a><a href="/">9</a><a href="/">10</a><span class="active-page">11</span><a href="/">12</a><a href="/">13</a><a href="/">...</a><a href="/">55</a><a class="none410" href="/">Вперед</a></div>
    <div ID="up" class="right"><a href="#header">Наверх<div class="arrow_up"></div></a></div>
    <div class="clear"></div>

</main>
