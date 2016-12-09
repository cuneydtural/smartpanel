<?php

namespace App\Http\Controllers;

use App\Article;
use App\DataTables\ArticlesDataTable;
use App\DataTables\Scopes\SortScopeWithLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Session;
use App\Http\Requests;

class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('admin.articles.index');
    }

    /**
     * @param ArticlesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(ArticlesDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScopeWithLocale)->render('admin.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'locale' => App::getLocale(),
            'link_type' => $request->input('link_type'),
            'url' => $request->input('url'),
            'article_url' => $request->input('article_url'),
            'date' => $request->input('date'),
        ]);

        if($request->hasFile('image')) {
            $upload_id = UploadController::multipleImageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'articles',
            ]);
            $article->photos()->attach($upload_id, ['source_type' => 'articles']);
        }

        $notify[] = ['message' => 'Yazı eklendi.', 'alert' => 'success'];
        return redirect()->route('admin.articles.index')->withNotify($notify);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::with('photos', 'categories')->findorFail($id);
        return view('admin.articles.create', compact('article'));
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
        $article = Article::with('photos')->find($id);

        $article->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'active' => $request->input('active'),
            'slug_update' => $request->input('slug_update'),
            'keywords' => $request->input('keywords'),
            'link_type' => $request->input('link_type'),
            'url' => $request->input('url'),
            'article_url' => $request->input('article_url'),
            'date' => $request->input('date'),
        ]);

        // slug null değeri gönderildiğinde slug güncellemesi yapar.
        if($request->input('slug_update')) {
            $article->slug = null;
            $article->save();
        }

        if($request->hasFile('image')) {
            $upload_id = UploadController::multipleImageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'articles',
            ]);

            $article->photos()->attach($upload_id, ['source_type' => 'articles']);
        }
        $notify[] = ['message' => 'Yazı düzenlendi.', 'alert' => 'success'];
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
        $article = Article::findorFail($id);
        $article->delete();

        $notify[] = [
            'message' => 'Yazı silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
        return route('admin.articles.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $articles = Article::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Yazı pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Yazı aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Yazı silinmiştir.';
            }

            foreach ($articles as $article) {
                if (is_null($active)) {
                    $article->delete();
                } else {
                    $article->active = $active;
                    $article->save();
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
        $article = Article::find($request->input('article_id'));
        $article->photos()->detach($request->input('photo_id'));

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

            $article_id = $request->input('article_id');
            $photo_id = $request->input('file_id');
            $article = Article::find($article_id);

            if(count($article)){
                $article->photos()->sync([$photo_id], $detach = false);
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }

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


    /**
     * @param $sort
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.slides.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $article_id) {
                    Article::where("id", $article_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.articles.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.articles.index');
        }
    }

}
