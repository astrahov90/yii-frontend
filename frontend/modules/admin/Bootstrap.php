<?php

namespace frontend\modules\admin;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                'test' => 'admin/default/test',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'admin/default',
                    /*'controller' => ['testlist'=>'admin/default'],*/
                    'prefix' => 'rest/',
                    'pluralize' => false,
                ],
            ]
        );
    }
}