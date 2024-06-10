<?php

namespace App\Http\Controllers;

use App\Models\Ma\Diagnose;
use App\Models\OrderPoint;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HealthRecommendationModuleController
{
    public array $data = [];

    public function __invoke(Request $request)
    {
        $this->data = [
            'title' => '«ИНСПЕКТРУМ КЛИНИК» - проведение медосмотров, медицинские книжки',
            'description' => 'Медицинский центр «ИНСПЕКТРУМ КЛИНИК». Все врачи для медицинских комиссий в одном месте. Пройдите медкомиссию для получения медкнижки у нас.',
            'keywords' => 'Медосмотр. Медосмотры. медосмотр. медосмотры.',
            'auth' => false,
            'user-name' => 'Гость',
            'open-graph' => [
                'type' => 'website',
                'title' => '«ИНСПЕКТРУМ КЛИНИК» в Уфе - проведение медосмотров, медицинские книжки',
                'description' => 'Медицинский центр «ИНСПЕКТРУМ КЛИНИК». Все врачи для медицинских комиссий в одном месте. Пройдите медкомиссию для получения медкнижки у нас.',
                'image' => 'https://storage.yandexcloud.net/storage.inspectrum.ru/icons/logo/logo.png',
                'image-height' => '70',
                'image-width' => '253',
                'url' => 'https://inspectrum.ru/',
            ],
            'app-version' => $_ENV['APP_VERSION'],
            'app-env' => $_ENV['APP_ENV'],
            'breadcrumbs' => [
                [
                    'link' => '/',
                    'title' => 'Главная',
                ],
                [
                    'link' => '/health-recommendation-module',
                    'title' => 'Рекомендательный модуль здоровья сотрудника',
                ],
            ],
        ];

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name;
        } else {
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = 'Гость';
        }

        return view('module.health-recommendation', ['data' => $this->data]);
    }

    public function updateOrderPointTable(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $file_name = 'order_clause_202405291032.csv';
        $file_path = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists($file_path . '/' . $file_name)) {
            $content = trim(file_get_contents($file_path . '/' . $file_name));
            $row_delimiter = "\r\n";
            $lines = explode($row_delimiter, $content);

            /** Добавление ПП 29Н */
            foreach ($lines as $key => $line) {
                if ($key === 0) {
                    continue;
                }
                $order_point = str_getcsv($line, ',');

                $db_order_point = OrderPoint::where('number', $order_point[1])->first();
                if (!$db_order_point) {
                    $db_order_point = new OrderPoint();
                    $db_order_point->number = $order_point[1];
                }
                $db_order_point->name = $order_point[2];
//                if ($order_point[3] !== '') {
//                    $db_order_point->parent_id = (int)$order_point[3];
//                }

                try {
                    $db_order_point->save();
                } catch (Exception $e) {
                    $response['message'] = $e->getMessage();
                }
            }

            /** Добавление ПП 29Н */
            foreach ($lines as $key => $line) {
                if ($key === 0) {
                    continue;
                }

                $order_point = str_getcsv($line, ',');

                if ($order_point[3] !== '') {
                    foreach ($lines as $parent) {
                        $parent_data = str_getcsv($parent, ',');
                        if ($parent_data[0] === $order_point[3]) {
                            $op = $parent_data[1];
                            $fop = OrderPoint::where('number', $op)->first();
                            if ($fop) {
                                $db_order_point = OrderPoint::where('number', $order_point[1])->first();
                                if ($db_order_point) {
                                    $db_order_point->parent_id = $fop->id;

                                    try {
                                        $db_order_point->save();
                                    } catch (Exception $e) {
                                        $response['message'] = $e->getMessage();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return new JsonResponse($response);
    }

    public function getOrderPoints(): array
    {
        $list = [];

        $order_points = OrderPoint::query()->orderBy('number')->get();
        if ($order_points) {
            foreach ($order_points as $order_point) {
                $name = '';
                if (mb_strlen($order_point->name) > 200) {
                    $name = mb_substr($order_point->name, 0, 200);
                } else {
                    $name = $order_point->name;
                }
                $list[] = [
                    'number' => $order_point->number,
                    'name' => $order_point->number . ' - ' . $name,
                ];
            }
        }

        return $list;
    }

    public function getOrderPointsList(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $response['order_points'] = $this->getOrderPoints();

        return new JsonResponse($response);
    }

    public function getDiagnoses(): array
    {
        $list = [];

        $diagnoses = Diagnose::query()->orderBy('code')->get();

        if ($diagnoses) {
            foreach ($diagnoses as $diagnose) {
                $list[] = [
                    'number' => $diagnose->code,
                    'name' => $diagnose->code . ' - ' . $diagnose->name,
                ];
            }
        }

        return $list;
    }

    public function getDiagnosesList(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $response['diagnoses'] = $this->getDiagnoses();

        return new JsonResponse($response);
    }

    public function updateDiagnoses(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $response['request'] = $data;

        /**
         * Обновляем или заполняем таблицы
         * Данные берутся из Google таблицы
         */
        $id = '1E-dwVyCU1wja3J4XoSmtPGNRqvRdSvPy';
        $gid = '1526773333'; // лист - Реестр

        $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
        $csv = explode("\r\n", $csv);
        $list = array_map('str_getcsv', $csv);

        if (count($list) > 0) {
            foreach ($list as $key => $diagnose) {
                if ($key === 0) {
                    continue;
                }
                $db_diagnose = Diagnose::query()->where('code', $diagnose[0])->first();
                if (!$db_diagnose) {
                    $db_diagnose = new Diagnose();
                    $db_diagnose->code = $diagnose[0];
                }
                $full_name = trim($diagnose[5]);
                if ($full_name === '<Пустая строка>') {
                    $full_name = '';
                }
                $db_diagnose->name = trim($diagnose[2]);
                $db_diagnose->full_name = $full_name;
                try {
                    $db_diagnose->save();
                } catch (Exception $e) {
                    $response['message'][] = $e->getMessage();
                }
            }
            if (!isset($response['message'])) {
                $response['result'] = true;
                $response['message'] = 'Обновили данные в таблице диагнозов';
            }
        }

        return new JsonResponse($response);
    }

    public function updateContraindications(Request $request): JsonResponse
    {
        $response = [
            'status' => 200,
        ];

        $data = $request->all();

        $response['request'] = $data;

        /**
         * Обновляем или заполняем таблицы
         * Данные берутся из Google таблицы
         */
        $id = '1Nliy3Ih_nNeDd9ENCEsrCZIjdwfefQkw';
        $gid = '455127890'; // лист - Реестр

        $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
        $csv = explode("\r\n", $csv);
        $list = array_map('str_getcsv', $csv);

        if (count($list) > 0) {
            foreach ($list as $key => $contraindication) {
                if ($key === 0) {
                    continue;
                }
                $diagnoses = $contraindication[7];
                /** Определяем диапазон диагнозов и для каждого создаем связь */
                if (str_contains(';', $diagnoses)) {
                    /** В поле диагнозов несколько диапазонов */
                    $diagnoses_list_a = explode(';', $diagnoses);
                    foreach ($diagnoses_list_a as $diagnose_a) {

                    }
                } elseif (str_contains('-', $diagnoses)) {
                    /** В поле диагнозов один диапазон */
                } elseif (str_contains('.', $diagnoses)) {
                    /** В поле диагнозов один диагноз с уточнением */
                } else {
                    /** В поле диагнозов один диагноз без уточнения */
                }
            }
        }

        return new JsonResponse($response);
    }

    public function getRecommendations(Request $request): JsonResponse
    {
        $response = [];
        $request_data = $request->all();
        $response['request_data'] = $request_data;

        /** Проверяем и подготавливаем данные для отправки в модель СППВР */
        /** Индекс SCORE */
        if (isset($request_data['user']['score'])) {
            $score = $request_data['user']['score'];
        }
        /** Дата рождения */
        if (isset($request_data['user']['birthdate'])) {
            $date = date('c', strtotime($request_data['user']['birthdate']));
            $birthdate = $date;
        } else {
            $birthdate = '';
        }
        /** Пол */
        if (isset($request_data['user']['gender'])) {
            if ($request_data['user']['gender'] === 'm') {
                $gender = 'Мужской';
            } elseif ($request_data['user']['gender'] === 'f') {
                $gender = 'Женский';
            } else {
                $gender = '';
            }
        } else {
            $gender = '';
        }
        /** Должность */
        if (isset($request_data['user']['position'])) {
            $position = $request_data['user']['position'];
        } else {
            $position = '';
        }
        /** Вредные факторы (пункты приказа 29Н) */
        if (isset($request_data['user']['points'])) {
            $points = [];
            foreach ($request_data['user']['points'] as $point) {
                $points[] = [
                    'НомерФактора' => $point['number'],
                ];
            }
        } else {
            $points = [
                [
                    'НомерФактора' => '',
                ],
            ];
        }
        /** Диагнозы */
        if (isset($request_data['user']['selected_diagnoses'])) {
            $diagnoses = [];
            foreach ($request_data['user']['selected_diagnoses'] as $diagnose) {
                $diagnoses[] = [
                    'КодДиагнозаМКБ' => $diagnose['number'],
                    'НомерПротивопоказания' => '',
                    'УточнениеСтепени' => '',
                    'Рекомендации' => '',
                ];
            }
        } else {
            $diagnoses = [
                [
                    'КодДиагнозаМКБ' => 'Z00.0', // Z00.0 - Здоров
                    'НомерПротивопоказания' => '',
                    'УточнениеСтепени' => '',
                    'Рекомендации' => '',
                ],
            ];
        }
        $data = [
            'Данные' => [
                [
                    'GUID_ПрохождениеМедосмотра' => '',
                    'GUID_Клиент' => '',
                    'КлиентДатаРождения' => $birthdate, // 1987-11-26T00:00:0
                    'КлиентПол' => $gender, // Мужской
                    'Профессия' => $position, // Кладовщик
                    'РискSCORE' => $score, // 90
                    'ВредныеФакторы' => $points,
                    'ПриемыПациента' => [
                        [
                            'GUID_Прием' => '',
                            'Специализация' => '',
                            'Диагнозы' => $diagnoses,
                        ],
                    ],
                ],
            ],
        ];

        $url = 'http://158.160.14.193:5000';
        $method = '/process';

        $ma_response = Http::post($url . $method, $data);

        if ($ma_response->ok()) {
            $response['ma_request'] = $data;
            $response['ma_response'] = $ma_response->json();
            $response['result'] = true;
        } else {
            $response['result'] = false;
        }

        return new JsonResponse($response);
    }
}
