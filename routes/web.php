<?php

use App\Post;
use App\Category;
use App\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layout');
// });

Route::get('/', function () {
    //$posts=Post::all();
    $posts=Post::latest()->paginate(5);
    return view('index',['postas'=>$posts]);
})->name('blog.index');


// Route::get('/', function () {
//     return view('index');
// })->name('blog.index');

Route::get('/contact', function () {
    return view('contact');
})->name('blog.contact');

Route::get('/about-us', function () {
    return view('about-us');
})->name('blog.about-us');

Route::get('/archive-blog', function () {
    return view('archive-blog');
})->name('blog.archive-blog');

Route::get('/single-post', function () {
    return view('single-post');
})->name('blog.single-post');

Route::get('/test', function () {
    $result=factory(\App\User::class,50)->create();
    dd($result);
})->name('blog.test');

// Route::get('/category', function () {
//     $result=factory(\App\Category::class,10)->create();
//     dd($result);
// })->name('blog.category');

Route::get('/categories', function () {
    $posts=Post::latest()->paginate(5);
    return view('categories',['postas'=>$posts]);
 })->name('blog.categories');

//___________________________________________

Route::get('/admin/login', function () {
    //return view('admin.login');
    return view('/admin/login');
 })->name('admin.login.get');;

 Route::post('/admin/login', function (Illuminate\Http\Request $request) {

    $data=$request->validate([
        'email'=>'required|email|exists:users.email',
        'password'=>'required|min:8|max:100',
    ]);

    $email=$data['email']; 
    $password=$data['password'];

    $credentials=[
        'email'=>$email,
        'password'=>$password,
    ];

    if(\Illuminate\Support\Fasades\Auth::attemp($credentials)){
        return redirect()->route('admin.auth.member');
    }

 })->name('admin.login.auth');

 Route::get('/admin/logout', function () {
    //return view('admin.login');
 });

 Route::get('/admin/member', function () {
    //return view('admin.login');
 })->name('admin.auth.member');

 //______________________________________________________________________________

//https://developer.github.com/apps/building-oauth-apps/authorizing-oauth-apps/

Route::get('/oauth', function () {
    $url="https://github.com/login/oauth/authorize"; 
    $parameters=[
        'client_id'=>'',
        'redirect_uri'=>'http://d26test-dz20.ua/callback',
        'scope'=>'user'
    ];

    return view("oauth",['url'=>$url.'?'.http_build_query($parameters)]);

});

Route::get('/callback', function (Illuminate\Http\Request $request) {
    // $url="https://github.com/login/oauth/access_token";   //POST https://github.com/login/oauth/access_token

    // $code=$request->get('code');

    // $parameters=[
    //     'client_id'=>'',
    //     'client_secret'=>'',
    //     'code'=>$code,
    //     'redirect_uri'=>'http://d26test-dz20.ua/callback',     
    // ];

    // $url=>$url.'?'.http_build_query($parameters);

});
