## Dokumentasi
### Arsitektur Solusi
- FrontEnd(Vue + blade) -> BackEnd(Laravel) -> Database(postgreSQL)
### Penjelasan Desain
- Pendekatan
    - MVC digunakan untuk menjaga kode agar tetap teratur
    - Internal API digunakan karena sekala aplikasi yang tidak terlalu kompleks dan cukup untuk komunikasi antara frontend dan juga backend.
- Penghitungan Remuneration
    - ketika user membuat task/tugas maka akan diminta untuk menginputkan beberapa informasi dari judul tugas, total jam, tarif perjam, dan juga biaya tambahan(opsional). Setelah itu user harus menambahkan emplyee yang akan diberikan tugas tersebut beserta jam kerja dari employee(satu task dapat diberikan kepada lebih dari 1 employee). Diakhir user memberikan penjelaskan/deskripsi dari tugas.
    - Setelah form di submit maka akan membuat record `task` dan juga `employee_task` pada database.
    - Untuk total remuneration diambil dari hasil jam kerja * tarif perjam + biaya tambahan
    - untuk pembagian employee remuneration diambil dari hasil total jam kerja / jam yang diambil oleh employee * total remuneration.
    - user dapat mengedit juga dapat melihat melihat detail task.
### SetUp
 - jalankan `git clone https://github.com/ibnumalik99/coding-challenge.git` untuk cloning.
 - install depedencies `composer install`, `npm install`.
 - copy file .env.example ke .env dan setup. 
 - generate key.
 - jalankan migrasi dan seeder.
 - jalankan aplikasi dengan `php artisan serve` + `npm run watch`.
### Tantangan & Solusi
Tantangan yang saya dapat adalah pada perancangan database. Saya harus merancang tabel task yang mana setiap task tersebut akan diberikan kepada employee, dan saya tidak dapat melakukan relasi langsung dari tabel task ke tabel employee dikarenakan ada kondisi yang memungkinkan 1 task diberikan kepada lebih dari satu employee dan setiap employee juga mempunyai jam kerja masing-masing.
untuk solusinya saya menghadirkan tabel pivot yaitu employee_task yang menjembatani antara tabel task dan tabel employee. Dan di tabel ini juga saya menympan jam kerja yang dimiliki setuap employee untuk setiap user
