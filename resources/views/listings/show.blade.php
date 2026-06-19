@extends('layouts.site')

@section('title', $listing->title)

@section('content')
    <h1>{{ $listing->title }}</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <div class="card">
        <p>{{ $listing->description }}</p>

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
    </div>

    <div class="actions">
        <a href="{{ route('listings.index') }}" class="btn btn-secondary">Atpakaļ</a>

        @auth
            @if(auth()->id() === $listing->user_id || auth()->user()->role === 'admin')
                <a href="{{ route('listings.edit', $listing) }}" class="btn">Rediģēt</a>

                <form method="POST" action="{{ route('listings.destroy', $listing) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-danger" onclick="return confirm('Tiešām dzēst šo sludinājumu?')">
                        Dzēst
                    </button>
                </form>
            @endif
        @endauth
    </div>
@auth
    @if(auth()->id() !== $listing->user_id)
        <hr>

        <h2>Rezervēt šo sludinājumu</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('rentals.store') }}">
            @csrf

            <input type="hidden" name="listing_id" value="{{ $listing->id }}">

            <label>Sākuma datums</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" required>

            <label>Beigu datums</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}" required>

            <label>Piezīme</label>
            <textarea name="note" rows="4" placeholder="Papildu informācija, ja nepieciešams">{{ old('note') }}</textarea>

            <button type="submit">Rezervēt</button>
        </form>
    @else
        <p><em>Jūs nevarat rezervēt savu sludinājumu.</em></p>
    @endif
@endauth

@guest
    <p>
        Lai rezervētu sludinājumu, nepieciešams
        <a href="{{ route('login') }}">pieslēgties</a>.
    </p>
@endguest
@endsection