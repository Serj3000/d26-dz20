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





//______________Start_d25-dz21__________________

Route::get('/admin/login', function () {
    return view('/admin/login');
})->name('admin.login.get');

Route::post('/admin/login', function (Illuminate\Http\Request $request) {

$data=$request->validate([
    'email'=>'required|email|exists:users,email',
    'password'=>'required|min:8|max:100',
]);

$email=$data['email']; 
$password=$data['password'];

$credentials=[
    'email'=>$email,
    'password'=>$password,
];

if(\Illuminate\Support\Facades\Auth::attempt($credentials)){
    return redirect()->route('admin.auth.member');
}

})->name('admin.login.auth');

Route::get('/admin/logout', function () {
\Illuminate\Support\Facades\Auth::logout();
return redirect('/');
})->middleware('auth'); // middleware('auth') здесь необходим, для случая, когда небыл выполнен login

Route::get('/admin/member', function () {
    $user=\Illuminate\Support\Facades\Auth::user();
})->middleware('auth')->name('admin.auth.member');

//_______________End_d25-dz21____________________




//___________Start API GitHub d26-dz20__________________

//https://developer.github.com/apps/building-oauth-apps/authorizing-oauth-apps/

Route::get('/oauth', function () {
    
    $url="https://api.telegram.org";

    $parameters=[
        'client_id'=>'',
        'redirect_uri'=>'http://d26test-dz20.ua/callback',
        'scope'=>'user'
    ];

    return view("oauth",['url'=>$url.'?'.http_build_query($parameters)]);

});

Route::get('/callback', function (\Illuminate\Http\Request $request) {

    $url="https://github.com/login/oauth/access_token";   //POST https://github.com/login/oauth/access_token

    $code=$request->get('code');

    $parameters=[
        'client_id'=>'',
        'client_secret'=>'',
        'code'=>$code,
        'redirect_uri'=>'http://d26test-dz20.ua/callback',     
    ];

    $url=>$url.'?'.http_build_query($parameters);

    $client=new \GuzzleHttp\Client();
    $response=$client->post($url);
    $contents=$response->getBody()->getContents();

    parse_str($contents, $parameters);

    $token=$parameters['access_token'];

    //get user info

    $response=$client->get('hhttps://api.github.com/users',[
        'headers'=>[
            'Authorization'=>'token'.$token]
        ]);
    
    $data=json_decode($response->getBody()->getContents(),true);

    $response=$client->get('hhttps://api.github.com/emails',[
    'headers'=>[
        'Authorization'=>'token'.$token]
    ]);
    
    $emails=json_decode($response->getBody()->getContents(),true);

    $user=\App\User::where('email','=',$emails[0]['email'])->first();

    if(!$user){
        $user=new \App\User;
        $user->name=$data['name'];
        $user->email=$emails[0]['email'];
        $user->password=bcrypt('74574635385345');
        $user->save();

        // Добавить API Bot Telegram

        $url="https://api.telegram.org/bot886184318:AAHgJKTM-GVWdEOGRLVeCz2qb1GFU9R2Zr4/getUpdates"
    
        $parameters=[
            'chat_id'=>'896366319',
            'text'=>'Новый GitHub пользователь: '.'"$user->email"',
        ];
    
        $url.'?'.http_build_query($parameters);

    }

    \Illuminate\Support\Facades\Auth::login($user,true);

    return redirect()->route('admin.auth.member');

});

//_______________End API GitHub d26-dz20____________________


//____________Start API Telegram d26-dz20___________________

//Пример
//https://api.telegram.org/bot<token>/METHOD_NAME
//https://api.telegram.org/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11/getMe




// Route::get('/oauth', function () {
//     $url="https://api.telegram.org/bot886184318:AAHgJKTM-GVWdEOGRLVeCz2qb1GFU9R2Zr4/getUpdates"; 
//     $parameters=[
//         //'client_id'=>'896366319',
//         'chat_id'=>'896366319',
//         'redirect_uri'=>'http://d26test-dz20.ua/callback',
//         'scope'=>'user'
//     ];

//     return view("oauth",['url'=>$url.'?'.http_build_query($parameters)]);

// });
//*Метод sendMessage через GET
/*$url="https://api.telegram.org/bot886184318:AAHgJKTM-GVWdEOGRLVeCz2qb1GFU9R2Zr4/sendMessage?chat_id=896366319&text=Test Telegramm Bot API !!!";
*/

//_______________End API Telegram d26-dz20___________________