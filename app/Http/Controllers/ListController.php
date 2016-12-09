<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\DataTables\Scopes\SortScopeWithLocale;
use App\Product;
use Illuminate\Http\Request;
use Session;


class ProductController extends Controller
{

    /**
     * @param ProductDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(ProductDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScopeWithLocale)->render('admin.products.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = Product::create($request->all());

        if($request->hasFile('image')) {
            $upload_id = UploadController::multipleImageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'articles',
            ]);
            $article->photos()->attach($upload_id, ['source_type' => 'articles']);
        }

        $notify[] = ['message' => 'Ürün eklendi.', 'alert' => 'success'];
        return redirect()->route('admin.products.index')->withNotify($notify);
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
            return redirect()->route('admin.products.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $article_id) {
                    Product::where("id", $article_id)->update(['list_id' => $i]);
                    $i++;
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sıralama değiştirildi.'
                ]);
            }
        } elseif($sort) {
            Session::put('sort', $sort);
            $notify[] = ['message' => 'Filtreleme seçeneği değiştirildi', 'alert' => 'success'];
            return redirect()->route('admin.products.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.products.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('photos', 'categories')->findorFail($id);
        return view('admin.products.create', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::with('photos')->find($id);
        $product->update($request->all());

        if($request->hasFile('image')) {
            $upload_id = UploadController::multipleImageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'products',
            ]);

            $product->photos()->attach($upload_id, ['source_type' => 'products']);
        }

        $notify[] = ['message' => 'Ürün düzenlendi.', 'alert' => 'success'];
        return redirect()->back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);
        $product->delete();

        $notify[] = [
            'message' => 'Yazı silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
        return route('admin.products.index');
    }

    public function multiple(Request $request)
    {
        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $products = Product::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Ürün pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Ürün aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Ürün silinmiştir.';
            }

            foreach ($products as $product) {
                if (is_null($active)) {
                    $product->delete();
                } else {
                    $product->active = $active;
                    $product->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }
    }

    /**
     * @param Request $request
     */
    public function deletePhoto(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $product->photos()->detach($request->input('photo_id'));

        $notify[] = [
            'message' => 'Fotoğraf silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function ajax(Request $request)
    {
        if ($request->ajax()) {

            $product_id = $request->input('product_id');
            $photo_id = $request->input('file_id');
            $product = Product::find($product_id);

            if(count($product)){
                $product->photos()->sync([$photo_id], $detach = false);
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }

    /**
     * @param $pivot_id
     * @param $source_id
     * @return mixed
     */
    public function setShowcase($pivot_id, $source_id) {

        // Clear
        DB::table('files_relations')->where('source_id', $source_id)->update(['showcase' => 0]);

        // Update
        DB::table('files_relations')->where('id', $pivot_id)->update(['showcase' => 1]);

        $notify[] = [
            'message' => 'Vitrin fotoğrafı seçildi',
            'alert' => 'success'];

        return back()->withNotify($notify);
    }

}
