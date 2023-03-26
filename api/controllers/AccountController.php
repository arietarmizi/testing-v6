<?php


namespace api\controllers;


use api\components\Controller;
use api\config\ApiCode;
use api\forms\user\CreateSubUserForm;
use api\forms\user\SubscribeForm;
use api\forms\user\SubscriptionCancelPaymentForm;
use Carbon\Carbon;
use common\models\Package;
use common\models\PackageUser;
use common\models\payment\PaymentInquiry;
use common\models\SubscriptionUser;
use common\models\User;
use nadzif\base\rest\actions\FormAction;
use nadzif\base\rest\components\Response;
use Yii;
use yii\helpers\ArrayHelper;

class AccountController extends Controller
{
    public $contentFilterActions = ['store', 'create-sub-user', 'subscribe', 'subscribe-cancel-payment'];

    public function actions()
    {
        return [
        ];
    }

    public function actionProfile()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;

        $responseData = ArrayHelper::toArray($user, [
            User::class => [
                'id',
                'code',
                'identityCardNumber',
                'name',
                'phoneNumber',
                'email',
                'birthDate',
                'status',
                'verified',
                'isParent' => function ($model) {
                    /** @var User $model */
                    if ($model->parentId == "" || $model->parentId == null) {
                        return true;
                    }

                    return false;
                },
                'totalOrder' => function ($model) {
                    /** @var User $model */
                    return $model->getTotalOrderPerMonth();
                },
                'isAlertOrder' => function ($model) {
                    /** @var User $model */

//                    if ($model->subscription) {
//                        $totalOrder = (int)$model->getTotalOrderPerMonth();
//                        $alertOrder = (int)$model->subscription->maxOrder * ($model->subscription->alertOrderPercentage / 100);
//
//                        if (($model->subscription->maxOrder != -1) && ($totalOrder >= $alertOrder)) {
//                            return true;
//                        }
//                    }

                    return false;
                },
                'remainingOrder' => function ($model) {
                    /** @var User $model */
                    return $model->remainingOrder;
                },
            ]
        ]);

        $response = new Response();
        $response->name = \Yii::t('app', 'Get Account Profile');
        $response->message = \Yii::t('app', 'Get Account Profile Success');
        $response->code = ApiCode::DEFAULT_SUCCESS_CODE;
        $response->status = 200;
        $response->data = $responseData;
        $response->meta = [];

        return $response;
    }


    protected function verbs()
    {
        return [
            'profile' => ['get'],
        ];
    }
}