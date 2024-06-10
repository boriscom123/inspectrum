<?php

namespace App\Http\Controllers;


use App\Models\Page;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController
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
        ];

        $this->data['reviews-list'] = $this->getReviewsList();

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name;
        } else {
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = 'Гость';
        }

//        $options = $this->data['user']->options;
//        $role = $this->data['user']->options->role;
//        $role_options = $this->data['user']->options->role->options;

        return view('index', ['data' => $this->data]);
    }

    public function getReviewsList(): array
    {
        $reviews_list = [];

        $reviews = DB::table('reviews')->latest()->take(3)->get();

        if ($reviews) {
            foreach ($reviews as $review) {
                /** @var Reviews $review */
                $reviews_list[] = [
                    'id' => $review->id,
                    'date' => date('d/m/Y', strtotime($review->created_at)),
                    'title' => $review->title,
                    'poster' => $review->poster,
                    'source' => [
                        'src' => $review->src,
                        'type' => $review->type,
                    ],
                    'link' => '/reviews/' . $review->id,
                ];
            }
        }

        return $reviews_list;
    }

    public function getPageSingle($slug): array
    {
        $page_single = [];

        $page = Page::where('slug', $slug)->first();
        if ($page) {
            $page_single = [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'text' => $page->text,
                'is_active' => $page->is_active,
            ];
        }

        return $page_single;
    }

    public function pageSingle(Request $request)
    {
        $slug = '';
        if (str_starts_with($request->getPathInfo(), '/')) {
            $request_path = substr($request->getPathInfo(), 1);
        } else {
            $request_path = $request->getPathInfo();
        }
        $slug = $request_path;

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
        ];

        $this->data['page'] = $this->getPageSingle($slug);
        if ($this->data['page'] === []) {
            return Redirect('/');
        }
        $this->data['breadcrumbs'] = [
            [
                'link' => '/',
                'title' => 'Главная',
            ],
            [
                'link' => '/' . $this->data['page']['slug'],
                'title' => $this->data['page']['title'],
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

        return view('page', ['data' => $this->data]);
    }
}
