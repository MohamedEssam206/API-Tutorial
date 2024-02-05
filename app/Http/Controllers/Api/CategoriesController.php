<?php

namespace App\Http\Controllers\Api;

use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class CategoriesController extends Controller
{
use  GeneralTrait;

    public function index()
    {
        $categories =  Categories::get();
//        return response()->json($categories);
        return $this->returnData('categories'  ,$categories , 'تم استرجاع جميع البيانات ');

    }

    public function getCategoryById(Request $request)
    {
        $category =  Categories::select()->find($request->id);
        if (!$category)
            return $this->returnError('00001' , 'هذا القسم لا يوجد ');

        return $this->returnData('category' ,  $category  , 'تم استرجاع البيانات بنجاح ');
    }

    public function changeStatus(Request $request)
    {
      Categories::where('id' , $request-> id) -> update(['active' => $request -> active ]);
        return $this->returnsuccessMessage('تم تغيير الحاله بنجاح  ' , '200');
    }

}
//select('id' ,'name_'.app() ->getLocale(). ' as name' )
