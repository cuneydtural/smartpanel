<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryLocale;
use App\DataTables\CategoriesDataTable;
use App\DataTables\Scopes\CategoryScope;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use DB;

use App\Http\Requests;

class CategoryController extends Controller
{

    protected $root;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->root = Category::root();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent_id = $this->root->id;
        $categories = $this->root->children()->with('locales')->get();
        $breadcrumb = $this->root->first()->getAncestorsAndSelf();
        return view('admin.categories.index', compact('parent_id', 'breadcrumb', 'categories'));
    }


    public function data(CategoriesDataTable $dataTable)
    {
        $categories =  $dataTable->addScope(new CategoryScope);
        return $categories->render('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $parent_id = $request->input('parent_id');
        $breadcrumb = $this->breadcrumb($parent_id);
        return view('admin.categories.create', compact('parent_id', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::where('id', $request->input('parent_id'))->first();
        $category->children()->create([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
            'active' => $request->input('active'),
            'list_id' => 1,
            'link_type' => $request->input('link_type'),
            'url' => $request->input('url'),
            'article_url' => $request->input('article_url')
        ]);
        $notify[] = ['message' => 'Kategori eklendi', 'alert' => 'success'];
        return redirect()->route('admin.categories.show', $request->input('parent_id'))->withNotify($notify);
    }

    /**
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parent_id = $id;
        $breadcrumb = $this->breadcrumb($id);
        $categories = Category::where('id', '=', $id)->first()->getDescendantsAndSelf()->toHierarchy();
        return view('admin.categories.index', compact('parent_id','breadcrumb', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with('locales')->find($id);
        $breadcrumb = $this->breadcrumb($id);
        return view('admin.categories.create', compact('category', 'breadcrumb'));
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

        $category = Category::find($id);
        $category->update([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
            'active' => $request->input('active'),
            'link_type' => $request->input('link_type'),
            'url' => $request->input('url'),
            'article_url' => $request->input('article_url')
        ]);
        $notify[] = [
            'message' => 'Kategori güncellendi',
            'alert' => 'success'
        ];

        return back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::with('locales')->findOrFail($id);

        if($category->depth <> 1) {

            // Bağlı dilleri siler.
            $this->deleteLocalesRelation($category);
            $category->delete();

            $notify[] = [
                'message' => 'Kategori silindi',
                'alert' => 'success'];
        } else {
            $notify[] = [
                'message' => 'Anakategori silinemez!',
                'alert' => 'success'];
        }

        Session::flash('notify', $notify);
        return route('admin.categories.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function breadcrumb($id)
    {
        $breadcrumb = Category::where('id', '=', $id)->first()->getAncestorsAndSelf();
        return $breadcrumb;
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
            $categories = Category::with('locales')->find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $swal = [
                        'message' => 'Kategori pasif edildi',
                        'status' => 'success'
                    ];
                    break;
                case 'active':
                    $active = 1;
                    $swal = [
                        'message' => 'Kategori aktif edildi',
                        'status' => 'success'
                    ];
                    break;
                case 'destroy':
                    $active = null;
            }

            foreach ($categories as $category) {
                if (is_null($active)) {
                    if($category->depth <> 1) {

                        // Bağlı dilleri siler.
                        $this->deleteLocalesRelation($category);
                        $category->delete();

                        $swal = [
                            'message' => 'Kategori silindi!',
                            'status' => 'success'
                        ];
                        
                    }else {
                        $swal = [
                            'message' => 'Ana kategoriler silinemez!',
                            'status' => 'error'];
                    }
                } else {
                    $category->active = $active;
                    $category->save();
                }
            }

            return response()->json($swal);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }

    }

    /**
     * Kategorileri sıfırla
     */
    public function seed()
    {
        DB::table('categories')->delete();
        DB::table('category_langs')->delete();
        Artisan::call('db:seed', ['--class' => 'CategoryTableSeeder']);

        $notify[] = [
            'message' => 'Kategoriler sıfırlandı',
            'alert' => 'success'];

        Session::flash('notify', $notify);
    }

    /**
     * @param $sort
     * @param Request $request
     * @return mixed
     */
    public function sortCategory($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.categories.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $category_id) {
                    Category::where("id", $category_id)->update(['list_id' => $i]);
                    $i++;
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sıralama değiştirildi.'
                ]);
            }
        } elseif($sort) {
            Session::put('sort', $sort);
            $notify[] = [
                'message' => 'Filtreleme seçeneği değiştirildi',
                'alert' => 'success'
            ];
            return redirect()->route('admin.categories.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.categories.index');
        }
    }

    public function indexLocale($id)
    {
        $locales = CategoryLocale::where('category_id', $id)->get();
        return view('admin.categories.locale.index', compact('locales'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function createLocale($id)
    {
        return view('admin.categories.locale.create', compact('id'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function editLocale($id)
    {
        $category = CategoryLocale::find($id);
        $id = null;
        return view('admin.categories.locale.create', compact('category', 'id'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeLocale(Request $request)
    {

        $hasLocale = CategoryLocale::where('category_id', $request->input('category_id'))->where('locale', $request->input('locale'))->get();

        if(count($hasLocale)) {

            $notify[] = [
                'message' => 'Daha önce bu kategoriye dil eklediniz! Dil listeleri üzerinden düzeltebilir yada silebilirsiniz.',
                'alert' => 'error'
            ];

        } else {
            CategoryLocale::create([
                'category_id' => $request->input('category_id'),
                'name' => $request->input('name'),
                'slug' => str_slug($request->input('name')),
                'locale' => $request->input('locale'),
                'url' => $request->input('url'),
                'article_url' => $request->input('article_url'),
                'link_type' => $request->input('link_type')
            ]);

            $notify[] = [
                'message' => 'Dil seçeneği eklendi',
                'alert' => 'success'
            ];
        }

        return back()->withNotify($notify);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateLocale(Request $request, $id)
    {
        $locale = CategoryLocale::find($id);
        $locale->update([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
            'active' => $request->input('active'),
            'list_id' => 1,
            'link_type' => $request->input('link_type'),
            'url' => $request->input('url'),
            'article_url' => $request->input('article_url'),
            'locale' => $request->input('locale')
        ]);

        $notify[] = [
            'message' => 'Dil bilgileri güncellendi',
            'alert' => 'success'
        ];

        return back()->withNotify($notify);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteLocale($id)
    {
        $locale = CategoryLocale::find($id);
        $locale->delete();

        $notify[] = [
            'message' => 'Dil silindi',
            'alert' => 'success'
        ];

        return back()->withNotify($notify);
    }

    /**
     * @param $category
     * @return mixed
     * Seçili kategorinin altkategorilerini bulur. ID'leri diziye atar.
     * İlgili ID'lerin dillerini siler.
     */
    public function deleteLocalesRelation($category)
    {
        $childs =  $category->getDescendantsAndSelf();
        foreach($childs as $child) {
            $data[] =  $child->id;
        }
        CategoryLocale::whereIn('category_id', $data)->delete();
    }


}
