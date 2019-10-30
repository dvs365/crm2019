<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление пользователя';
?>
<main>
    <div class="wrap1 control">
        <a href="settings.html">Свои</a><a href="settings-users.html">Пользователи</a>
    </div>
    <h1 class="wrap1"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' =>  ['class' => 'settings'], 'fieldConfig' => ['enableLabel' => false]]); ?>
        <table class="wrap1 w100p">
            <tr>
                <td class="w180">Фамилия</td>
                <td><?= $form->field($model, 'surname', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Имя</td>
                <td><?= $form->field($model, 'name', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Отчество</td>
                <td><?= $form->field($model, 'patronymic', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Должность</td>
                <td><?= $form->field($model, 'position', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">E-mail</td>
                <td><?= $form->field($model, 'email', ['template' => "{input}"])->input('email', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Телефон</td>
                <td><?= $form->field($model, 'phone', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <?if(\Yii::$app->user->can('addUpUser') && \Yii::$app->user->can('addUpAdmin')){?>
            <tr>
                <td class="w180 cl360">Право доступа</td>
                <td class="settings_user">

                    <?= $form->field($model, 'access', ['template' => "{input}"])->radioList(['1' => ' Базовый', '2' => ' Расширенный'],[
                            'item' => function($index, $label, $name, $checked, $value){
                                $return = '<label class="w160 left">';
                                $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" class="access" '.(($value == '1')?" checked":"").'>';
                                $return .= '<span class="radio"></span>';
                                $return .= ucwords($label);
                                $return .= '</label>';

                                return $return;
                            }
                    ])->label(false); ?>
                    <div class="clear"></div>

                </td>
            </tr>
            <?}else{?>
                <?= $form->field($model, 'access')->hiddenInput(['value' => \Yii::$app->user->can('addUpAdmin')? '2':'1'])?>
            <?}?>
            <tr>
                <td class="w180 cl480"></td>
                <td class="settings_user cl480">
                    <p>Выберите доступные для пользователя функции</p>
                    <div class="user_functions">
                        <? $template = "{beginLabel}{input}<span class=\"checkbox\"></span> {labelTitle}{endLabel}"?>
                        <?= $form->field($model, 'addUpUser', ['template' => $template])->checkbox(['value' => '1', 'disabled' => 'disabled'], false)->label()?>
                        <?= $form->field($model, 'addUpAdmin', ['template' => $template])->checkbox(['value' => '1', 'disabled' => 'disabled'], false)->label()?>
                        <?= $form->field($model, 'viewTodoUser', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'viewClientAll', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'upClientAll', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'confirmDiscount', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'addNoteClient', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'addTodoUser', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                        <?= $form->field($model, 'addUpNewClient', ['template' => $template])->checkbox(['value' => '1'], false)->label()?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w180 cl480"></td>
                <td class="settings_user cl480">
                    <a href="settings-users.html" class="btn cancel">Отменить</a>
                    <?= Html::submitInput('Сохранить', ['class' => 'btn']) ?>
                </td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>
</main>