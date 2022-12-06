<?php

namespace frontend\modules\admin\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends ActiveController
{
    public $modelClass = 'common\models\Posts';

    public function behaviors()
    {
        return array_merge(parent::behaviors(),
        [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['test'],
                'formats' => [
                    'text/html' => Response::FORMAT_HTML,
                ],
            ]
        ] );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionTest()
    {
        /*Yii::$app->response->headers->set('Content-type', ['text/html']);*/
        return $this->render('index');
    }
}
