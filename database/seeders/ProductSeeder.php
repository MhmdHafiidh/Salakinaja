<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'id_kategori' => rand(1, 3),
                'id_subkategori' => rand(1, 4),
                'nama_produk' => 'Lorem Ipsum Dolor Sit Amet',
                'tags' => 'Lorem,Ipsum,Dolor,Sit,Amet',
                'deskripsi' => 'Lorem Ipsum Dolor Sit Amet',
                'harga' => rand(10000, 30000),
                'berat_produk' => rand(1, 100),
                'jumlah_stock' => rand(1, 100),
                'diskon' => 0,
                'gambar' => 'shop_image_' . $i . '.jpg',
            ]);
        }
    }
}
