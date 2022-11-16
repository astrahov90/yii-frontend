<?php

namespace frontend\controllers;

use common\models\PostsLikes;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class PostsController extends ActiveController
{

    public $modelClass = 'common\models\Posts';
    public $serializer = [
        'class' => 'common\serializers\ListSerializer',
        'collectionEnvelope' => 'posts',
    ];

    const PAGE_SIZE = 5;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'only' =>
                ['index', 'view', 'create', 'like', 'dislike'],
            'formats' =>
                ['application/json' => Response::FORMAT_JSON,],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException(Yii::$app->params['unauthorizedMessage']);
            },
            'only' => ['create', 'view', 'index', 'like', 'dislike', 'getRating'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'like', 'dislike'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['view', 'index', 'getRating'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $page = floor(Yii::$app->getRequest()->getQueryParam('offset') / self::PAGE_SIZE) ?? 0;

        $actions = parent::actions();

        $actions['index']['pagination'] = [
            'pageSize' => self::PAGE_SIZE,
            'page' => $page,
        ];

        return $actions;
    }

    function actionLike($post_id)
    {
        $model = new PostsLikes();

        $post = [];
        $post['author_id'] = Yii::$app->user->id;
        $post['post_id'] = $post_id;
        $post['rating'] = 1;

        if ($model->load($post, '') && $model->validate()) {
            try {
                $model->save();
            } catch (\Exception $e) {
                throw New BadRequestHttpException('Рейтинг уже проставлен');
            }
            Yii::$app->response->statusCode = 200;
            return;
        }

    }

    function actionDislike($post_id)
    {
        $model = new PostsLikes();

        $post = [];
        $post['author_id'] = Yii::$app->user->id;
        $post['post_id'] = $post_id;
        $post['rating'] = -1;

        if ($model->load($post, '') && $model->validate()) {
            try {
                $model->save();
            } catch (\Exception $e) {
                throw New BadRequestHttpException('Рейтинг уже проставлен');
            }
            Yii::$app->response->statusCode = 200;
            return;
        }

    }

    function actionGetRating($post_id)
    {
        $postRatingQuery = PostsLikes::find()
            ->select(['post_id', 'SUM(rating) AS likes_count'])
            ->groupBy('post_id')
            ->where(['post_id' => $post_id])
            ->asArray();

        try {
            $postRating = $postRatingQuery->one();
            Yii::$app->response->statusCode = 200;
            return $postRating['likes_count'];

        } catch (\Exception $e) {
            throw New BadRequestHttpException('Ошибка данных');
        }

    }

}
