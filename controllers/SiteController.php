<?php

namespace app\controllers;

use app\components\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * View homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
