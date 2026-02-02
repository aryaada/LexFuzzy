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
                    Urut berdasarkan prioritas pengiriman (Fuzzy Sugeno)
                </small>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Kode Order</th>
                            <th>Toko</th>
                            <th>Kota</th>
                            <th class="text-center">Status Order</th>
                            <th class="text-center">Keputusan</th>
                            <th class="text-center">Fuzzy Score</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                // STATUS ORDER
                                $statusColor = match ($order->status) {
                                    'draft' => 'secondary',
                                    'submitted' => 'warning',
                                    'processed' => 'info',
                                    'completed' => 'success',
                                    default => 'secondary',
                                };

                                // FUZZY DECISION
                                $decision = $order->shipment->delivery_decision ?? null;
                                $decisionColor = match ($decision) {
                                    'Cepat' => 'success',
                                    'Normal' => 'info',
                                    'Lambat' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp

                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $order->order_code }}
                                </td>
                                <td>{{ $order->store->store_name }}</td>
                                <td>{{ $order->store->city }}</td>

                                {{-- STATUS ORDER --}}
                                <td class="text-center">
                                    <span class="badge bg-{{ $statusColor }}-lt">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                {{-- KEPUTUSAN FUZZY --}}
                                <td class="text-center">
                                    @if ($decision)
                                        <span class="badge bg-{{ $decisionColor }}-lt">
                                            {{ $decision }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Belum Diproses
                                        </span>
                                    @endif
                                </td>

                                {{-- FUZZY SCORE --}}
                                <td class="text-center">
                                    {{ $order->shipment->fuzzy_score ?? '-' }}
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <a href="{{ route('supplier.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
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
