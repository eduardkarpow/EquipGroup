<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function getAllGroups() {
        $groups = Group::withCount('products')->get();

        return $groups;
    }

    public function getProductBreadcrumbs(Request $request) {
        $id = (int)$request->input('id');
        $product = Product::with('group')->find($id);
        //print($product);
        if(!$product) {
            return response()->json(['error' => 'Продукт не найден.'], 404);
        }

        $breadcrumbs = [];


        $currentGroup = $product->group;

        while ($currentGroup) {
            array_unshift($breadcrumbs, [
                'id' => $currentGroup->id,
                'name' => $currentGroup->name,
            ]);

            $currentGroup = $currentGroup->parent;
        }

        return response()->json($breadcrumbs);
    }
}
