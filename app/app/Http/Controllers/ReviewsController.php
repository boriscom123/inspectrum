<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewsController
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
                    'link' => '/reviews',
                    'title' => 'Отзывы пациентов',
                ],
            ],
            'reviews-list' => $this->getReviewsList(),
        ];

        if (Auth::check()) {
            $this->data['auth'] = true;
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = $this->data['user']->name;
        } else {
            $this->data['user'] = Auth::user();
            $this->data['user-name'] = 'Гость';
        }

        return view('reviews.reviews', ['data' => $this->data]);
    }

    public function getReviewsList(): array
    {
        $reviews_list = [];

        $reviews = DB::table('reviews')->latest()->get();

        if($reviews) {
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
}
