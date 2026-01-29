@extends('layouts.app')

@section('content')
    <div class="container">
        @if (auth()->user()->isCustomer())
            <h2>Dashboard Toko</h2>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Total Order</h4>
                            <h3>{{ auth()->user()->store->orders()->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Order Diproses</h4>
                            <h3>
                                {{ auth()->user()->store->orders()->where('status', 'processed')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Order Selesai</h4>
                            <h3>
                                {{ auth()->user()->store->orders()->where('status', 'completed')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    Kelola Order
                </a>
            </div>
        @endif

        @if (auth()->user()->isSupplier())
            <h2>Dashboard Supplier</h2>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Total Order Masuk</h4>
                            <h3>{{ $totalOrder }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Order Menunggu</h4>
                            <h3>{{ $pendingOrder }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4>Order Diproses</h4>
                            <h3>{{ $processedOrder }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('supplier.orders') }}" class="btn btn-primary mt-4">
                Lihat Order Masuk
            </a>
        @endif
    </div>
@endsection
