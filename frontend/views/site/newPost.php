<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Пикомемсы - Добавить новый пост';
?>
<div class="site-newpost">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-newpost', 'action' => '/api/posts']); ?>

            <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'placeholder' => 'Введите заголовок поста']) ?>
            <?= Html::label('Текст поста', 'text', ['class' => 'form-label']) ?>
            <?= Html::tag('div', '', ['class' => 'clearfix']) ?>

            <div class="btn-group mt-2 mb-2" role="group">
                <button type="button" class="btn btn-outline-primary bbcode" id="text-bold" title="Полужирный"><span
                            style="font-weight: bold">B</span></button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-italic" title="Курсив"><span
                            style="font-style: italic">I</span></button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-underline" title="Подчеркнутый">
                    <span style="text-decoration: underline">U</span></button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-line-through" title="Зачеркнутый">
                    <span style="text-decoration: line-through">S</span></button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-quote" title="Цитирование"><span
                            style="font-weight: bold">""</span></button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-url" title="Гиперссылка">url
                </button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-img" title="Изображение">img
                </button>
                <button type="button" class="btn btn-outline-primary bbcode" id="text-color" title="Цвет текста">color
                </button>
                <input type="color" class="btn btn-outline-primary" id="text-color-select" title="Цвет">
            </div>
            <?= $form->field($model, 'body')->textarea(['id' => 'post', 'placeholder' => 'Введите текст поста'])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                <?= Html::Button('Предпросмотр', ['class' => 'btn btn-primary', 'id' => 'preview']) ?>
            </div>
            <div id="preview-data">
                <?= Html::label('Предварительный просмотр', 'preview-data') ?>
                <?= Html::tag('div', Html::tag('pre', 'Предпросмотр', ['class' => 'card-body w-100']), ['class' => 'card']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    let previewData = $("#preview-data");
    previewData.hide();

    let textField = $("#text");

    $("#preview").click(function () {
        previewData.show();
        previewData.find('pre').html(bbCodeDecode(textField.val()));
    });

    $(".bbcode").click(function () {
        let curText = textField.val();

        let curSelectionStart = textField.prop('selectionStart');
        let curSelectionEnd = textField.prop('selectionEnd');

        let tag;
        let url;
        let color;

        switch ($(this).attr('id')) {
            case "text-bold":
                tag = 'b';
                break;
            case "text-italic":
                tag = 'i';
                break;
            case "text-underline":
                tag = 'u';
                break;
            case "text-line-through":
                tag = 's';
                break;
            case "text-quote":
                tag = 'quote';
                break;
            case "text-url":
                tag = 'url';
                break;
            case "text-img":
                tag = 'img';
                break;
            case "text-color":
                tag = 'color';
                break;
        }

        if (tag === "url") {
            url = prompt("Введите url");
            if (!url) {
                return false;
            }
        }

        if (tag === "img") {
            url = prompt("Введите ссылку на изображение");
            if (!url) {
                return false;
            }
            curSelectionStart = curSelectionEnd;
        }

        if (tag === "color") {
            color = $("#text-color-select").val();
        }

        let curSelection = "[" + tag + (curSelectionStart !== curSelectionEnd && url ? "=" + url : "") + (color ? "='" + color + "'" : "") + "]" + (curSelectionStart === curSelectionEnd && url ? url : curText.slice(curSelectionStart, curSelectionEnd)) + "[/" + tag + "]";

        curText = curText.slice(0, curSelectionStart) + curSelection + curText.slice(curSelectionEnd);

        textField.val(curText);
    });

    $("#form-newpost").submit(function (event) {

        event.preventDefault();
        event.stopImmediatePropagation();

        let formData = $(this).serialize();
        let action = $(this).attr('action');

        $.post(action, formData).done(function (data) {
            document.location.href = "/posts/" + data.id + "/comments";
        });

        return false;
    });

</script>
