<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .navbar-toggler {
            border: none;
        }
        .search-container {
            max-width: 500px;
            margin: 20px auto;
        }
        .movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .movie-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }
        .movie-card:hover {
            transform: scale(1.05);
        }
        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .movie-info {
            padding: 15px;
        }
        .movie-info h5 {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }
        .movie-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9rem;
        }
        .error-message {
            text-align: center;
            color: #dc3545;
            font-size: 1.1rem;
            margin-top: 20px;
        }
        .movie-info {
    padding: 15px;
    position: relative;
}
.movie-info form {
    margin-top: 10px;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Movie App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('movies.index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-white">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.form') }}">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.form') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="search-container">
        <form action="{{ route('movies.search') }}" method="GET" class="input-group">
            <input type="text" name="title" class="form-control" placeholder="Search for a movie..." value="{{request()->title}}" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="movie-container">
        @if (isset($movies) && $movies)
            @foreach ($movies as $movie)
                <div class="movie-card">
                    <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/250x300' }}" alt="{{ $movie['Title'] }}">
                    <div class="movie-info">
                        <h5>{{ $movie['Title'] }} ({{ $movie['Year'] }})</h5>
                        <p>Type: {{ $movie['Type'] }}</p>
                        <p>IMDb: {{ $movie['imdbID'] }}</p>
                        @auth
                            <form id="favorite-form-{{ $movie['imdbID'] }}" class="favorite-form d-inline">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie['imdbID'] }}">
                                <input type="hidden" name="movie_title" value="{{ $movie['Title'] }}">
                                <input type="hidden" name="poster_url" value="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '' }}">
                                <button type="submit" class="btn btn-link p-0 favorite-btn" style="border: none; background: none;" data-movie-id="{{ $movie['imdbID'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-heart" viewBox="0 0 16 16">
                                        <path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                    </svg>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        @elseif (isset($error))
            <p class="error-message">{{ $error }}</p>
        @else
            <p class="text-center w-100">Search for movies to see results here!</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.favorite-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var movieId = form.find('.favorite-btn').data('movie-id');

            $.ajax({
                url: '{{ route("favorites.add") }}',
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        alert('Movie added to favorites!');
                        // Optionally change the heart icon to filled (e.g., bi-heart-fill)
                        form.find('.bi-heart').replaceWith(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-heart-fill" viewBox="0 0 16 16">' +
                            '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>' +
                            '</svg>'
                        );
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message || 'Something went wrong.');
                }
            });
        });
    });
</script>
</html>
