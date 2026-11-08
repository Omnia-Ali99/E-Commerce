@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.order_items') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.order_items_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.welcome') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">
                                        {{ __('dashboard.orders') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript:void(0)">
                                        {{ __('dashboard.order_items') }}</a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="header-styling">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('dashboard.order_items') }} </h4><br>
                            {{-- tow btn delete && change to deliverd --}}
                            <div class="mb-2">
                                <!-- Change Status to Delivered -->
                                @if ($orderWithItems->status !== 'delivered')
                                    <a href="{{ route('dashboard.orders.markDelivered', $orderWithItems->id) }}"
                                        class="btn btn-success"
                                        onclick="return confirm('{{ __('dashboard.confirm_mark_delivered') }}')">
                                        {{ __('dashboard.mark_as_delivered') }}
                                    </a>
                                @endif

                                <!-- Delete Order Form -->
                                <form action="{{ route('dashboard.orders.destroy', $orderWithItems->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('{{ __('dashboard.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('dashboard.delete_order') }}
                                    </button>
                                </form>
                            </div>

                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <p class="card-text">Example of a custom table
                                    <em>header</em> styling. Table header supports default contextual
                                    and custom background colors available in <a href="colors-primary-palette.html"
                                        target="_blank">bootstrap brand colors</a>. To use bootstrap
                                    brand color in the table header, add <code>.bg-*</code> class
                                    to the header row. All border and text colors will be automatically
                                    adjusted.
                                </p>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">{{ __('dashboard.order_details') }}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>{{ __('dashboard.user_name') }}:</strong>
                                            {{ $orderWithItems->user_name }}</p>
                                        <p><strong>{{ __('dashboard.user_phone') }}:</strong>
                                            {{ $orderWithItems->user_phone }}</p>
                                        <p><strong>{{ __('dashboard.user_email') }}:</strong>
                                            {{ $orderWithItems->user_email }}</p>
                                        <p><strong>{{ __('dashboard.note') }}:</strong> {{ $orderWithItems->note }}</p>
                                        <p><strong>{{ __('dashboard.status') }}:</strong>
                                            <span
                                                class="badge
                                                @if ($orderWithItems->status == 'pending') badge-warning
                                                @elseif($orderWithItems->status == 'paid') badge-primary
                                                @elseif($orderWithItems->status == 'delivered') badge-success
                                                @elseif($orderWithItems->status == 'cancelled') badge-danger @endif">
                                                {{ ucfirst($orderWithItems->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>{{ __('dashboard.country') }}:</strong> {{ $orderWithItems->country }}
                                        </p>
                                        <p><strong>{{ __('dashboard.governorate') }}:</strong>
                                            {{ $orderWithItems->governorate }}</p>
                                        <p><strong>{{ __('dashboard.city') }}:</strong> {{ $orderWithItems->city }}</p>
                                        <p><strong>{{ __('dashboard.street') }}:</strong> {{ $orderWithItems->street }}
                                        </p>
                                        <p><strong>{{ __('dashboard.coupon') }}:</strong> {{ $orderWithItems->coupon ?? __('dashboard.none') }}</p>
                                        <p><strong>{{ __('dashboard.coupon_discount') }}:</strong> {{ $orderWithItems->coupon_discount ?? __('dashboard.no_coupon_discount') }}%</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-dollar-sign"></i>
                                                    {{ __('dashboard.price') }}:</strong>
                                                {{ $orderWithItems->price }} EGP
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-shipping-fast"></i>
                                                    {{ __('dashboard.shipping_price') }}:</strong>
                                                {{ $orderWithItems->shapping_price }} EGP
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-calculator"></i>
                                                    {{ __('dashboard.total_price') }}:</strong>
                                                {{ $orderWithItems->total_price }} EGP
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- order items --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-success white">
                                        <tr>
                                            <th>{{ __('dashboard.product_name') }}</th>
                                            <th>{{ __('dashboard.product_quantity') }}</th>
                                            <th>{{ __('dashboard.product_price') }}</th>
                                            <th>{{ __('dashboard.product_price_for_quantity') }}</th>
                                            <th>{{ __('dashboard.attributes') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderWithItems->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->product_quantity }}</td>
                                                <td>{{ $item->product_price }}</td>
                                                <td>{{ $item->product_price * $item->product_quantity }}</td>
                                                <td>
                                                    @if ($item->attributes != null)
                                                        @foreach ($item->attributes as $attr => $value)
                                                            <h5 style="margin-right: 4px" class="heading">
                                                                {{ $attr . ' : ' . $value }} </h5>
                                                        @endforeach
                                                    @else
                                                        <h5 class="heading">No Attributes</h5>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .glass-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .glass-box:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush