@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.orders') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.orders_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.welcome') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">
                                        {{ __('dashboard.orders') }}</a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    {{ __('dashboard.orders') }}
                                </h4>
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

                            <div class="card-content">
                                <div class="card-body">
                                    <p class="card-text">{{ __('dashboard.table_yajra_paragraph') }}.</p>
                                    <div class="form-group">
                                        <select id="status_filter" class="form-control"
                                            style="width:200px; display:inline-block; margin-bottom: 10px;">
                                            <option value="">{{ __('dashboard.all_statuses') }}</option>
                                            <option value="pending">{{ __('dashboard.pending') }}</option>
                                            <option value="paid">{{ __('dashboard.paid') }}</option>
                                            <option value="cancelled">{{ __('dashboard.cancelled') }}</option>
                                            <option value="delivered">{{ __('dashboard.delivered') }}</option>
                                        </select>
                                    </div>
                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.user_name') }}</th>
                                                <th>{{ __('dashboard.user_phone') }}</th>
                                                <th>{{ __('dashboard.user_email') }}</th>
                                                <th>{{ __('dashboard.status') }}</th>

                                                <th>{{ __('dashboard.governorate') }}</th>
                                                <th>{{ __('dashboard.city') }}</th>
                                                <th>{{ __('dashboard.street') }}</th>
                                                <th>{{ __('dashboard.sub_total') }}</th>
                                                <th>{{ __('dashboard.shapping_price') }}</th>
                                                <th>{{ __('dashboard.total_price') }}</th>
                                                <th>{{ __('dashboard.coupon') }}</th>
                                                <th>{{ __('dashboard.coupon_discount') }}</th>
                                                <th>{{ __('dashboard.note') }}</th>
                                                <th>{{ __('dashboard.actions') }}</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- empty --}}
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{--  Data tables  --}}
    <script>
        var lang = "{{ app()->getLocale() }}";

        // display data
        var table = $('#yajra_table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,

            colReorder: true,
            rowReorder: {
                update: false,
                selector: "td:not(:first-child):not(:nth-child(4))",
            },
            // scroller: true,
            // scrollY: 900,
            select: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details for Order : ' + data['user_name'];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            ajax: {
                url: "{{ route('dashboard.orders.all') }}",
                data: function(d) {
                    d.status = $('#status_filter').val(); // Add this line to pass the selected status
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'user_name',
                    name: 'user_name',
                },
                {
                    data: 'user_phone',
                    name: 'user_phone',
                },
                {
                    data: 'user_email',
                    name: 'user_email',
                },
                {
                    data: 'status',
                    name: 'status'

                },
                {
                    data: 'governorate',
                    name: 'governorate',
                },
                {
                    data: 'city',
                    name: 'city',
                },
                {
                    data: 'street',
                    name: 'street',

                },
                {
                    data: 'price',
                    name: 'price',

                },
                {
                    data: 'shapping_price',
                    name: 'shapping_price',
                },
                {
                    data: 'total_price',
                    name: 'total_price'

                },


                {
                    data: 'coupon',
                    name: 'coupon',

                },
                {
                    data: 'coupon_discount',
                    name: 'coupon_discount',

                },
                {
                    data: 'note',
                    name: 'note',

                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false,
                },

            ],

            layout: {
                topStart: {
                    buttons: ['colvis', 'copy', 'print', 'pdf']
                }
            },

            language: lang === 'ar' ? {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
            } : {},


        });

        $('#status_filter').on('change', function() {
            $('#yajra_table').DataTable().ajax.reload();
        });


        // disable the row order when cliking
        $('table').on('mousedown', 'button', function(e) {
            table.rowReorder.disable();
        });
        $('table').on('mouseup', 'button', function(e) {
            table.rowReorder.enable();
        });

        // delete order using ajax
        $(document).on('click', '.delete_confirm_btn', function(e) {
            e.preventDefault();
            var order_id = $(this).attr('order-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboard.orders.destroy', ':id') }}".replace(':id',
                            order_id),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                                $('#yajra_table').DataTable().ajax.reload();
                            }
                            if (response.status == 'error') {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        }
                    });

                }
            });

        });
    </script>
@endpush