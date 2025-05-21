@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.faqs') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.faqs_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.welcome') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.faqs.index') }}">
                                        {{ __('dashboard.faqs') }}</a>
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
                                    <button type="button" class="btn btn-outline-success mb-1 ml-1" data-toggle="modal"
                                        data-target="#faqCreateModal">
                                        {{ __('dashboard.create_faq') }}
                                    </button>

                                    {{-- modal --}}
                                    @include('dashboard.faqs._create')
                                    {{-- end create&edit coupon modal --}}

                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mb-1">
                                            <h5 class="mb-0">Collapsible with Border Color</h5>
                                            {{-- <small class="text-muted">Use class <code>.border-COLOR</code>to collapse toggle for Collapse
                                            heading border color.</small> --}}
                                        </div>
                                        <div class="card faq_row" id="headingCollapse51">

                                            @forelse ($faqs as $item)
                                               <div id="faq_div_{{ $item->id }}">
                                                <div role="tabpanel" class="card-header border-success">
                                                    <a id="question_{{ $item->id }}" data-toggle="collapse"
                                                        href="#collapse51_{{ $item->id }}" aria-expanded="true"
                                                        aria-controls="collapse51_{{ $item->id }}"
                                                        class="font-medium-1 success">{{ $item->question }}</a>
                                                    <a faq-id="{{ $item->id }}" class="delete_confirm_btn" href=""><i class="la la-trash float-right"></i></a>
                                                    <a data-target="#faqEditModal_{{ $item->id }}" data-toggle="modal" href=""><i class="la la-edit float-right"></i></a>
                                                </div>
                                                <div id="collapse51_{{ $item->id }}" role="tabpanel"
                                                    aria-labelledby="headingCollapse51"
                                                    class="card-collapse collapse @if ($loop->index == 0) show @endif"
                                                    aria-expanded="true">
                                                    <div id="answer_{{ $item->id }}" class="card-body">
                                                        {{ $item->answer }}
                                                    </div>
                                                </div>
                                               </div>

                                                @include('dashboard.faqs._edit')
                                            @empty
                                                <div class="alert alert-info">{{ __('dashboard.no_data') }}</div>
                                            @endforelse

                                        </div>
                                    </div>

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
    <script>
       // create Faq Using Ajax
        $(document).on('submit', '#createFaq', function(e) {
            e.preventDefault();
            var data = new FormData($(this)[0]);
            var local = "{{ app()->getLocale() }}"; // ar , en

            $.ajax({
                url: "{{ route('dashboard.faqs.store') }}",
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'error') {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        var question = local == 'ar' ? data.faq.question.ar : data.faq.question.en;
                        var answer = local == 'ar' ? data.faq.answer.ar : data.faq.answer.en;
                        $('#createFaq')[0].reset();
                        $('#faqModal').modal('hide');
                        $('.faq_row').prepend(`<div role="tabpanel" class="card-header border-success">
                                                    <a data-toggle="collapse" href="#collapse51_"
                                                        aria-expanded="true" aria-controls="collapse51_"
                                                        class="font-medium-1 success">${question} </a>
                                                    <a href=""><i class="la la-trash float-right"></i></a>
                                                    <a href=""><i class="la la-edit float-right"></i></a>
                                                </div>
                                                <div id="collapse51_{{ $item->id }}" role="tabpanel"
                                                    aria-labelledby="headingCollapse51"
                                                    class="card-collapse collapse show "
                                                    aria-expanded="true">
                                                    <div class="card-body">
                                                        ${answer}
                                                    </div>
                                                </div>`);
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // close modal
                        $('#faqCreateModal').modal('hide');
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

            })
        });

          // update faq using ajax
        $(document).on('submit' , '.update_faq_form' , function(e){
            e.preventDefault();
            var local = "{{ app()->getLocale() }}"; // ar , en

            var faq_id = $(this).attr('faq-id');
            var data = new FormData($(this)[0]);
            var url = "{{ route('dashboard.faqs.update' , ':id') }}";
            url = url.replace(':id' , faq_id);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,

                success: function(data) {
                    if(data.success == 'error'){
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        var question = local == 'ar' ? data.faq.question.ar : data.faq.question.en;
                        var answer = local == 'ar' ? data.faq.answer.ar : data.faq.answer.en;

                        $('#faqEditModal_'+faq_id).modal('hide');
                        $('#question_'+faq_id).empty().text(question);
                        $('#answer_'+faq_id).empty().text(answer);

                        // delete success class and add danger class

                        $('#question_'+faq_id).removeClass('success').addClass('danger');

                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }

                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        $('#error_list_'+faq_id).empty();
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#error_list_'+faq_id).append('<li>' + value[0] + '</li>');
                            $('#error_div_'+faq_id).show();
                        });
                    }
                }

            })

        });

        // delete faq using ajax
        $(document).on('click', '.delete_confirm_btn', function(e) {
            e.preventDefault();
            var faq_id = $(this).attr('faq-id');

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
                        url: "{{ route('dashboard.faqs.destroy', 'id') }}".replace('id',faq_id),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#faq_div_'+faq_id).remove();
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
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