<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Event',
                'slug' => 'event',
                'description' => 'Berita dan informasi terkait event HIMATIF',
                'is_active' => true,
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari HIMATIF',
                'is_active' => true,
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Artikel seputar teknologi dan informatika',
                'is_active' => true,
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Tutorial programming dan teknologi',
                'is_active' => true,
            ],
            [
                'name' => 'Prestasi',
                'slug' => 'prestasi',
                'description' => 'Prestasi mahasiswa Teknik Informatika',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }

        $admin = User::first();
        
        $blogs = [
            [
                'title' => 'HIMATIF Gelar Workshop Web Development 2024',
                'excerpt' => 'HIMATIF menyelenggarakan workshop web development untuk meningkatkan kemampuan mahasiswa dalam pengembangan web modern.',
                'content' => '<p>HIMATIF (Himpunan Mahasiswa Teknik Informatika) dengan bangga mengumumkan pelaksanaan Workshop Web Development 2024 yang akan diselenggarakan pada bulan ini. Workshop ini dirancang khusus untuk mahasiswa yang ingin mempelajari dan meningkatkan kemampuan dalam pengembangan web modern.</p>

<h3>Materi Workshop</h3>
<p>Workshop ini akan mencakup berbagai topik penting dalam web development, termasuk:</p>
<ul>
<li>HTML5 dan CSS3 Fundamentals</li>
<li>JavaScript Modern (ES6+)</li>
<li>Framework Laravel untuk Backend</li>
<li>React.js untuk Frontend</li>
<li>Database Management dengan MySQL</li>
</ul>

<h3>Pembicara</h3>
<p>Workshop ini akan dibawakan oleh praktisi berpengalaman dari industri teknologi yang siap berbagi ilmu dan pengalaman mereka.</p>

<h3>Pendaftaran</h3>
<p>Pendaftaran dapat dilakukan melalui website HIMATIF. Jangan lewatkan kesempatan emas ini untuk meningkatkan skill web development kamu!</p>',
                'blog_category_id' => 1,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pengumuman: Rekrutmen Anggota Baru HIMATIF 2024',
                'excerpt' => 'HIMATIF membuka pendaftaran untuk anggota baru periode 2024. Segera daftarkan dirimu dan bergabung dengan keluarga besar HIMATIF!',
                'content' => '<p>HIMATIF dengan senang hati mengumumkan dibukanya pendaftaran anggota baru periode 2024. Ini adalah kesempatan bagi mahasiswa baru untuk bergabung dengan organisasi kemahasiswaan terbesar di jurusan Teknik Informatika.</p>

<h3>Persyaratan</h3>
<ul>
<li>Mahasiswa aktif Program Studi Teknik Informatika</li>
<li>Memiliki minat dalam bidang teknologi informasi</li>
<li>Berkomitmen untuk aktif dalam kegiatan organisasi</li>
</ul>

<h3>Benefit Menjadi Anggota</h3>
<ul>
<li>Networking dengan sesama mahasiswa IT</li>
<li>Akses ke berbagai workshop dan seminar</li>
<li>Pengembangan soft skill dan hard skill</li>
<li>Pengalaman organisasi yang berharga</li>
</ul>

<h3>Cara Pendaftaran</h3>
<p>Pendaftaran dilakukan secara online melalui form yang tersedia di website HIMATIF. Periode pendaftaran dibuka hingga akhir bulan ini.</p>',
                'blog_category_id' => 2,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Mengenal Artificial Intelligence: Masa Depan Teknologi',
                'excerpt' => 'Artificial Intelligence atau AI adalah teknologi yang sedang berkembang pesat. Mari kita pelajari lebih dalam tentang AI dan penerapannya.',
                'content' => '<p>Artificial Intelligence (AI) atau Kecerdasan Buatan telah menjadi topik hangat dalam beberapa tahun terakhir. Teknologi ini mengubah cara kita berinteraksi dengan komputer dan membuka peluang baru dalam berbagai bidang.</p>

<h3>Apa itu AI?</h3>
<p>AI adalah cabang ilmu komputer yang berfokus pada pembuatan mesin yang dapat melakukan tugas-tugas yang biasanya memerlukan kecerdasan manusia, seperti pengenalan pola, pembelajaran, dan pengambilan keputusan.</p>

<h3>Jenis-jenis AI</h3>
<ul>
<li><strong>Machine Learning:</strong> Sistem yang dapat belajar dari data</li>
<li><strong>Deep Learning:</strong> Subset dari ML yang menggunakan neural networks</li>
<li><strong>Natural Language Processing:</strong> Pemrosesan bahasa alami</li>
<li><strong>Computer Vision:</strong> Kemampuan komputer untuk "melihat" dan memahami gambar</li>
</ul>

<h3>Penerapan AI</h3>
<p>AI telah diterapkan dalam berbagai bidang seperti healthcare, finance, e-commerce, autonomous vehicles, dan masih banyak lagi. Sebagai mahasiswa IT, penting bagi kita untuk memahami dan menguasai teknologi ini.</p>',
                'blog_category_id' => 3,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Tutorial: Membangun REST API dengan Laravel',
                'excerpt' => 'Pelajari cara membuat REST API menggunakan Laravel framework dalam tutorial step-by-step ini.',
                'content' => '<p>REST API adalah cara standar untuk membangun web services yang dapat dikonsumsi oleh berbagai client. Dalam tutorial ini, kita akan belajar membuat REST API menggunakan Laravel.</p>

<h3>Prerequisites</h3>
<ul>
<li>PHP 8.1 atau lebih baru</li>
<li>Composer</li>
<li>Laravel 10+</li>
<li>Database (MySQL/PostgreSQL)</li>
</ul>

<h3>Step 1: Setup Project</h3>
<pre><code>composer create-project laravel/laravel api-project
cd api-project</code></pre>

<h3>Step 2: Konfigurasi Database</h3>
<p>Edit file .env dan sesuaikan konfigurasi database:</p>
<pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password</code></pre>

<h3>Step 3: Membuat Model dan Migration</h3>
<pre><code>php artisan make:model Product -m</code></pre>

<h3>Step 4: Membuat Controller</h3>
<pre><code>php artisan make:controller Api/ProductController --api</code></pre>

<p>Dengan mengikuti langkah-langkah ini, Anda akan memiliki REST API yang berfungsi dengan baik. Selamat mencoba!</p>',
                'blog_category_id' => 4,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Mahasiswa IF Raih Juara 1 Kompetisi Programming Nasional',
                'excerpt' => 'Tim dari jurusan Teknik Informatika berhasil meraih juara 1 pada kompetisi programming tingkat nasional yang diselenggarakan di Jakarta.',
                'content' => '<p>Kebanggaan bagi seluruh civitas akademika Teknik Informatika! Tim Programming kami yang terdiri dari tiga mahasiswa berbakat berhasil meraih juara 1 pada Kompetisi Programming Nasional 2024 yang diselenggarakan di Jakarta.</p>

<h3>Tim Pemenang</h3>
<p>Tim yang diberi nama "Code Warriors" ini terdiri dari:</p>
<ul>
<li>Ahmad Rizki - Ketua Tim</li>
<li>Siti Nurhaliza - Anggota</li>
<li>Budi Santoso - Anggota</li>
</ul>

<h3>Kompetisi</h3>
<p>Kompetisi yang diikuti oleh lebih dari 50 tim dari seluruh Indonesia ini menguji kemampuan peserta dalam:</p>
<ul>
<li>Algoritma dan struktur data</li>
<li>Problem solving</li>
<li>Optimisasi kode</li>
<li>Team collaboration</li>
</ul>

<h3>Prestasi Gemilang</h3>
<p>Tim kami berhasil menyelesaikan semua soal dengan waktu tercepat dan kode paling efisien. Pencapaian ini membuktikan kualitas pendidikan dan pembinaan yang diberikan di jurusan Teknik Informatika kami.</p>

<p>Selamat kepada para pemenang! Kalian adalah inspirasi bagi mahasiswa lainnya.</p>',
                'blog_category_id' => 5,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Seminar Nasional: Teknologi Blockchain dan Cryptocurrency',
                'excerpt' => 'HIMATIF mengadakan seminar nasional tentang teknologi blockchain dan cryptocurrency dengan menghadirkan pakar dari industri.',
                'content' => '<p>HIMATIF akan menyelenggarakan Seminar Nasional dengan tema "Blockchain Technology and Cryptocurrency: The Future of Digital Economy" pada bulan depan.</p>

<h3>Pembicara</h3>
<p>Seminar ini akan menghadirkan pembicara-pembicara kompeten dari industri blockchain dan cryptocurrency, termasuk:</p>
<ul>
<li>Dr. Andri Setiawan - Blockchain Expert</li>
<li>Rina Kusuma, M.Kom - Cryptocurrency Analyst</li>
<li>Dimas Pratama - Smart Contract Developer</li>
</ul>

<h3>Topik Pembahasan</h3>
<ul>
<li>Fundamental Blockchain Technology</li>
<li>Cryptocurrency and Digital Assets</li>
<li>Smart Contracts Development</li>
<li>DeFi (Decentralized Finance)</li>
<li>NFT and Web3</li>
</ul>

<h3>Target Peserta</h3>
<p>Seminar ini terbuka untuk:</p>
<ul>
<li>Mahasiswa seluruh Indonesia</li>
<li>Dosen dan akademisi</li>
<li>Praktisi teknologi</li>
<li>Umum yang tertarik dengan blockchain</li>
</ul>

<p>Segera daftarkan diri Anda dan dapatkan early bird price!</p>',
                'blog_category_id' => 1,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Tips Belajar Programming untuk Pemula',
                'excerpt' => 'Baru mulai belajar programming? Berikut adalah tips-tips yang dapat membantu perjalanan belajar programming kamu.',
                'content' => '<p>Belajar programming bisa menjadi tantangan bagi pemula. Namun dengan pendekatan yang tepat, siapa pun bisa menjadi programmer yang handal. Berikut adalah beberapa tips yang dapat membantu:</p>

<h3>1. Pilih Bahasa Programming yang Tepat</h3>
<p>Untuk pemula, disarankan memulai dengan bahasa yang mudah dipelajari seperti Python atau JavaScript. Jangan terlalu banyak bahasa sekaligus, fokus pada satu bahasa terlebih dahulu.</p>

<h3>2. Belajar Fundamental dengan Baik</h3>
<p>Pastikan kamu memahami konsep dasar seperti:</p>
<ul>
<li>Variables dan Data Types</li>
<li>Control Flow (if-else, loops)</li>
<li>Functions</li>
<li>Data Structures</li>
<li>Object-Oriented Programming</li>
</ul>

<h3>3. Practice, Practice, Practice!</h3>
<p>Programming adalah skill yang memerlukan banyak latihan. Kerjakan sebanyak mungkin coding challenges dan project kecil.</p>

<h3>4. Bergabung dengan Komunitas</h3>
<p>Bergabunglah dengan komunitas programmer, baik online maupun offline. Jangan ragu untuk bertanya dan berbagi pengetahuan.</p>

<h3>5. Buat Project Sendiri</h3>
<p>Aplikasikan ilmu yang sudah dipelajari dengan membuat project sendiri. Ini akan membantu memahami konsep dengan lebih baik.</p>

<h3>6. Jangan Takut Error</h3>
<p>Error adalah bagian dari proses belajar. Setiap error adalah kesempatan untuk belajar sesuatu yang baru.</p>

<p>Semangat belajar programming!</p>',
                'blog_category_id' => 4,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Hasil Rapat Kerja HIMATIF 2024',
                'excerpt' => 'Telah dilaksanakan Rapat Kerja HIMATIF 2024 yang membahas program kerja dan strategi organisasi untuk satu tahun ke depan.',
                'content' => '<p>Rapat Kerja (Raker) HIMATIF 2024 telah dilaksanakan dengan sukses pada tanggal 25-26 November 2024 di Aula Kampus. Raker ini dihadiri oleh seluruh pengurus HIMATIF periode 2024/2025.</p>

<h3>Agenda Rapat</h3>
<p>Raker kali ini membahas beberapa agenda penting:</p>
<ul>
<li>Evaluasi program kerja semester ganjil</li>
<li>Perencanaan program kerja semester genap</li>
<li>Pembahasan anggaran organisasi</li>
<li>Strategi pengembangan organisasi</li>
<li>Koordinasi antar divisi</li>
</ul>

<h3>Program Kerja Unggulan</h3>
<p>Beberapa program kerja unggulan yang akan dilaksanakan:</p>
<ol>
<li><strong>HIMATIF Tech Week</strong> - Seminggu penuh event teknologi</li>
<li><strong>Coding Bootcamp</strong> - Pelatihan intensif programming</li>
<li><strong>IT Career Fair</strong> - Job fair khusus IT</li>
<li><strong>Hackathon Competition</strong> - Kompetisi pembuatan aplikasi</li>
<li><strong>Community Service</strong> - Pengabdian masyarakat berbasis IT</li>
</ol>

<h3>Komitmen Organisasi</h3>
<p>Seluruh pengurus berkomitmen untuk memberikan yang terbaik bagi kemajuan HIMATIF dan kesejahteraan anggota. Mari bersama-sama mewujudkan HIMATIF yang lebih baik!</p>',
                'blog_category_id' => 2,
                'author_id' => $admin?->id ?? 1,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }
    }
}
