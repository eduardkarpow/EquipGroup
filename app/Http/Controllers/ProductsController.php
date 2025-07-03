<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getByPage(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $order = $request->input('order');
        $groups = $request->input('groups', []);
        $preparedGroups = array_filter(array_map('intval', $groups));

        $productsQuery = empty($preparedGroups) ? Product::take($limit) : Product::WhereIn('id_group', $preparedGroups)->take($limit);
        $productsQuery = $productsQuery->offset($page * $limit)->leftJoin('prices', 'products.id', '=', 'prices.id_product');

        switch ($order) {
            case 'name_inc':
                return $productsQuery->orderBy('name')->get();
            case 'name_idec':
                return $productsQuery->orderBy('name', 'desc')->get();
            case 'price_inc':
                return $productsQuery->orderBy('price')->get();
            case 'price_dec':
                return $productsQuery->orderBy('price', 'desc')->get();
            default:
                return $productsQuery->get();
        }
    }
    public function getAmountOfProducts(Request $request) {
        $groups = $request->input('groups', []);
        $preparedGroups = array_filter(array_map('intval', $groups));
        return empty($preparedGroups) ? Product::count() : Product::whereIn('id_group', $preparedGroups)->count();
    }

    public function getProductInfo(Request $request)
    {
        $id = $request->input('id');
        $product = Product::where('id', $id)->with('price')->get();

        return $product;
    }
}
