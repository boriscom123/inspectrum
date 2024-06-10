<?php

namespace App\admin\Controllers;

use App\Models\News;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminIndexController
{
    public array $data = [];

    public function __invoke(Request $request)
    {
        $this->data = [
            'title' => '',
            'description' => 'Медицинский центр «ИНСПЕКТРУМ КЛИНИК». Все врачи для медицинских комиссий в одном месте. Пройдите медкомиссию для получения медкнижки у нас.',
            'keywords' => 'Медосмотр. Медосмотры. медосмотр. медосмотры.',
            'auth' => false,
            'user-name' => 'Гость',
            'app-version' => $_ENV['APP_VERSION'],
            'app-env' => $_ENV['APP_ENV'],
        ];

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name . ' - ' . $this->data['user']->options->role->description;
        } else {
            return Redirect('/');
        }

        /** Проверка прав доступа к административной панели */
        if (!$this->data['user']->options->role->options->is_access_admin_part) {
            return Redirect('/');
        }

        return view('admin.index', ['data' => $this->data]);
    }

    /**
     * Получаем список новостей для вывода в административной части
     * @param Request $request
     * @return JsonResponse
     */
    public function getNewsList(Request $request): JsonResponse
    {
        $response = [
            'result' => false,
        ];

        $news_list = [];
        $news = DB::table('news')->latest()->get();
        if ($news) {
            foreach ($news as $item) {
                /** @var News $item */
                $news_list[] = [
                    'id' => $item->id,
                    'date_start' => date('Y-m-d', strtotime($item->date_start)),
                    'date_end' => is_null($item->date_end) ? '' : date('Y-m-d', strtotime($item->date_end)),
                    'title' => $item->title,
                    'description' => $item->description,
                    'text' => $item->text,
                    'slug' => $item->slug,
                    'is_active' => (bool)$item->is_active,
                    'created_at' => date('Y-m-d', strtotime($item->created_at)),
                    'updated_at' => date('Y-m-d', strtotime($item->updated_at)),
                ];
            }
        }

        if (count($news_list) > 0) {
            $response['result'] = true;
            $response['news_list'] = $news_list;
        }

        return new JsonResponse($response);
    }

    /**
     * Сохраняем новую новость
     * @param Request $request
     * @return JsonResponse
     */
    public function newsSave(Request $request): JsonResponse
    {
        $response = [
            'result' => false,
        ];

        $data = $request->all();

        $news = new News();
        $news->title = $data['news']['title'];
        $news->description = $data['news']['description'];
        $news->slug = Str::of($data['news']['title'])->slug('-');
        $news->is_active = is_null($data['news']['is_active']) ? false : $data['news']['is_active'];
        $news->date_start = $data['news']['date_start'];
        $news->date_end = $data['news']['date_end'];
        $news->text = $data['news']['text'];

        try {
            $result = $news->save();
            if ($result) {
                $response['result'] = true;
            }
        } catch (Exception $e) {
            $response['message'] = 'Не удалось сохранить новую новость. ' . $e->getMessage();
        }

        return new JsonResponse($response);
    }

    /**
     * Удаляем новость по ID
     * @param Request $request
     * @return JsonResponse
     */
    public function newsDelete(Request $request): JsonResponse
    {
        $response = [
            'result' => false,
        ];

        $data = $request->all();

        $news = News::find($data['id']);
        if (!$news) {
            $response['message'] = 'Не удалось найти новость по id.';
        } else {
            try {
                $result = $news->delete();
                if ($result) {
                    $response['result'] = true;
                }
            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
        }

        return new JsonResponse($response);
    }

    /**
     * Изменяем новость по ID
     * @param Request $request
     * @return JsonResponse
     */
    public function newsUpdate(Request $request): JsonResponse
    {
        $response = [
            'result' => false,
        ];

        $data = $request->all();

        $news = News::find($data['news']['id']);
        if (!$news) {
            $response['message'] = 'Не удалось найти новость по id.';
        } else {
            try {
                $news->title = $data['news']['title'];
                $news->description = $data['news']['description'];
                $news->slug = $data['news']['slug'];
                $news->is_active = $data['news']['is_active'];
                $news->date_start = $data['news']['date_start'];
                $news->date_end = $data['news']['date_end'];
                $news->text = $data['news']['text'];
                $result = $news->save();
                if ($result) {
                    $response['result'] = true;
                }
            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
        }

        return new JsonResponse($response);
    }
}
