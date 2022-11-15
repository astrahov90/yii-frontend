<?php

namespace frontend\controllers;

use common\models\Authors;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class AuthorsController extends ActiveController
{

    public $modelClass = 'common\models\Authors';
    public $serializer = [
        'class' => 'common\serializers\ListSerializer',
        'collectionEnvelope' => 'authors',
    ];

    const PAGESIZE = 5;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'only' =>
                ['me', 'view', 'index'],
            'formats' =>
                ['application/json' => Response::FORMAT_JSON,],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException(Yii::$app->params['unauthorizedMessage']);
            },
            'only' => ['me', 'view', 'index'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['me'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['view', 'index'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $page = floor(Yii::$app->getRequest()->getQueryParam('offset')/self::PAGESIZE)??0;

        $actions = parent::actions();

        $actions['index']['pagination'] = [
            'pageSize' => self::PAGESIZE,
            'page' => $page,
        ];

        return $actions;
    }

    function actionMe()
    {
        $currentUser = Authors::findOne(['id'=>Yii::$app->user->id]);

        return (new ($this->serializer['class']))->serialize($currentUser);
    }

}
