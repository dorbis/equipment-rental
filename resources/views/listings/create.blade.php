@extends('layouts.site')

@section('title', 'Jauns sludinājums')

@section('content')
    <h1>Publicēt jaunu sludinājumu</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('listings.store') }}">
        @csrf

        <label>Nosaukums</label>
        <input type="text" name="title" value="{{ old('title') }}" required>

        <label>Apraksts</label>
        <textarea name="description" rows="5" required>{{ old('description') }}</textarea>

        <label>Tips</label>
        <select name="type" required>
            <option value="equipment" @selected(old('type') == 'equipment')>Aprīkojums</option>
            <option value="work" @selected(old('type') == 'work')>Darbs / pakalpojums</option>
        </select>

        <label>Kategorija</label>
        <select name="category_id" required>
            <option value="">Izvēlies kategoriju</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Cena dienā EUR</label>
        <input type="number" step="0.01" min="0" name="price_per_day" value="{{ old('price_per_day') }}" required>

        <button type="submit">Saglabāt</button>
        <a href="{{ route('listings.index') }}" class="btn btn-secondary">Atpakaļ</a>
    </form>
@endsection