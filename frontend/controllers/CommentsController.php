<?php

namespace frontend\controllers;

use common\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class CommentsController extends ActiveController
{

    public $modelClass = 'common\models\Comments';
    public $serializer = [
        'class' => 'common\serializers\listSerializer',
        'collectionEnvelope' => 'comments',
    ];

    const PAGESIZE = 5;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'only' =>
                ['create', 'view', 'index'],
            'formats' =>
                ['application/json' => Response::FORMAT_JSON,],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException(Yii::$app->params['unauthorizedMessage']);
            },
            'only' => ['create', 'view', 'index'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create'],
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
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function($action)
        {
            $page = floor(Yii::$app->getRequest()->getQueryParam('offset')/self::PAGESIZE)??0;

            return new ActiveDataProvider([
                'query' => Comments::find()->where(['post_id' => \Yii::$app->getRequest()->getQueryParam('post_id')]),
                'pagination' => [
                    'pageSize' => self::PAGESIZE,
                    'page' => $page,
                ]
            ]);
        };

        return $actions;
    }

}
