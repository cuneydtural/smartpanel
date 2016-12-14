# Smart Panel CMS System

![alt tag](https://raw.githubusercontent.com/cuneydtural/smartpanel/master/public/assets/smartpanel-screenshot.png)


### Demo

http://35.156.205.115/tr/admin/
```sh
E-Mail : demo@demo.com
Password : demo
```

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
$ chmod -R 777 storage
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


### Master Layout Helpers

- Title
```sh
{{ @yield('title', $settings->title) }}
```

- Google Yandex Kodları
```sh
{!! $settings->code_google !!}
{!! $settings->code_yandex !!}
```

- Header Menüler
```sh
{{ \App\Helpers\Frontend::getHeaderNav($categories) }}
```

- Footer Menüler
```sh
{{ \App\Helpers\Frontend::getFooterNav($footer) }}
```

- Twitter Timeline Blade Örneği

```sh
@foreach(\App\Helpers\Twitter::timeline(2) as $twitter)
    <div class="tweet">
        <i class="icon-twitter-1"></i>
        <p><a href="http://www.twitter.com/username">@username</a> {{ $twitter['text'] }}
            <span>{{ Carbon\Carbon::parse($twitter['created_at'])->diffForHumans() }}</span>
        </p>
    </div>
@endforeach
```

### Page Detail Örneği

- routes/frontend.php içerisine aşağıdaki komutu yapıştırın.

```sh
Route::resource('/sayfalar', 'Frontend\PageController', ['names' => [
    'show' => 'frontend.page.show',],
    'only' => ['show']]);
```

- Yeni bir controller oluşturun.

```sh
$ php artisan make:controller Frontend/PageController
```

- PageController içerisine aşağıdaki fonksiyonu ekleyin.

```sh

public function show($slug)
    {
    	$nav = Category::where('slug', '=', 'sayfalar')->first()->children()->with('locales')->get();
        $page = Article::with('categories', 'photos')->whereSlug($slug)->where('locale', $this->locale)->first();
        return view('frontend.pages.show', compact('page', 'nav'));
    }

```

- Yeni bir blade dosyası oluşturun.

```sh
touch resources/views/frontend/pages/show.blade.php
```

Değişkenler

- Sayfa'nın Kategorisi

```sh
{{ \App\Category::getLocaleCategories($page->categories) }}
```

- Showcase Image

```sh
{{ \App\Article::getShowcaseImage($page->photos)) }}
```

- Kategori'ye Bağlı Diğer Sayfalar

```sh
{{ \App\Helpers\Frontend::getArticleSidebar($nav) }}
```

