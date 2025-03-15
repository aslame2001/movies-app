<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Favorite Movies</title>
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
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .favorite-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }
        .favorite-card:hover {
            transform: scale(1.05);
        }
        .favorite-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .favorite-info {
            padding: 15px;
        }
        .favorite-info h5 {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }
        .favorite-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9rem;
        }
        .no-favorites {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            margin-top: 50px;
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <h2 class="text-center mb-4">Your Favorite Movies</h2>

        <div class="favorites-grid">
            @if ($favorites)
                @foreach ($favorites as $favorite)
                    <div class="favorite-card">
                        <img src="{{ $favorite->poster_url ?: 'https://via.placeholder.com/250x300' }}" alt="{{ $favorite->movie_title }}">
                        <div class="favorite-info">
                            <h5>{{ $favorite->movie_title }}</h5>
                            <p>IMDb: {{ $favorite->movie_id }}</p>
                            <p>Added: {{ $favorite->added_at instanceof \Carbon\Carbon ? $favorite->added_at->format('M d, Y') : $favorite->added_at }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="no-favorites">You haven’t added any favorite movies yet!</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
