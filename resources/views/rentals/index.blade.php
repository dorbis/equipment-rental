@extends('layouts.site')

@section('title', 'Manas rezervācijas')

@section('content')
    <h1>Manas rezervācijas</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @forelse($rentals as $rental)
        <div class="card">
            <h2>{{ $rental->listing->title ?? 'Sludinājums nav pieejams' }}</h2>

            <p>
                <strong>Kategorija:</strong>
                {{ $rental->listing->category->name ?? 'Nav kategorijas' }}
            </p>

            <p>
                <strong>Sākuma datums:</strong>
                {{ $rental->start_date }}
            </p>

            <p>
                <strong>Beigu datums:</strong>
                {{ $rental->end_date }}
            </p>

            <p>
                <strong>Kopējā cena:</strong>
                {{ number_format($rental->total_price, 2) }} EUR
            </p>

            @if($rental->note)
                <p>
                    <strong>Piezīme:</strong>
                    {{ $rental->note }}
                </p>
            @endif

            @if($rental->end_date >= now()->toDateString())
                <p>
                    <strong>Statuss:</strong> Aktīva rezervācija
                </p>
            @else
                <p>
                    <strong>Statuss:</strong> Beigusies rezervācija
                </p>
            @endif

            @if($rental->listing)
                <a href="{{ route('listings.show', $rental->listing) }}" class="btn">
                    Skatīt sludinājumu
                </a>
            @endif
        </div>
    @empty
        <p>Tev vēl nav rezervāciju.</p>
    @endforelse
@endsection