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
Route::get('/', function () {
    return view('welcome');
});

Route::get('festivals', 'FestivalController@init');
Route::get('festivalsLookFor', 'FestivalController@busqueda');
Route::get('festivalsLookForGenre', 'FestivalController@busquedaPorGenero');
Route::get('festivalsLookForParametrized', 'FestivalController@busquedaConParametros');

Route::get('artistsLookFor', 'ArtistController@busqueda');
Route::get('artistsLookForParametrized', 'ArtistController@busquedaConParametros');
Route::get('artistsLookForGenre', 'ArtistController@busquedaPorGenero');
Route::get('artists', 'ArtistController@init');
Route::get('artist/new', 'ArtistController@FormNew');
Route::post('artist/new/create', 'ArtistController@Create');
Route::get('artist/{permalink}', 'ArtistController@Details');
Route::get('artist/{permalink}/edit', 'ArtistController@Edit');
Route::put('artist/{permalink}/edit/update', 'ArtistController@Update');
Route::get('artist/{permalink}/delete', 'ArtistController@Delete');
Route::get('artist/{permalink}/delete/confirm', 'ArtistController@DeleteConfirm');

Route::get('fesitvals/new', 'FestivalController@FormNew');
Route::post('festivals/new/create', 'FestivalController@Create');
Route::get('festival/{permalink}', 'FestivalController@Details');
Route::get('festival/{permalink}/edit', 'FestivalController@Edit');
Route::put('festival/{permalink}/edit/update', 'FestivalController@Update');
Route::get('festival/{permalink}/delete', 'FestivalController@Delete');
Route::get('festival/{permalink}/delete/confirm', 'FestivalController@DeleteConfirm');

Route::get('deletePost/{id}', 'FestivalController@DeletePost');
Route::get('festival/mostrarPost/{id}', 'FestivalController@MostrarNoticia');


/*
 * ADMIN
 */
Route::get('admin', function () {
    redirect()->action('AdminController@AvailableEntities');
});
//List
Route::get('admin/entities', 'AdminController@AvailableEntities');
Route::get('admin/artists', 'AdminController@ArtistsList');
Route::get('admin/festivals', 'AdminController@FestivalsList');
Route::get('admin/genres', 'AdminController@GenresList');
Route::get('admin/posts', 'AdminController@PostsList');
Route::get('admin/photos', 'AdminController@PhotosList');

//Add
Route::get('admin/artists/add', 'ArtistController@FormNew');
Route::get('admin/festivals/add', 'FestivalController@FormNew');
Route::get('admin/genres/add', 'GenreController@FormNew');
Route::get('admin/posts/add', 'PostController@FormNew');
Route::get('admin/photos/add', 'PhotoController@FormNew');

//Create
Route::post('admin/genres/create', 'GenreController@Create');


//Details
Route::get('admin/artists/details/{permalink}', 'ArtistController@DetailsAdmin');
Route::get('admin/festivals/details/{permalink}', 'FestivalController@DetailsAdmin');
Route::get('admin/genres/details/{permalink}', 'GenreController@DetailsAdmin');
Route::get('admin/posts/details/{permalink}', 'PostController@DetailsAdmin');
Route::get('admin/photos/details/{permalink}', 'PhotoController@DetailsAdmin');

//Edit
Route::get('admin/artists/edit/{permalink}', 'ArtistController@Edit');
Route::get('admin/festivals/edit/{permalink}', 'FestivalController@Edit');
Route::get('admin/genres/edit/{permalink}', 'GenreController@Edit');
Route::get('admin/posts/edit/{permalink}', 'PostController@Edit');
Route::get('admin/photos/edit/{permalink}', 'PhotoController@Edit');

//Update
Route::put('admin/genres/update/{permalink}', 'GenreController@Update');

//Delete
Route::get('admin/genres/delete/{permalink}', 'GenreController@DeleteConfirm');
Route::get('admin/posts/delete/{permalink}', 'PostController@DeleteConfirm');
Route::get('admin/photos/delete/{permalink}', 'PhotoController@DeleteConfirm');