<?php
/**
 * @package    DOKTOR
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2017. Hryvinskyi Volodymyr
 */

/**
 * @var string $password
 * @var string $email
 */

use yii\helpers\Html;

echo Html::tag('h3', Yii::t('user', 'You have successfully registered'));
echo Html::tag(
    'div',
    Yii::t(
        'user',
        '<b>Your email:</b> {email}<br><b>Your password:</b> {password}', [
            'email'    => $email,
            'password' => $password,
        ]
    )
);
