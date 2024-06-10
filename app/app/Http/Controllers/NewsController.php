<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController
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
                    'link' => '/news',
                    'title' => 'Новости',
                ],
            ],
            'news-list' => $this->getNewsList(21),
        ];

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name;
        } else {
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = 'Гость';
        }

        return view('news.news', ['data' => $this->data]);
    }

    public function newsSingle(Request $request)
    {
        $request_path = explode('/', $request->getPathInfo());

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
                    'link' => '/news',
                    'title' => 'Новости',
                ],
                [
                    'link' => '/news/' . $request_path[count($request_path) - 1],
                    'title' => 'INSPECTRUM CLINIC - РЕЗИДЕНТЫ SKOLKOVO',
                ],
            ],
        ];
        $this->data['news-single'] = $this->getNewsSingle($request_path[count($request_path) - 1]);
        $this->data['news-list'] = $this->getNewsList(2, $this->data['news-single']['id']);

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name;
        } else {
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = 'Гость';
        }

        return view('news.single', ['data' => $this->data]);
    }

    public function getNewsList($limit = 2, $exclude_id = null): array
    {
        $news_list = [];
        $news = DB::table('news')
            ->where(['is_active' => true])
            ->where('id', '!=', $exclude_id)
            ->latest()->take($limit)->get();
        if ($news) {
            foreach ($news as $item) {
                /** @var News $item */
                $news_list[] = [
                    'id' => $item->id,
                    'date' => date('d.m.Y', strtotime($item->date_start)),
                    'title' => $item->title,
                    'description' => $item->description,
                    'link' => '/news/' . $item->slug,
                ];
            }
        }

        return $news_list;
    }

    public function getNewsSingle($slug): array
    {
        $news_single = [];

        $news = News::where('slug', $slug)->first();
        if ($news) {
            $news_single = [
                'id' => $news->id,
                'date' => date('d.m.Y', strtotime($news->date_start)),
                'title' => $news->title,
                'description' => $news->description,
                'text' => $news->text,
                'link' => '/news/' . $news->slug,
            ];
        }

        return $news_single;
    }
}
