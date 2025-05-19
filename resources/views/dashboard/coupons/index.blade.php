@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.coupons') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.coupons_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.welcome') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.coupons.index') }}">
                                        {{ __('dashboard.coupons') }}</a>
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
                                    {{ __('dashboard.governorates') }}
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

                                    {{-- create coupon modal --}}
                                    <button type="button" class="btn btn-outline-success mb-1" data-toggle="modal"
                                        data-target="#couponModal">
                                        {{ __('dashboard.create_coupon') }}
                                    </button>

                                    {{-- modal --}}
                                    @include('dashboard.coupons._create')
                                    @include('dashboard.coupons._edit')
                                    {{-- end create&edit coupon modal --}}

                                    <p class="card-text">{{ __('dashboard.table_yajra_paragraph') }}.</p>
                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.code') }}</th>
                                                <th>{{ __('dashboard.discount') }}</th>
                                                <th>{{ __('dashboard.status') }}</th>
                                                <th>{{ __('dashboard.limitation') }}</th>
                                                <th>{{ __('dashboard.time_used') }}</th>
                                                <th>{{ __('dashboard.start_date') }}</th>
                                                <th>{{ __('dashboard.end_date') }}</th>
                                                <th>{{ __('dashboard.created_at') }}</th>
                                                <th>{{ __('dashboard.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <body>
                                            {{-- empty --}}
                                        </body>

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
                selector: "td:not(:first-child)",
            },
            // scroller: true,
            // scrollY: 900,
            select: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details for Coupon : ' + data['code'];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            ajax: "{{ route('dashboard.coupons.all') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'discount_precentage',
                    name: 'discount_precentage',
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                },
                {
                    data: 'time_used',
                    name: 'time_used',

                },
                {
                    data: 'time_used',
                    name: 'time_used',

                },
                {
                    data: 'start_date',
                    name: 'start_date',
                },
                {
                    data: 'end_date',
                    name: 'end_date'

                },

                {
                    data: 'created_at',
                    name: 'created_at',

                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false,
                },

            ],

            layout: {
                topStart: {
                    buttons: ['colvis', 'copy', 'print', 'excel', 'pdf']
                }
            },


            language: lang === 'ar' ? {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
            } : {},


        });

        // disable the row order when cliking
        $('table').on('mousedown', 'button', function(e) {
            table.rowReorder.disable();
        });
        $('table').on('mouseup', 'button', function(e) {
            table.rowReorder.enable();
        });

        // Create Coupon Using Ajax
        $('#createCoupon').on('submit', function(e) {
            e.preventDefault();
            var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
            $.ajax({
                url: "{{ route('dashboard.coupons.store') }}",
                method: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        $('#createCoupon')[0].reset();
                        $('#yajra_table').DataTable().page(currentPage).draw(false);
                        $('#couponModal').modal('hide');
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function(key, value) {

                            $('#error_list').append('<li>' + value[0] + '</li>');
                            $('#error_div').show();
                        });
                    }
                }
            });
        })

        // Edit Coupon
        $(document).on('click', '.edit_coupon', function(e) {
            e.preventDefault();


            $('#coupon_id').val($(this).attr('coupon-id'));
            $('#coupon_code').val($(this).attr('coupon-code'));
            $('#coupon_limit').val($(this).attr('coupon-limit'));
            $('#coupon_discount').val($(this).attr('coupon-discount'));
            $('#coupon_start_date').val($(this).attr('coupon-start-date'));
            $('#coupon_end_date').val($(this).attr('coupon-end-date'));
            var status = $(this).attr('coupon-status');
            if (status == 1) {
                $('#active_coupon').prop('checked', true);
            } else {
                $('#inactive_coupon').prop('checked', true);
            }
            $('#editCouponModal').modal('show');

        });

        // Update Coupon Using Ajax
        $('#updateCoupon').on('submit', function(e) {
            e.preventDefault();
            var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
            var coupon_id = $('#coupon_id').val();
            $.ajax({
                url: "{{ route('dashboard.coupons.update', 'id') }}".replace('id', coupon_id),
                method: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        $('#yajra_table').DataTable().page(currentPage).draw(false);
                        $('#editCouponModal').modal('hide');
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function(key, value) {

                            $('#error_list_edit').append('<li>' + value[0] + '</li>');
                            $('#error_div_edit').show();
                        });
                    }
                }
            });
        })

        // delete Coupon
        $(document).on('click', '.delete_confirm_btn', function(e) {
            e.preventDefault();
            var coupon_id = $(this).attr('coupon-id');

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
                        url: "{{ route('dashboard.coupons.destroy', 'id') }}".replace('id',
                            coupon_id),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                                $('#yajra_table').DataTable().ajax.reload();
                            } else {
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