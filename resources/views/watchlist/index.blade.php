@extends('layouts.app')

@section('title', 'My Watchlist')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-star me-2 text-warning"></i>My Watchlist</h2>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($watchlists->count() == 0)
    <div class="card p-5 text-center">
        <i class="fas fa-star fa-3x text-muted mb-3"></i>
        <h5>No countries in your watchlist yet.</h5>
        <p class="text-muted">Go to Dashboard and click the star icon on any country to add it.</p>
    </div>
@else
    <div class="row g-3">
        @foreach($watchlists as $item)
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <div class="d-flex justify-content-between">
                        <h5>{{ $item->country->flag }} {{ $item->country->name }}</h5>
                        <form method="POST" action="{{ route('watchlist.destroy', $item->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                    <div class="text-muted small">
                        <div>Code: {{ $item->country->code }}</div>
                        <div>Region: {{ $item->country->region }}</div>
                        <div>Currency: {{ $item->country->currency }}</div>
                    </div>
                    <a href="{{ route('dashboard', ['country' => $item->country->code]) }}" class="btn btn-sm btn-primary mt-2">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection