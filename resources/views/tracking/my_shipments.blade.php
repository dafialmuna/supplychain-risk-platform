@extends('layouts.app')

@section('title', 'Kargo Saya - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">
        <i class="fas fa-boxes me-2" style="color: var(--accent-amber);"></i>Kargo Saya
    </h2>
    <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-search me-1"></i> Lacak Resi Publik
    </a>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>No. Resi</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Update Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shipments as $shipment)
                <tr>
                    <td><span class="badge bg-secondary">{{ $shipment->tracking_number }}</span></td>
                    <td>{{ $shipment->origin_country }}</td>
                    <td>{{ $shipment->destination_country }}</td>
                    <td>
                        <span class="badge bg-{{ $shipment->status == 'Delivered' ? 'success' : ($shipment->status == 'Delayed' ? 'danger' : 'warning text-dark') }}">
                            {{ $shipment->status }}
                        </span>
                    </td>
                    <td class="text-muted small">
                        {{ $shipment->updated_at->diffForHumans() }}
                    </td>
                    <td>
                        <form action="{{ route('tracking.search') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tracking_number" value="{{ $shipment->tracking_number }}">
                            <button type="submit" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-map-marked-alt me-1"></i> Lihat Peta
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                        <p>Belum ada kargo yang ditugaskan ke akun Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection