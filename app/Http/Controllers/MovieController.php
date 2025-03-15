<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $randomTerms = ['action', 'comedy', 'adventure', 'drama'];
        $randomTerm = $randomTerms[array_rand($randomTerms)];
        $movies = $this->movieService->searchMovies($randomTerm);

        return view('movies.index', ['movies' => $movies]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $title = $request->input('title');
        //return $title;
        $movies = $this->movieService->searchMovies($title);
        //return $movies;
        if ($movies) {
            return view('movies.index', ['movies' => $movies]);
        }

        return view('movies.index', ['movies' => null, 'error' => 'No movies found for this title. Search Something else']);
    }


    public function add_favorites(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|string|max:50',
            'movie_title' => 'required|string|max:255',
            'poster_url' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $exists = FavoriteMovie::where('user_id', $user->id)
            ->where('movie_id', $request->movie_id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Movie already in favorites!'], 400);
        }

        FavoriteMovie::create([
            'user_id' => $user->id,
            'movie_id' => $request->movie_id,
            'movie_title' => $request->movie_title,
            'poster_url' => $request->poster_url,
        ]);

        return response()->json(['success' => true, 'message' => 'Movie added to favorites!']);
    }


    public function dashboard()
    {
        $favorites = Auth::user()->favoriteMovies;
        return view('movies.dashboard', ['favorites' => $favorites]);
    }

}
