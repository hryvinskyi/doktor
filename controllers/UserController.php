<?php


namespace app\controllers;

use app\components\Controller;
use app\models\CompanyFee;
use app\models\CompanyRegisterCodes;
use app\models\form\RegisterForm;
use app\models\form\LoginForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class UserController extends Controller
{
    /**
     * Registration action.
     * @var $code string
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionRegistration($code)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var $codeModel CompanyRegisterCodes */
        if(
            (
                $codeModel = CompanyRegisterCodes::find()
                    ->joinWith(['companyFee'])
                    ->where([
                        'and',
                        [CompanyRegisterCodes::tableName() . '.code'   => $code],
                        [CompanyRegisterCodes::tableName() . '.status' => CompanyRegisterCodes::STATUS_ACTIVE],
                        ['>=', CompanyFee::tableName() . '.valid_till', date('Y-m-d')]
                    ])
                    ->one()
            ) === null
        ) {
            throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
        }

        $model = new RegisterForm();
        $model->setScenario('insert');

        if ($model->load(Yii::$app->request->post())) {
            $password = \Yii::$app->security->generateRandomString(10);
            $model->company_id = $codeModel->company->id;
            $model->setPasswordHash($password);
            $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

            // $model->uploadAvatar() && $model->save()
            if($model->save()) {

                $codeModel->status = CompanyRegisterCodes::STATUS_BLOCKED;
                $codeModel->save();

                Yii::$app->mailer->compose('register_user', ['email' => $model->email, 'password' => $password])
                    ->setFrom('example@domain.com')
                    ->setTo($model->email)
                    ->setSubject(Yii::t('user', 'You have successfully registered'))
                    ->send();

                return $this->goHome();
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
