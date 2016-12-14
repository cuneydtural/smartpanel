<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;
use App\Store;

use App\Http\Requests;

class ApiController extends Controller
{

    /**
     * @param $city_id
     * @return mixed
     * Selectbox Şehir'e göre sorgulama yapar. JSON çıktı verir.
     */
    public function queryDistricts($city_id) {

        if (request()->ajax()) {
            $districts = District::where('city_id', $city_id)->get();
            if(count($districts)) {
                return response()->json($districts);
            }
        } else {
            return redirect('/');
        }
    }

    public function queryStores($type_id, $city_id) {

        if (request()->ajax()) {
            $stores =  Store::with('cities')->where('city', $city_id)->where('category', $type_id)->orderBy('name', 'asc')->get();
            if(count($stores)) {
                foreach($stores as $store) {
                    $val[] = [
                        'id' => $store->id,
                        'category' => $store->category,
                        'name' => $store->name,
                        'url' => '/iletisim-bilgileri/'.$type_id.'/'.$store->id.'/'.str_slug($store->cities->city.'-'.$store->name),
                    ];
                }
                return response()->json($val);
            } else {
                return 404;
            }
        } else {
            return redirect('/');
        }
    }
}
