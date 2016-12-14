<?php

namespace App\Http\Controllers;

use App;
use Session;
use App\Campaign;
use App\Product;
use App\DataTables\CampaignsDataTable;
use App\DataTables\Scopes\SortScopeWithLocale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampaignController extends Controller
{

    /**
     * @param CampaignsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(CampaignsDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScopeWithLocale)->render('admin.campaigns.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.campaigns.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campaign = Campaign::create([
            'name' => $request->input('name'),
            'discount' => $request->input('discount'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
            'locale' => App::getLocale(),
            'active' => $request->input('active'),
        ]);

        if ($request->input('products')) {
            foreach ($request->input('products') as $product) {

                // Seçili ürünlerin farklı bir kampanyada olup olmadığını kontrol ediyoruz.

                if (in_array($product, $this->getAvailableProducts())) {
                    $items[] = $product;
                } else {
                    $notify[] = ['message' => 'Aynı anda iki kampanya seçilemez! (Ürün ID : #' . $product . ')', 'alert' => 'error'];
                }
            }
            if (isset($items)) {
                $campaign->products()->attach($items);
            }
        }

        $notify[] = ['message' => 'Kampanya oluşturulmuştur.', 'alert' => 'success'];
        return redirect()->route('admin.campaigns.index')->withNotify($notify);
    }


    /**
     * @param $sort
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.campaigns.index');
        }

        if ($sort == 'sort') {
            if ($request->has('arrayorder')) {
                $i = 0;
                $array_order = $request->input('arrayorder');
                foreach ($array_order as $campaign_id) {
                    Campaign::where("id", $campaign_id)->update(['list_id' => $i]);
                    $i++;
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sıralama değiştirildi.'
                ]);
            }
        } elseif ($sort) {
            Session::put('sort', $sort);
            $notify[] = ['message' => 'Filtreleme seçeneği değiştirildi', 'alert' => 'success'];
            return redirect()->route('admin.campaigns.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.campaigns.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('admin.campaigns.create', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campaign = Campaign::with('products')->find($id);
        $campaign->update($request->all());

        if ($request->input('products')) {
            $campaign->products()->detach();
            foreach ($request->input('products') as $product) {
                if (in_array($product, $this->getAvailableProducts())) {
                    $items[] = $product;
                } else {
                    $notify[] = ['message' => 'Aynı anda iki kampanya seçilemez! (Ürün ID : #' . $product . ')', 'alert' => 'error'];
                }
            }
            if (isset($items)) {
                $campaign->products()->attach($items);
            }
        } else {
            $campaign->products()->detach();
        }

        $notify[] = ['message' => 'Kampanya düzenlenmiştir.', 'alert' => 'success'];
        return redirect()->back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaigns = Campaign::findorFail($id);
        $campaigns->delete();

        $notify[] = [
            'message' => 'Kampanya silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
        return route('admin.campaigns.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function multiple(Request $request)
    {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if ($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $campaigns = Campaign::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Kampanya pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Kampanya aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Kampanya silinmiştir.';
            }

            foreach ($campaigns as $campaign) {
                if (is_null($active)) {
                    $campaign->delete();
                } else {
                    $campaign->active = $active;
                    $campaign->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı!',
            ]);
        }
    }

    /**
     * @return mixed
     * Kampanya'ya dahil edilebilir ürünler listesini getirir.
     * Hiç bir kampanyaya dahil olmayan veya kampanya süresi dolmuş ürünler listesidir.
     */
    public function getAvailableProducts()
    {
        return Product::doesntHave('campaigns')
            ->orWhereHas('campaigns', function ($query) {
                $query->where('date_end', '<=', Carbon::now())->orderBy('created_at', 'desc');
            })->get()->pluck('id')->toArray();
    }
}
