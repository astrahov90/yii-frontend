<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'О проекте';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container bg-light">
        <div class="row">
            <div class="col-12">Этот проект построен при использовании следующих технологий:
                <ul>
                    <li>HTML+JS+JQUERY</li>
                    <li>BOOTSTRAP</li>
                    <li>YII2</li>
                </ul>
            </div>
        </div>
    </div>

</div>
