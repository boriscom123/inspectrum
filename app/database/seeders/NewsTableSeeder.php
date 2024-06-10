<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'date' => '25.04.2024',
                'title' => 'INSPECTRUM CLINIC - РЕЗИДЕНТЫ SKOLKOVO',
                'description' => 'INSPECTRUM CLINIC - РЕЗИДЕНТЫ SKOLKOVO',
                'text' => '<p style="line-height: 150%;">Сегодня для нас наступил значимый этап развития – Inspectrum Clinic официально стал резидентом Инновационного центра Сколково! Это не только отличная возможность для роста и развития в сфере MedTech, но и признание наших успехов и инноваций в создании передовых медицинских систем.</p>
                    <p>
                         <img style="width: 100%; object-fit: contain;" alt="INSPECTRUM CLINIC - РЕЗИДЕНТЫ SKOLKOVO" src="https://storage.yandexcloud.net/storage.inspectrum.ru/images/Frame%201948754396.png" title="SKOLKOVO">
                    </p>
                    <p style="line-height: 150%;">Наша команда усердно работает над разработкой и внедрением IT-решений, которые делают медицинские услуги более доступными, эффективными и качественными. Статус резидента Сколково позволит нам еще активнее внедрять инновации, участвовать в грандиозных проектах и налаживать сотрудничество с ведущими экспертами и организациями в области технологий и медицины.</p>
                    <p style="line-height: 150%;">Мы гордимся тем, что наша работа получила высокую оценку, и благодарны за возможность стать частью одного из крупнейших  значимых технологических хабов страны.</p>
                    <p style="line-height: 150%;">Впереди нас ждут новые вызовы и возможности, и мы уверены, что с поддержкой Сколково сможем внести еще больший вклад в развитие медицины будущего. Спасибо всем нашим сотрудникам, партнерам и клиентам за доверие и поддержку.</p>
                    <p style="line-height: 150%;">Вместе мы создаем будущее!</p>',
                'slug' => 'inspectrum-clinic-rezidenty-skolkovo',
            ],
        ];

        if (count($data) > 0) {
            foreach ($data as $item) {
                $slug = '';
                if (isset($item['slug'])) {
                    $slug = $item['slug'];
                } else {
                    $slug = Str::of($item['title'])->slug('-');
                }
                $db_news = News::where('slug', $slug)->first();
                if (!$db_news) {
                    $db_news = new News();
                    $db_news->slug = $slug;
                }
                $db_news->title = $item['title'];
                $db_news->description = $item['description'];
                $db_news->created_at = strtotime($item['date']);
                $db_news->text = $item['text'];
                $db_news->save();
                $this->command->info('Новость: ' . $item['title'] . '. Добавлена');
            }
        }
    }
}
