<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Festival;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    private $artists;

    public function init()
    {
        
        $artists = \App\Artist::get()->paginate(4);   
        return view('artist.all', ['artists' => $artists]);
      
    }

    public function All()
    {
        return view('artist.all', ['artists' => Artist::get(['permalink', 'name'])]);
    }

    public function FormNew()
    {
        return view('artist.create', ['festivals' => Festival::get(['id', 'name'])]);
    }

    public function Create(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:artists']);
        //Sabemos que los datos del nuevo artista están correctos
        $artist = new Artist([
            'name' => $request->get('name'),
            'soundcloud' => $request->get('soundcloud'),
            'website' => $request->get('website'),
            'country' => $request->get('country'),
            'permalink' => str_slug($request->get('name'))
        ]);
        $artist->save();
        //Al nuevo artista le pongo como sus festivales los que recibe de los select
        //OJO: usamos array_unique por si en el formulario hubiese dos select con el mismo festival
        $artist->festivals()->attach(array_unique($request->get('festivals-select') ?? []));
        return redirect()->action('ArtistController@Details', [$artist])->with('created', true);
    }

    public function Details($permalink)
    {
        return view('artist.details', [
            'permalink' => $permalink,
            'artist' => Artist::where('permalink', $permalink)->first()
        ]);
    }

    public function Edit($permalink)
    {
        $artist = Artist::where('permalink', $permalink)->first();
        $festivals = Festival::get(['id', 'name']);

        return view('artist.edit', [
            'permalink' => $permalink,
            'artist' => $artist,
            'festivals' => $festivals,
        ]);
    }

    public function Update(Request $request, $permalink)
    {
        //TODO Comprobar que el nuevo nombre no exista ya, pero si es el mismo dejar modificar
        $artist = Artist::where('permalink', $permalink)->first();
        $artist->name = $request->get('name');
        $artist->soundcloud = $request->get('soundcloud');
        $artist->website = $request->get('website');
        $artist->country = $request->get('country');
        $artist->permalink = str_slug($request->get('name'));
        $artist->save();
        $artist->festivals()->sync(array_unique($request->get('festivals-select') ?? []));
        return redirect()->action('ArtistController@Details', [$artist])->with('updated', true);
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
        Artist::where('permalink', $permalink)->delete();
        return redirect()->action('ArtistController@All')->with('deleted', true);
    }
    
    

    

    
}
