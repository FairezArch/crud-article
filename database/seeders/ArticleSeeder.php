<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Article::create([
            'title' => 'Makanan cepat saji',
            'content' => 'Sejumlah penelitian telah membuktikan bahwa keseringan mengonsumsi makanan cepat saji saja memang tidak berdampak secara langsung ke tubuh. Namun, makanan-makanan cepat saji yang dikonsumsi akan tertimbun di dalam tubuh yang kemudian menjadi penyebab penyakit mematikan seperti kanker. Tak hanya kanker, penyakit berbahaya juga mengintai, misalnya stroke, usus buntu, dan penyakit ginjal.',
            'users_id' => 1,
        ]);

        Article::create([
            'title' => 'Konsumsi makanan cepat saji',
            'content' => 'Maka bila Anda termasuk ke dalam orang yang hobi mengkonsumsi makanan cepat saja, kurangilah hal itu dan mulai sayangi tubuh serta diri Anda sendiri. Perlu diketahui bahwa satu di antara kandungan di dalam makanan instan yaitu lilin sulit dicerna tubuh. Lilin itu menghancurkan prinsip kerja sistem pencernaan tubuh sehingga makanan yang mengandung lilin akan dicerna dengan waktu minimal dua hari.',
            'users_id' => 2,
        ]);
    }
}
