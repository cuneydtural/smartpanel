<?php

namespace App\Console\Commands;

use App\Category;
use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kurulum işlemlerini yapar.';

    /**
     * install constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Veritabanına bağlanılamadı!');
            $this->error('.env dosyasındaki veritabanı bilgilerini doldurup komutu tekrar çalıştırın!');
            return;
        }

        $this->comment('Sistem kurulumu başlatılıyor.');
        $this->comment('App Key kontrol ediliyor...');

        if (!env('APP_KEY')) {
            Artisan::call('key:generate');
        }
        $this->info('[1/4] App key oluşturuldu');

        Artisan::call('migrate', ['--force' => true]);
        $this->info('[2/4] Veritabanı oluşturuldu.');

        Artisan::call('db:seed', ['--force' => true]);
        Artisan::call('db:seed', ['--class'=>'CategoryTableSeeder', '--force'=>true]);
        $this->info('[3/4] Veriler güncellendi.');

        Artisan::call('clear-compiled');
        Artisan::call('optimize');
        $this->info('[4/4] Sistem optimizasyonları yapıldı.');

        $this->comment('Kurulum başarıyla tamamlandı.');

    }
}
