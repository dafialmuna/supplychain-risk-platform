@extends('layouts.app')
@section('title', 'Kelola Pelabuhan - Admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ship me-2"></i>Dataset Pelabuhan</h2>
    <a href="{{ route('admin.ports.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Pelabuhan</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-3 shadow-sm border-0">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nama Pelabuhan</th>
                <th>Negara</th>
                <th>Kode Negara</th>
                <th>Koordinat</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ports as $port)
            <tr>
                <td>{{ $port->id }}</td>
                <td class="fw-bold">{{ $port->name }}</td>
                <td>{{ $port->country }}</td>
                <td><span class="badge bg-secondary">{{ $port->country_code }}</span></td>
                <td><small>{{ $port->lat }}, {{ $port->lng }}</small></td>
                <td class="text-end">
                    <a href="{{ route('admin.ports.edit', $port->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.ports.destroy', $port->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelabuhan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
