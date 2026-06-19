@extends('layouts.site')

@section('title', 'Admin panelis')

@section('content')
    <h1>Visu sludinājumu pārvaldība</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @forelse($listings as $listing)
        <div class="card">
            <h2>{{ $listing->title }}</h2>

            <p>{{ $listing->description }}</p>

            <p>
                <strong>Autors:</strong>
                {{ $listing->user->name ?? 'Nezināms' }}
            </p>

            <p>
                <strong>Kategorija:</strong>
                {{ $listing->category->name ?? 'Nav kategorijas' }}
            </p>

            <p>
                <strong>Cena dienā:</strong>
                {{ number_format($listing->price_per_day, 2) }} EUR
            </p>

            <a href="{{ route('listings.show', $listing) }}" class="btn">Skatīt</a>

            <form method="POST" action="{{ route('admin.listings.destroy', $listing) }}" style="display:inline;">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-danger" onclick="return confirm('Tiešām dzēst šo sludinājumu?')">
                    Dzēst
                </button>
            </form>
        </div>
    @empty
        <p>Sludinājumu nav.</p>
    @endforelse
@endsection