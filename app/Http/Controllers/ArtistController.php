<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Festival;
use App\Genre;
use Illuminate\Http\Request;
use Schema;

class ArtistController extends Controller implements AdministrableController
{
    private $artists;
    private $genres;

    public function init()
    {
        $artists = \App\Artist::paginate(3);
        $genres = \App\Genre::get();
        return view('artist.all')
            ->with('artists', $artists)
            ->with('genres', $genres);
    }

    public function busquedaPorGenero(Request $request)
    {
        $generos = array();
        $genres = \App\Genre::get();
        foreach ($genres as $genre) {
            $generoSinEspacios = str_replace(' ', '_', $genre->name);
            if ($request->has($generoSinEspacios)) {
                array_push($generos, $genre->id);
            }
        }
        $request->session()->flash('generos-marcados-artista', $generos);
        $artists = \App\Artist::join('artist_genre', "artist_genre.artist_id", "=", "id")->whereIn('genre_id', $generos)->groupBy("id")->paginate(3);
        $artists->appends($request->except('page'));
        return view('artist.all')
            ->with('artists', $artists)
            ->with('genres', $genres);

    }

    public function busquedaConParametros(Request $request)
    {
        $buscado = $request->input('buscado');
        $porPag = $request->input('paginadoA');
        $orden = $request->input('ordenado');
        $artists = \App\Artist::where('name', 'like', '%' . $buscado . '%')->orderBy('name', $orden)->paginate($porPag);
        $genres = \App\Genre::get();
        $artists->appends($request->except('page'));
        return view('artist.all')
            ->with('artists', $artists)
            ->with('genres', $genres);
    }

    public function All()
    {
        return view('artist.all', ['artists' => Artist::paginate(3)]);
    }

    public function FormNew()
    {
        return view('artist.create', [
            'festivals' => Festival::get(['id', 'name']),
            'genres' => Genre::get(['id', 'name']),
        ]);
    }

    public function Create(Request $request)
    {
        $genres_id = $request->get('genres', []);
        $genres = Genre::get(['id', 'name']);
        foreach ($genres as $genre) {
            $genre->checked = '';
            foreach ($genres_id as $genre_id) {
                if ($genre_id == $genre->id) {
                    $genre->checked = 'checked';
                    break;
                }
            }
        }
        $request->session()->flash('genres', $genres);
        $request->session()->flash('festivals', $request->get('festivals', []));
        $this->validate($request, [
            'name' => 'required',
            'permalink' => 'required|unique:artists'
        ]);
        //Sabemos que los datos del nuevo artista están correctos
        $artist = new Artist([
            'name' => $request->get('name'),
            'soundcloud' => $request->get('soundcloud'),
            'website' => $request->get('website'),
            'country' => $request->get('country'),
            'permalink' => $request->get('permalink')
        ]);
        $artist->saveOrFail();
        //Al nuevo artista le pongo como sus festivales los que recibe de los select
        //OJO: usamos array_unique por si en el formulario hubiese dos select con el mismo festival
        $artist->festivals()->sync($request->get('festivals'));
        $artist->genres()->sync($genres_id);
        return redirect()->action('ArtistController@DetailsAdmin', [$artist])->with('created', true);
    }

    public function Details($permalink)
    {
        return view('artist.details', [
            'permalink' => $permalink,
            'artist' => Artist::where('permalink', $permalink)->first()
        ]);
    }

    public function DetailsAdmin($permalink)
    {
        return view('artist.details-admin', [
            'column_names' => Schema::getColumnListing(strtolower(str_plural('artists'))),
            'permalink' => $permalink,
            'artist' => Artist::where('permalink', $permalink)->first()
        ]);
    }

    public function Edit($permalink)
    {
        $artist = Artist::where('permalink', $permalink)->first();
        $festivals = Festival::get(['id', 'name']);
        $genres = Genre::get(['id', 'name']);
        foreach ($genres as $genre) {
            $genre->checked = '';
            foreach ($artist->genres as $artist_genre) {
                if ($artist_genre->id == $genre->id) {
                    $genre->checked = 'checked';
                    break;
                }
            }
        }
        return view('artist.edit', [
            'permalink' => $permalink,
            'artist' => $artist,
            'festivals' => $festivals,
            'genres' => $genres,
        ]);
    }

    public function Update(Request $request, $permalink)
    {
        if ($request->get('permalink', '') != $permalink) {
            $this->validate($request, [
                'name' => 'required',
                'permalink' => 'required|unique:artists'
            ]);
        }
        $artist = Artist::where('permalink', $permalink)->first();
        $artist->name = $request->get('name');
        $artist->soundcloud = $request->get('soundcloud');
        $artist->website = $request->get('website');
        $artist->country = $request->get('country');
        $artist->permalink = $request->get('permalink');
        $artist->saveOrFail();
        $artist->genres()->sync($request->get('genres'));
        return redirect()->action('ArtistController@DetailsAdmin', [$artist])->with('updated', true);
    }

    public function Delete($permalink)
    {
        return view('artist.delete', [
            'permalink' => $permalink,
            'artist' => Artist::where('permalink', $permalink)->first()
        ]);
    }

    public function DeleteConfirm($permalink)
    {
        return redirect()->action('AdminController@ArtistsList')->with('deleted', Artist::where('permalink', $permalink)->delete());
    }

    public function ConfirmAssistance($artistPermalink, $festivalPermalink, $confirmation)
    {
        $confirmation = filter_var($confirmation, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        Artist::where('permalink', $artistPermalink)->firstOrFail()->festivals()
            ->updateExistingPivot(
                Festival::where('permalink', $festivalPermalink)->firstOrFail()->id,
                ['confirmed' => $confirmation]);
        //TODO implementar envio de correo de respuesta
        return redirect()->back();
    }
}
