<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'posts',
                    'prefix' => 'api/',
                    'extraPatterns' => [
                        'POST <post_id:\d+>/like' => 'like',
                        'POST <post_id:\d+>/dislike' => 'dislike',
                        'GET <post_id:\d+>/getRating' => 'get-rating',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'authors',
                    'prefix' => 'api/',
                    'extraPatterns' => [
                        'GET me' => 'me',
                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'comments', 'prefix' => 'api/posts/<post_id:\d+>'],
                'posts/<post_id:\d+>/comments/?' => 'site/post-comments',
                'authors/<author_id:\d+>/posts' => 'site/author-posts',
                'authors' => 'site/authors',
                'profile' => 'site/profile',
                'new-post' => 'site/new-post',
                'contact' => 'site/contact',
                'about' => 'site/about',
            ],
        ],

    ],
    'params' => $params,
    'language' => 'ru-RU',
    'name' => 'Пикомемсы - ваш сайт развлечений',
];
