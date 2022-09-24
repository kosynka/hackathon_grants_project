<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Маска для детей',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vehicula ante odio. Praesent ut ex mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus ac ornare nulla. Etiam sodales, quam in imperdiet tincidunt, erat nisl gravida justo, id bibendum mi metus vel augue. Vestibulum in mi et est malesuada ultrices.',
                'user_id' => 1,
                'status' => Offer::STATUS_CREATED,
                'document_path' => '/storage/offer/doc/1.doc',
                'document_path' => '/storage/offer/image/1.jpg',
            ],
            [
                'title' => 'Вечный двигатель',
                'description' => 'Etiam blandit dignissim sapien, eget ornare arcu mollis et. Fusce maximus augue at dictum dapibus. Proin id neque nulla. Duis sed arcu nec arcu rhoncus placerat sed in nisi. Aliquam convallis placerat lacinia. Donec nec iaculis erat.',
                'user_id' => 2,
                'status' => Offer::STATUS_CREATED,
                'document_path' => '/storage/offer/doc/2.doc',
                'document_path' => '/storage/offer/image/2.jpg',
            ],
            [
                'title' => 'Приложение "Мой район"',
                'description' => 'Pellentesque vel urna nec arcu porttitor blandit. Vestibulum pharetra, diam nec eleifend luctus, sapien tellus cursus orci, nec pharetra lectus urna sed quam. Pellentesque in dolor tempor, sagittis risus eget, lacinia diam.',
                'user_id' => 3,
                'status' => Offer::STATUS_CREATED,
                'document_path' => '/storage/offer/doc/3.doc',
                'document_path' => '/storage/offer/image/3.jpg',
            ],
            [
                'title' => 'Шиномонтажка',
                'description' => 'Nulla nisl massa, imperdiet ut ipsum vitae, volutpat luctus elit. Aliquam vulputate ante feugiat odio vehicula, a dignissim justo eleifend. Quisque tempor, turpis eget scelerisque ultrices, ante arcu ultrices tellus, vitae commodo diam lectus in odio. Vestibulum lacinia ipsum nec purus egestas convallis.',
                'user_id' => 4,
                'status' => Offer::STATUS_CREATED,
                'document_path' => '/storage/offer/doc/4.doc',
                'document_path' => '/storage/offer/image/4.jpg',
            ],
        ];

        foreach ($data as $offer) {
            Offer::create($offer);
        }
    }
}
