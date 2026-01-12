@extends('layouts.app')

@section('title', $ticket->title . ' - Lapor Pak!')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $ticket->title }}</h4>
                <span class="badge bg-light text-dark fs-6">
                    {{ $ticket->status_text }}
                </span>
            </div>
            @if($ticket->image_path)
                <img src="{{ asset('storage/' . $ticket->image_path) }}" class="card-img-top" 
                     alt="{{ $ticket->title }}">
            @endif
            <div class="card-body">
                <div class="mb-3">
                    <h6><i class="bi bi-tag"></i> Kategori</h6>
                    <p class="mb-0">{{ $ticket->category->name }}</p>
                </div>
                <div class="mb-3">
                    <h6><i class="bi bi-geo-alt"></i> Lokasi</h6>
                    <p class="mb-0">{{ $ticket->location }}</p>
                </div>
                <div class="mb-3">
                    <h6><i class="bi bi-file-text"></i> Deskripsi</h6>
                    <p class="mb-0">{{ $ticket->description }}</p>
                </div>
                <hr>
                <div class="row text-muted">
                    <div class="col-md-6">
                        <small><i class="bi bi-person"></i> Dilaporkan oleh: {{ $ticket->user->name }}</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small><i class="bi bi-clock"></i> {{ $ticket->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        @auth
            @if(auth()->user()->is_admin)
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-gear"></i> Ubah Status (Admin Only)</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tickets.updateStatus', $ticket) }}">
                            @csrf
                            <div class="mb-3">
                                <select class="form-select" name="status" required>
                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Diskusi / Komentar</h5>
            </div>
            <div class="card-body">
                @if($ticket->comments->count() > 0)
                    <div class="mb-4">
                        @foreach($ticket->comments as $comment)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>
                                        {{ $comment->user->name }}
                                        @if($comment->user->is_admin)
                                            <span class="badge bg-warning text-dark">Admin</span>
                                        @endif
                                    </strong>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> {{ $comment->created_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                                <p class="mb-0">{{ $comment->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada komentar. Jadilah yang pertama!</p>
                @endif

                <form method="POST" action="{{ route('comments.store', $ticket) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Tambah Komentar</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="3" required 
                                  placeholder="Tulis komentar atau pertanyaan Anda...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Kirim Komentar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Tiket
    </a>
</div>
@endsection
