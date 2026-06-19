@extends('layouts.site')

@section('title', 'Sludinājumi')

@section('content')
    <h1>Sludinājumu saraksts</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form method="GET" action="{{ route('listings.search') }}">
        <label>Meklēt pēc frāzes</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Piemēram: traktors, zāģis, remonts">

        <label>Kategorija</label>
        <select name="category_id">
            <option value="">Visas kategorijas</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Tips</label>
        <select name="type">
            <option value="">Visi tipi</option>
            <option value="equipment" @selected(request('type') == 'equipment')>Aprīkojums</option>
            <option value="work" @selected(request('type') == 'work')>Darbs / pakalpojums</option>
        </select>

        <button type="submit">Meklēt</button>
        <a href="{{ route('listings.index') }}" class="btn btn-secondary">Notīrīt</a>
    </form>

    <hr>

    @auth
        <p>
            <a href="{{ route('listings.create') }}" class="btn">Publicēt jaunu sludinājumu</a>
        </p>
    @endauth

    @forelse($listings as $listing)
        <div class="card">
            <h2>{{ $listing->title }}</h2>

            <p>{{ Str::limit($listing->description, 150) }}</p>

            <p>
                <strong>Kategorija:</strong>
                {{ $listing->category->name ?? 'Nav kategorijas' }}
            </p>

            <p>
                <strong>Tips:</strong>
                @if($listing->type === 'equipment')
                    Aprīkojums
                @else
                    Darbs / pakalpojums
                @endif
            </p>

            <p>
                <strong>Cena dienā:</strong>
                {{ number_format($listing->price_per_day, 2) }} EUR
            </p>

            <p>
                <strong>Autors:</strong>
                {{ $listing->user->name ?? 'Nezināms' }}
            </p>

            <a href="{{ route('listings.show', $listing) }}" class="btn">Skatīt</a>
        </div>
    @empty
        <p>Sludinājumu vēl nav.</p>
    @endforelse

    {{ $listings->withQueryString()->links() }}
@endsection