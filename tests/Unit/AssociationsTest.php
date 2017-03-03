<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Artist;
use App\Festival;
use App\Genre;

class AssociationsTest extends TestCase
{
    /**
     * Checks the association Artist-Festival
     *
     * @return void
     */
    public function testAssociationArtistFestival()
    {
        $artist = new Artist();
        $artist->name = 'Suicidal Tendencies';
        $artist->save();

        $festival = new Festival();
        $festival->name = 'Download Festival';
        $festival->save();

        $festival->artists()->attach($artist->id);

        $this->assertEquals($artist->festivals[0]->name, 'Download Festival');
        $this->assertEquals($festival->artists[0]->name, 'Suicidal Tendencies');

        $festival->artists()->detach($artist->id);
        $festival->delete();
        $artist->delete();
    }

    /**
     * Checks the association Artist-Genre
     *
     * @return void
     */
    public function testAssociationArtistGenre()
    {
        $artist = new Artist();
        $artist->name = 'Suicidal Tendencies';
        $artist->save();

        $genre = new Genre();
        $genre->genre = 'Rock';
        $genre->save();

        $genre->artists()->attach($artist->id);

        $this->assertEquals($artist->genres[0]->genre, 'Rock');
        $this->assertEquals($genre->artists[0]->name, 'Suicidal Tendencies');

        $genre->artists()->detach($artist->id);
        $genre->delete();
        $artist->delete();
    }

    /**
     * Checks the association Festival-Genre
     *
     * @return void
     */
    public function testAssociationFestivalGenre()
    {
        $festival = new Festival();
        $festival->name = 'Download Festival';
        $festival->save();

        $genre = new Genre();
        $genre->genre = 'Rock';
        $genre->save();

        $genre->festivals()->attach($festival->id);

        $this->assertEquals($festival->genres[0]->genre, 'Rock');
        $this->assertEquals($genre->festivals[0]->name, 'Download Festival');

        $genre->artists()->detach($festival->id);
        $genre->delete();
        $festival->delete();
    }

}
