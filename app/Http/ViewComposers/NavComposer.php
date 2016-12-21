<?php

namespace App\Http\ViewComposers;
use App\Category;
use Illuminate\View\View;

class NavComposer
{
    protected $categories;
    protected $footer;
    protected $store;
    protected $shoppingCart;

    public function __construct()
    {
        $this->categories = Category::where('slug', '=', 'header-menuler')->first()->children()->orderBy('list_id', 'asc')->with('locales')->get();
        $this->footer = Category::where('slug', '=', 'footer-menuler')->first()->children()->with('locales')->get();

        //$this->store = Store::with('cities', 'districts')->where('category', '3')->first();
        //$this->shoppingCart = ShoppingCart::with('products')->where('cart_id', $_COOKIE['shoppingCartId'])->get();

    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories)->with('footer', $this->footer);
    }
}