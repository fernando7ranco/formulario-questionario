<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'QuestionarioController@list')->name('home');

Route::group(['prefix' => 'questionarios'], function(){

    Route::get('list/','QuestionarioController@list')->name('listar-questionario');

    Route::get('show/{id}/','QuestionarioController@formEditar')->where('id', '[0-9]+')->name('editar-questionario');
    Route::put('update/','QuestionarioController@update')->name('alterar-questionario');

    Route::get('create/','QuestionarioController@formCadastro')->name('form-cadastro-questionario');
    Route::post('create/','QuestionarioController@create')->name('cadastrar-questionario');

    Route::get('response/{id}/','QuestionarioController@formResponder')->where('id', '[0-9]+')->name('form-responder-questionario');
    Route::post('response','QuestionarioController@responderQuestionario')->name('responder-questionario');

    Route::get('answers/{id}/','QuestionarioController@visualizarRespostas')->where('id', '[0-9]+')->name('respostas-questionario');


});
