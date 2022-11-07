<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="/img/logo.svg">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandImage' => Yii::$app->params['logo'],
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Лучшее', 'url' => ['/?best']],
        ['label' => 'Свежее', 'url' => ['/?newest']],
        ['label' => 'Авторы', 'url' => ['/authors/']],
    ];

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Новый пост', 'url' => ['/new-post']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);

    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Войти',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {

        echo Html::beginTag('div',['class' => 'profile-menu']);
        echo Html::a(Yii::$app->user->identity->username,null,['class' => 'dropdown-toggle']);
        echo Html::beginTag('ul',['class' => 'dropdown-menu']);
        echo Html::tag('li', Html::a('Профиль', '/profile',['class' => 'btn btn-link text-decoration-none']));
        echo Html::beginTag('li');
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Выйти',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
        echo Html::endTag('li');
        echo Html::endTag('ul');
        echo Html::endTag('div');

    }
    NavBar::end();
    ?>

    <div onclick="topFunction()" id="toTopBtn">
        <img width="35px" height="35px" src="/img/up-arrow.svg" alt="В начало">
    </div>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container bg-light ">
        <!--<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>-->
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <div class="float-end d-flex flex-row w-25">
            <a href="/about" class="nav-link flex-shrink-1 flex-grow-1">О проекте</a>
            <a href="/contact" class="nav-link flex-shrink-1 flex-grow-1">Контакты</a>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
