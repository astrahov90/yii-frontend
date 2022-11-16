<?php

/** @var yii\web\View $this */

$this->title = 'Профиль пользователя';

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= Html::beginTag('div', ['class' => 'container bg-light']) ?>
<?= Html::beginTag('div', ['class' => 'row']) ?>
<?= Html::tag('div', Html::img($model->iconPath, ['alt' => 'Аватар пользователя', 'class' => 'avatar']), ['class' => 'col-xl-1']) ?>
<?= Html::beginTag('div', ['class' => 'col-xl-10']) ?>
<?= Html::beginTag('div', ['class' => 'card px-3']) ?>
<?= Html::beginTag('div', ['class' => 'card-title']) ?>
<?= Html::beginTag('div', ['class' => 'container']) ?>
<?= Html::beginTag('div', ['class' => 'row']) ?>
<?= Html::tag('div', $model->username, ['class' => 'col-xl-4 fw-bold']) ?>
<?= Html::tag('div', 'Дата регистрации: ' . $model->createdAtFormatted, ['class' => 'col-xl-3 offset-xl-5']) ?>
<?= Html::tag('div', '', ['class' => 'clearfix']) ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>

<?= Html::beginTag('div', ['class' => 'card-body']) ?>
<?= Html::tag('p', $model->description) ?>
<?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control', 'id' => 'formFile']) ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mt-1']) ?>
<?= Html::endTag('div') ?>

<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?php ActiveForm::end()
?>
