@extends('layouts.site')

@section('title', 'Mani sludinājumi')

@section('content')
    <h1>Mani sludinājumi</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('listings.create') }}" class="btn">Publicēt jaunu sludinājumu</a>
    </p>

    @forelse($listings as $listing)
        <div class="card">
            <h2>{{ $listing->title }}</h2>

            <p>{{ Str::limit($listing->description, 150) }}</p>

            <p>
                <strong>Kategorija:</strong>
                {{ $listing->category->name ?? 'Nav kategorijas' }}
            </p>

            <p>
                <strong>Cena dienā:</strong>
                {{ number_format($listing->price_per_day, 2) }} EUR
            </p>

            <div class="actions">
                <a href="{{ route('listings.show', $listing) }}" class="btn">Skatīt</a>
                <a href="{{ route('listings.edit', $listing) }}" class="btn">Rediģēt</a>

                <form method="POST" action="{{ route('listings.destroy', $listing) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-danger" onclick="return confirm('Tiešām dzēst šo sludinājumu?')">
                        Dzēst
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p>Tev vēl nav sludinājumu.</p>
    @endforelse

    {{ $listings->links() }}
@endsection