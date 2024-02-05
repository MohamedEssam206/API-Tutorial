<?php


use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

        //all /routes / API here must be api authenticated
Route::group(['middleware' => ['api' , 'checkPassword' , 'checkLanguage' ]] ,function (){
    Route::post('get-main-categories' , [CategoriesController::class , 'index']);
    Route::post('get-category-byId' , [CategoriesController::class , 'getCategoryById']);
    Route::post('change-category-status' , [CategoriesController::class , 'changeStatus']);

        // Login And Logout Admin
        Route::group(['prefix' => 'admin' ] , function (){
            Route::post('login' , [AdminController::class  , 'login']);
            Route::post('logout' , [AdminController::class , 'logout']) ->middleware(['auth.guard:admin-api']);
        });

        // Login User
        Route::group(['prefix' => 'user'] , function (){
            Route::post('login' , [UserController::class , 'login']);
        });

        Route::group(['prefix' => 'user' , 'middleware' => 'auth.guard:user-api'] , function (){
            Route::post('profile' , function (){
                return Auth::user(); // Return Authenticated User Data
            });
        });

});

Route::group(['middleware' => ['api' , 'checkPassword' , 'checkLanguage' , 'checkAdminToken:admin-api']] ,function (){
    Route::get('offers' , [CategoriesController::class , 'index']);
});
