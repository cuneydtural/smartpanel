# Smart Panel CMS System

![alt tag](https://raw.githubusercontent.com/cuneydtural/smartpanel/master/public/assets/smartpanel-screenshot.png)

#### Gereksinimler

- PHP >=7.0.0
- MCrypt PHP Eklentisi

#### Development
- sudo npm install

#### Kurulum

```sh
$ git clone https://github.com/cuneydtural/smartpanel.git
$ cd smartpanel
$ cp .env.example .env
$ chmod -R 777 app/storage
$ chmod -R 777 public/photos
$ composer install
$ php artisan app:install
```

#### Manuel Kurulum için 'app:install' komutu açılımı

```sh
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan clear-compiled
$ php artisan optimize
```


#### Google Analytics API Ayarları

- https://console.developers.google.com/apis/ adresine tıklayın.
- 'Other popular APIs' başlığı altında ki 'Analytics API' linkine tıklayın.
- Enable Api butonuna tıklayın
- Sidebar > Credentials > Create Credentials > Service Account Key sıralamasını takip edin.
- Service Engine (App Engine Default Service Account) > Key Type (JSON) seçip Create butonuna tıklayın
- İndirilen JSON Dosyasını açıp içeriğini kopyalayın.
- /storage/app/laravel-google-analytics/ klasörü altındaki 'service-account-credentials.json' dosyasına yapıştırın.
- Google Analytics hesabını açıp yönetici adımına tıklayın
- 'Kullanıcı Yönetimi' butonuna tıklayıp 'Yetki Ekleyin' alanına JSON dosyası içerisindeki 'client_email' anahtarında ki e-mail adresini ekleyin.
- Tekrar Yönetici sayfasına gelip 'Ayarları görüntüle' butonuna tıklayın.
- 'Görünüm Kimliği (View ID)' numaranızı .env dosyasındaki ANALYTICS_VIEW_ID alanına yapıştırın.

