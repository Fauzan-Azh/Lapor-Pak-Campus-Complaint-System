@extends('layouts.app')

@section('title', 'Daftar Tiket - Lapor Pak!')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-list-ul"></i> Daftar Tiket</h2>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Tiket Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

@if($tickets->count() > 0)
    <div class="row">
        @foreach($tickets as $ticket)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    @if($ticket->image_path)
                        <img src="{{ asset('storage/' . $ticket->image_path) }}" class="card-img-top" 
                             alt="{{ $ticket->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <span class="badge bg-{{ $ticket->status_color }}">
                                {{ $ticket->status_text }}
                            </span>
                        </div>
                        <p class="text-muted mb-2">
                            <i class="bi bi-tag"></i> {{ $ticket->category->name }}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt"></i> {{ $ticket->location }}
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($ticket->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> {{ $ticket->user->name }}
                                <br>
                                <i class="bi bi-clock"></i> {{ $ticket->created_at->format('d M Y, H:i') }}
                            </small>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                        @if($ticket->comments->count() > 0)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-chat-dots"></i> {{ $ticket->comments->count() }} komentar
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle"></i> Tidak ada tiket ditemukan.
        <a href="{{ route('tickets.create') }}" class="alert-link">Buat tiket baru</a>
    </div>
@endif
@endsection
