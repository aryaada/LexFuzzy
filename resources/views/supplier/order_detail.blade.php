@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    Detail Order
                    <span class="text-primary">{{ $order->order_code }}</span>
                </h4>
                <small class="text-muted">Informasi lengkap pesanan & pengiriman</small>
            </div>
        </div>

        {{-- INFO TOKO --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 fs-3 text-primary">
                            <i class="bi bi-shop"></i>
                        </div>
                        <div>
                            <small class="text-muted">Toko</small>
                            <h5 class="fw-semibold mb-0">
                                {{ $order->store->store_name }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 fs-3 text-success">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <small class="text-muted">Kota</small>
                            <h5 class="fw-semibold mb-0">
                                {{ $order->store->city }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LIST ITEM --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-list-check me-1"></i>
                Daftar Item Ban
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Ban</th>
                            <th width="120">Qty</th>
                            <th width="160">Berat (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td class="fw-medium">{{ $item->sparepart->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-dark-lt">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="text-center fw-semibold">
                                    {{ $item->total_weight }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                    Tidak ada item dalam order
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <div class="fs-3 text-primary mb-1">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <small class="text-muted">Total Berat</small>
                        <h4 class="fw-bold mb-0">
                            {{ $order->total_weight }} kg
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <div class="fs-3 text-success mb-1">
                            <i class="bi bi-signpost-2"></i>
                        </div>
                        <small class="text-muted">Jarak Pengiriman</small>
                        <h4 class="fw-bold mb-0">
                            {{ $order->shipment->distance_km }} km
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- FUZZY --}}
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">

                @if (!$order->shipment->fuzzy_score)
                    <form action="{{ route('supplier.shipments.process', $order->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg px-4">
                            <i class="bi bi-cpu me-1"></i>
                            Proses Pengiriman (Fuzzy Sugeno)
                        </button>
                    </form>
                @else
                    <div class="alert alert-info text-start mb-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle fs-4 me-3"></i>
                            <div>
                                <p class="mb-1">
                                    <strong>Fuzzy Score:</strong>
                                    {{ $order->shipment->fuzzy_score }}
                                </p>
                                <p class="mb-0">
                                    <strong>Keputusan:</strong>
                                    {{ $order->shipment->delivery_decision }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
