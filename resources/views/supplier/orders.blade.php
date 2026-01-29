@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-inbox me-1"></i>
                    Order Masuk
                </h4>
                <small class="text-muted">
                    Daftar order yang masuk dari toko
                </small>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-left">
                            <th>Kode Order</th>
                            <th>Toko</th>
                            <th>Kota</th>
                            <th class="text-center">Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $order->order_code }}
                                </td>
                                <td>{{ $order->store->store_name }}</td>
                                <td>{{ $order->store->city }}</td>
                                <td class="text-center">
                                    @php
                                        $statusColor = match (strtolower($order->status)) {
                                            'pending' => 'warning',
                                            'processed' => 'info',
                                            'shipped' => 'primary',
                                            'completed' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}-lt">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('supplier.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                    Belum ada order masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
