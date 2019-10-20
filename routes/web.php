<?php
//require_once 'vendor/autoload.php';

use App\Post;
use App\Category;
use App\User;
//use Vendor\Guzzlehttp\Guzzle\Src\Client;


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




//___________Start Oauth API GitHub d26-dz20__________________

//https://developer.github.com/apps/building-oauth-apps/authorizing-oauth-apps/

//GET https://github.com/login/oauth/authorize
//POST https://github.com/login/oauth/access_token
//https://api.github.com/users/Serj3000
//https://github.com/settings/applications/1154571


//MDQ6VXNlcjUyNDIzMDc5
//a13b2577c6225ab009ca69157a90225f307d393d

Route::get('/oauth', function () {

    $url="https://github.com/login/oauth/authorize";

    $parameters=[
        'client_id'=>"81979f635760a000baa9",
        'redirect_uri'=>"http://d26test-dz20.ua/callback",
        'scope'=>"user"
    ];

    //dd($url.'?'.http_build_query($parameters));

    return view("oauth",['url'=>$url.'?'.http_build_query($parameters)]);

})->name('oauth');

Route::get('/callback', function (\Illuminate\Http\Request $request) {

    $url="https://github.com/login/oauth/access_token";   //POST https://github.com/login/oauth/access_token

    $code=$request->get('code');

    // //dd($code);
    // // exit;
    // echo '<br> $code= '.$code;

    $parameters=[
        'client_id'=>'81979f635760a000baa9',
        'client_secret'=>'5a7dc3985d466490d37f220fd6154129fb3f990c',
        'code'=>$code,
        'redirect_uri'=>'http://d26test-dz20.ua/callback',
    ];

    $url=$url.'?'.http_build_query($parameters);

    $client=new \GuzzleHttp\Client();
    $response=$client->post($url);
    $contents=$response->getBody()->getContents();

    // dd($contents);

    // echo '<br> $contents= '. $contents;

    parse_str($contents, $parameters);

    $token=$parameters['access_token'];

    // echo '<br> $token= '. $token;
    // //exit;

    // //get user info

    //$response=$client->get('https://api.github.com/users',[ /Serj3000
$response=$client->get('https://api.github.com/users/Serj3000',[ 
        'headers'=>[
        'Authorization'=>'token'.$token]
    ]);

    //dd($response->getBody()->getContents());
    //             // exit;

    $data=json_decode($response->getBody()->getContents(),true);

    
                            //echo '<br> $data= '. $data;
                            //echo '<br> $data= '. var_dump($data);
                            //dd($data);
                            //exit;

    $response=$client->get('https://api.github.com/users/emails',[ //https://api.github.com/user/email
            'headers'=>[
            'Authorization'=>'token'.$token]
        ]);
    
    $emails=json_decode($response->getBody()->getContents(),true);

                            //dd($emails);
                            //exit;

    $user=\App\User::where('email','=',$emails[0]['email'])->first();

    if(!$user){
        $user=new \App\User;
        $user->name=$data['name'];
        $user->email=$emails[0]['email'];
        $user->password=bcrypt('74574635385345');
        $user->save();

    // Добавить API Bot Telegram

        $url="https://api.telegram.org/bot886184318:AAHgJKTM-GVWdEOGRLVeCz2qb1GFU9R2Zr4/getUpdates";
    
        $parameters=[
            'chat_id'=>'896366319',
            'text'=>'Новый GitHub пользователь:',//.$user->email,
        ];
    
        $url=$url.'?'.http_build_query($parameters);
    };

        \Illuminate\Support\Facades\Auth::login($user,true);

        return redirect()->route('admin.auth.member');

});

//_______________End Oauth API GitHub d26-dz20____________________
