<?php

namespace app\controllers;

use app\models\CalculateRequestForm;
use app\models\GetCryptocurrencyRequestForm;
use app\src\Dto\Response\CalculateResponseDto;
use app\src\Repository\Interface\CryptocurrencyRepositoryInterface;
use app\src\Service\Interface\CryptocurrencyCalculateServiceInterface;
use app\src\Service\Interface\CryptocurrencyUpdateServiceInterface;
use Exception;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;

class CryptocurrenciesController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionUpdate(CryptocurrencyUpdateServiceInterface $updateService): array
    {
        dd(Yii::$app->coinApiKey);
        if (Yii::$app->request->isPut) {
            $updateService->handler();

            return [
                'status' => 'success',
                'message' => 'Запрос выполнен успешно.'
            ];
        } else {
            throw new HttpException(405, 'Разрешенный метод PUT');
        }
    }

    public function actionIndex(
        CryptocurrencyRepositoryInterface $cryptocurrencyRepository,
        GetCryptocurrencyRequestForm $validator
    ) : array {
        if (Yii::$app->request->isGet) {
            $validator->load(Yii::$app->request->get(), '');

            if ($validator->validate()) {
                try {
                    return [
                        'status' => 'success',
                        'message' => 'Запрос выполнен успешно.',
                        'data' => $cryptocurrencyRepository->getAll(
                            $validator->attributes['limit'],
                            $validator->attributes['offset']
                        )
                    ];
                } catch (Exception $e) {
                    Yii::error($e->getMessage());

                    return [
                        'status' => 'failure',
                        'message' => $e->getMessage(),
                        'data' => []
                    ];
                }
            } else {
                throw new BadRequestHttpException('Ошибки валидации.');
            }
        } else {
            throw new HttpException(405, 'Разрешенный метод GET');
        }
    }

    public function actionSymbol(
        string $symbol,
        CryptocurrencyRepositoryInterface $cryptocurrencyRepository
    ) : array {
        if (Yii::$app->request->isGet) {
            try {
                return [
                    'status' => 'success',
                    'message' => 'Запрос выполнен успешно.',
                    'data' => $cryptocurrencyRepository->getBySymbol($symbol)
                ];
            } catch (Exception $e) {
                Yii::error($e->getMessage());

                return [
                    'status' => 'failure',
                    'message' => $e->getMessage(),
                    'data' => []
                ];
            }
        } else {
            throw new HttpException(405, 'Разрешенный метод GET');
        }
    }

    public function actionCalculate(
        CryptocurrencyCalculateServiceInterface $calculateService,
        CalculateRequestForm $validator
    )
    {
        if (Yii::$app->request->isPost) {
            $validator->load(Yii::$app->request->post(), '');

            if ($validator->validate()) {
                try {
                    /** @var CalculateResponseDto $responseDto */
                    $responseDto = $calculateService->handler(
                        $validator->attributes['symbol'],
                        $validator->attributes['amount'],
                        $validator->attributes['currency']
                    );

                    return [
                        'status' => 'success',
                        'message' => 'Запрос выполнен успешно.',
                        'data' => [
                            'amount' => $responseDto->getAmount(),
                            'symbol' => $responseDto->getSymbol(),
                            'price_per_unit' => $responseDto->getPricePerUnit(),
                            'currency' => $responseDto->getCurrency(),
                            'total_price' => $responseDto->getTotalPrice()
                        ]
                    ];
                } catch (Exception $e) {
                    Yii::error($e->getMessage());

                    return [
                        'status' => 'failure',
                        'message' => $e->getMessage(),
                        'data' => []
                    ];
                }
            } else {
                throw new BadRequestHttpException('Ошибки валидации.');
            }
        } else {
            throw new HttpException(405, 'Разрешенный метод GET');
        }
    }

}
