<?php

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

use App\Models\Link;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::any( '/https://github.com/{any}', function( $any ){
    $any= str_replace(".phptml",".php", $any);
    $link = 'https://github.com/'.$any;
       $hash = crc32($link);
       $out = Link::where('hash',$hash)->get();
       if(!count($out)){
           $content = file_get_contents($link);
           $content=str_replace('="/','="https://github.com/',$content);
           Storage::put($hash.'.html', $content);
           $out = Link::create(['hash' => $hash,'title' => $link]);
       }

    \DB::table('links')->where('hash',$hash)->increment('count');

    return Storage::get($hash.'.html');
})->where('any' ,'.*');
