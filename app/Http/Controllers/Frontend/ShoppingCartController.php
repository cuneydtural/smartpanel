<?php

namespace App\Http\Controllers\Frontend;

use App\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Helper;
use App\Product;

class ShoppingCartController extends Controller
{

    protected $productId;
    protected $quantity;
    protected $productName;
    protected $prices;

    /**
     * @param Request $request
     * @return string
     * Sepet İşlemleri.
     */
    public function addToCart(Request $request)
    {

        $this->productId = $request->input('product_id');
        $this->productName = $request->input('product_name');
        $this->quantity = $request->input('quantity');

        // Kampanyalı ve indirimli fiyatları, güncel stok bilgilerini dizi olarak çeker.
        $this->prices = Product::getPrices($this->productId);

        // Ürün stokta varsa;
        if($this->prices['product_quantity'] > 0) {

            // Alışveriş Kartı Detayı
            $cart = ShoppingCart::where('product_id', $this->productId)
                ->where('cart_id', $this->shoppingCartId)->where('is_available', 1)->first();

            if (!count($cart)) {

                // Yeni Sepet Oluştur.

                $new = new ShoppingCart();
                $new->cart_id = $this->shoppingCartId;
                $new->product_id = $this->productId;
                $new->quantity = $this->quantity;
                $new->price = $this->prices['price'];
                $new->discount = $this->prices['discount'];
                $new->discounted_price = $this->prices['discounted_price'];
                $new->vat_included = $this->prices['vat_included'];
                $new->total_price = $this->prices['price'] * $this->quantity;
                $new->total_discounted_price = $this->prices['discounted_price'] * $this->quantity;

                if ($new->save()) {

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Sepetinize eklendi.',
                        'product_name' => $this->productName
                    ]);

                } else {

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Ürün sepete eklenemedi!',
                        'product_name' => $this->productName
                    ]);

                }
            } else {

                // Sepeti Güncelle.

                $cart->quantity = $cart->quantity + $this->quantity;
                $cart->price = $this->prices['price'];
                $cart->discount = $this->prices['discount'];
                $cart->discounted_price = $this->prices['discounted_price'];
                $cart->vat_included = $this->prices['vat_included'];
                $cart->total_price = $this->prices['price'] * $cart->quantity;
                $cart->total_discounted_price = $this->prices['discounted_price'] * $cart->quantity;

                if ($cart->save()) {

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Sepetiniz güncellendi.',
                        'product_name' => $this->productName
                    ]);

                } else {

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Ürün sepetinize eklenemedi!',
                        'product_name' => $this->productName
                    ]);

                }
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Seçtiğiniz ürün stoklarımızda bulunamadı!',
                'product_name' => $this->productName
            ]);
        }
    }

    /**
     * @return mixed
     * Sepeti yeniden load eder.
     */
    public function loadCart()
    {
        $shoppingCart = ShoppingCart::with('products')->where('cart_id', $_COOKIE['shoppingCartId'])->get();
        return view('frontend.shop.load', compact('shoppingCart'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCartItem(Request $request)
    {
        $item = ShoppingCart::find($request->input('cart_id'));
        if($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Ürün sepetinizden kaldırıldı.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Ürün sepetinizden kaldırılamadı!',
            ]);
        }
    }
}
