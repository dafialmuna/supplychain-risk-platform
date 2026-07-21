@extends('layouts.app')

@section('title', 'Manajemen Kargo - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">
        <i class="fas fa-shipping-fast me-2 text-warning"></i>Manajemen Kargo
    </h2>
    <a href="{{ route('admin.shipments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Buat Resi Baru
    </a>
</div>

@if(session('success'))
<div class="alert alert-success bg-success bg-opacity-10 text-success border-success mb-4">
    {{ session('success') }}
</div>
@endif

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>No. Resi</th>
                    <th>Pemilik (User)</th>
                    <th>Asal & Tujuan</th>
                    <th>Status</th>
                    <th>Tgl Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shipments as $shipment)
                <tr>
                    <td><span class="badge bg-secondary">{{ $shipment->tracking_number }}</span></td>
                    <td>{{ $shipment->user ? $shipment->user->name : 'Publik (Guest)' }}</td>
                    <td>{{ $shipment->origin_country }} <i class="fas fa-arrow-right text-muted mx-1"></i> {{ $shipment->destination_country }}</td>
                    <td>
                        <span class="badge bg-{{ $shipment->status == 'Delivered' ? 'success' : ($shipment->status == 'Delayed' ? 'danger' : 'warning text-dark') }}">
                            {{ $shipment->status }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $shipment->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="btn btn-sm btn-info text-white me-1">
                            <i class="fas fa-eye"></i> Log
                        </a>
                        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.shipments.destroy', $shipment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kargo ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data kargo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection