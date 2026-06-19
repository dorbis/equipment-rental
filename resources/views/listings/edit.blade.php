@extends('layouts.site')

@section('title', 'Rediģēt sludinājumu')

@section('content')
    <h1>Rediģēt sludinājumu</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('listings.update', $listing) }}">
        @csrf
        @method('PUT')

        <label>Nosaukums</label>
        <input type="text" name="title" value="{{ old('title', $listing->title) }}" required>

        <label>Apraksts</label>
        <textarea name="description" rows="5" required>{{ old('description', $listing->description) }}</textarea>

        <label>Tips</label>
        <select name="type" required>
            <option value="equipment" @selected(old('type', $listing->type) == 'equipment')>
                Aprīkojums
            </option>

            <option value="work" @selected(old('type', $listing->type) == 'work')>
                Darbs / pakalpojums
            </option>
        </select>

        <label>Kategorija</label>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $listing->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Cena dienā EUR</label>
        <input type="number" step="0.01" min="0" name="price_per_day" value="{{ old('price_per_day', $listing->price_per_day) }}" required>

        <button type="submit">Atjaunināt</button>
        <a href="{{ route('listings.show', $listing) }}" class="btn btn-secondary">Atpakaļ</a>
    </form>
@endsection