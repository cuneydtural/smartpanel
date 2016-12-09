<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="{{ url('photos/crop/'.$profile->image) }}" class="img-circle img-sm" alt=""></a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">{{ Helper::getProfile($profile) }}</span>
                        <div class="text-size-mini text-muted">
                            <i class="fa fa-circle text-size-small color-green" aria-hidden="true"></i> {{ Helper::diffForHumans($profile->last_login) }}
                        </div>
                    </div>

                    <div class="media-right media-middle">
                        <ul class="icons-list">
                            <li>
                                <a href="{{ route('admin.users.edit', ['id' => $profile->id]) }}"><i class="icon-cog2"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">

                <ul class="navigation navigation-main navigation-accordion">
                    <!-- Main -->
                    <li class="navigation-header"><span>Genel</span> <i class="icon-menu" title="Main pages"></i></li>

                    <li @if(Request::segment(3)=="dashboard") class="active" @endif>
                        <a href="{{ route('admin.dashboard.index') }}"><i class="icon-home4"></i> <span>Dashboard</span></a>
                    </li>

                    <li @if(Request::segment(3)=="logs") class="active" @endif>
                        <a href="#"><i class="icon-list-unordered"></i><span>Sistem Hata Logları</span></a>
                        <ul>
                            <li><a href="{{ route('admin.logs.worker') }}" id="layout1">Queue Worker</a></li>
                            <li><a href="{{ route('admin.logs.laravel') }}" id="layout1">Uygulama Logları</a></li>
                            <li><a href="{{ route('admin.logs.delete') }}" id="layout1">Logları Temizle</a></li>
                        </ul>
                    </li>

                    <li @if(Request::segment(3)=="settings") class="active" @endif>
                        <a href="{{ route('admin.settings.index') }}"><i class="icon-cogs"></i> <span>Ayarlar</span></a>
                    </li>

                    <li @if(Request::segment(3)=="users" || Request::segment(3)=="roles") class="active" @endif>
                        <a href="#"><i class="icon-users"></i><span>Kullanıcılar</span></a>
                        <ul>
                            <li><a href="{{ route('admin.users.index') }}" id="layout1">Kullanıcılar</a></li>
                            <li><a href="{{ route('admin.roles.index') }}" id="layout1">Yetki Grupları</a></li>
                        </ul>
                    </li>

                    <li @if(Request::segment(3)=="photo-library") class="active" @endif>
                        <a href="{{ route('admin.photo-library.index') }}"><i class="icon-image2"></i> <span>Fotoğraf Kütüphanesi</span></a>
                    </li>

                    <li @if(Request::segment(3)=="categories") class="active" @endif>
                        <a href="{{ route('admin.categories.index') }}"><i class="icon-price-tag2"></i> <span>Kategori Yönetimi</span></a>
                    </li>
                    
                    <li @if(Request::segment(3)=="products") class="active" @endif>
                        <a href="{{ route('admin.products.index') }}"><i class="icon-cart2"></i> <span>Ürün Yönetimi</span></a>
                    </li>

                    <li @if(Request::segment(3)=="slides") class="active" @endif>
                        <a href="{{ route('admin.slides.index') }}"><i class="icon-presentation"></i> <span>Slide Yönetimi</span></a>
                    </li>

                    <li @if(Request::segment(3)=="articles") class="active" @endif>
                        <a href="{{ route('admin.articles.index') }}"><i class="icon-pen"></i> <span>Yazılar & Blog</span></a>
                    </li>

                    <li @if(Request::segment(3)=="forms") class="active" @endif>
                        <a href="#"><i class="icon-pencil6"></i><span>Formlar</span></a>
                        <ul>
                            <li><a href="{{ route('admin.forms.index') }}" id="layout1">İletişim Formu</a></li>
                        </ul>
                    </li>

                    <li @if(Request::segment(3)=="stores") class="active" @endif>
                        <a href="{{ route('admin.stores.index') }}"><i class="icon-location3"></i> <span>Şubeler</span></a>
                    </li>

                    <li @if(Request::segment(3)=="subscribers") class="active" @endif>
                        <a href="{{ route('admin.subscribers.index') }}"><i class="icon-envelop5"></i> <span>E-Bülten Aboneleri</span></a>
                    </li>

                    <li @if(Request::segment(3)=="reports") class="active" @endif>
                        <a href="#"><i class="icon-stats-bars4"></i><span>Raporlar</span></a>
                        <ul>
                            <li><a href="{{ route('admin.reports.index') }}" id="layout1">Form Raporları</a></li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>