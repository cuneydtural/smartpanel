<?php

namespace App\Http\Controllers;

use App\Form;
use App\Helpers\DiskStatus;
use App\Helpers\Helper;
use App\Http\Requests;
use Analytics;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public $day;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            /** Session Day */
            $this->day = session('day', '30');

            /** Disk Yönetimi */
            $diskstatus = new DiskStatus('/');
            $diskFreeSpace =  $diskstatus->freeSpace();
            $diskUsedSpace = $diskstatus->usedSpace();

            /** Sayfa Görüntülenme ve Ziyaretçi Adetleri */
            //$analytics = Analytics::fetchVisitorsAndPageViews(\Spatie\Analytics\Period::create(Carbon::now()->subMonth(), Carbon::now()));

            $analytics = Analytics::fetchVisitorsAndPageViews(\Spatie\Analytics\Period::days($this->day));
            $pageviews = 0;
            $visitors = 0;

            foreach ($analytics as $analytic) {
                $pageviews += $analytic['pageViews'];
                $visitors += $analytic['visitors'];
            }

            /** Popüler Tarayıcı */

            $browsers = Analytics::fetchTopBrowsers(\Spatie\Analytics\Period::days($this->day));

            /** Gelen Kaynaklar Backlinks */
            $referrers = Analytics::fetchTopReferrers(\Spatie\Analytics\Period::days($this->day));

            /** Sayfa Oturumları */

            $mostVisitedPages = Analytics::fetchMostVisitedPages(\Spatie\Analytics\Period::days($this->day));

            /** Ziyaretçi Trafiği (New Visitor/Returned Visitor) */

            $analyticsUserTypes = Analytics::performQuery(\Spatie\Analytics\Period::days($this->day), 'ga:sessions',
                ['dimensions' => 'ga:userType', 'sort' => 'ga:sessions']);
            $userTypes = $analyticsUserTypes->rows;

            /** Tarihe Göre Oturumlar */

            $analyticsOrderbyDates = Analytics::performQuery(\Spatie\Analytics\Period::days($this->day), 'ga:visitors',
                ['dimensions' => 'ga:date', 'sort' => 'ga:date']);

            $orderbyDate = collect($analyticsOrderbyDates['rows'] ?? [])
                ->map(function (array $pageRow) {
                    return [
                        'date' => Carbon::parse($pageRow[0])->format('d/m/Y'),
                        'pageViews' => $pageRow[1],
                    ];
                });

            $analyticsDates = Helper::escapeBrackets($orderbyDate->pluck('date'));
            $analyticsPageViews = Helper::escapeBrackets($orderbyDate->pluck('pageViews'));

            /** Şehre Göre Oturumlar */

            $city = Analytics::performQuery(\Spatie\Analytics\Period::days($this->day), 'ga:sessions',
                ['dimensions' => 'ga:city', 'sort' => '-ga:sessions', 'max-results' => '10']);
            $analyticsCity = $city->rows;

            return view('admin.dashboard', compact('pageviews', 'visitors', 'browsers', 'diskFreeSpace',
                'diskUsedSpace','referrers', 'mostVisitedPages', 'userTypes', 'analyticsDates', 'analyticsPageViews', 'analyticsCity'));

        } catch(\Exception $e) {

            // Google Analytics hesabı olmayan kullanıcılar içn alternatif dashboard!

            $callback_forms = Form::where('type',1)->take(20)->get();
            $contact_forms = Form::where('type',2)->take(20)->get();

            $info = [
                'message' => $e->getMessage(),
                'alert' => 'error',
                'tr' => 'Lütfen Google Analytics OAuth2 bilgilerinizi kontrol ediniz.',
                'config_file' => storage_path('app/laravel-google-analytics/service-account-credentials.json'),
            ];

            return view('admin.dashboard_error', compact('callback_forms', 'contact_forms'))->with('info', $info);
        }
    }

    public function show($day)
    {
        $days = ['7', '15', '30', '60'];

        if (!in_array($day, $days)) {
            return redirect()->route('admin.dashboard.index');
        }
        session(['day' => $day]);
        return redirect()->route('admin.dashboard.index');
    }

}
