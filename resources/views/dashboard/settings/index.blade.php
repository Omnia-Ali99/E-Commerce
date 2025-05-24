@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.settings') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.settings') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.welcome') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.settings.index') }}">
                                        {{ __('dashboard.settings') }}</a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="row-separator-colored-controls">{{ __('dashboard.settings') }}</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
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
                            <div class="card-body">
                                <div class="card-text">

                                </div>
                                <form action="{{ route('dashboard.settings.update', $setting->id) }}" method="POST"
                                    enctype="multipart/form-data" class="form form-horizontal row-separator setting_form">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-body">

                                        {{-- basic info --}}
                                        <h4 class="form-section"><i
                                                class="la la-eye"></i>{{ __('dashboard.basic_settings') }}</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.site_name_ar') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" id="userinput1"
                                                            class="form-control border-primary "
                                                            placeholder="{{ __('dashboard.site_name_ar') }}"
                                                            name="site_name[ar]"
                                                            value="{{ $setting->getTranslation('site_name', 'ar') }}">

                                                        @error('site_name.ar')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.site_name_en') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" id="userinput1"
                                                            class="form-control border-primary "
                                                            placeholder="{{ __('dashboard.site_name_en') }}"
                                                            name="site_name[en]"
                                                            value="{{ $setting->getTranslation('site_name', 'en') }}">
                                                        @error('site_name.en')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.site_desc_ar') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="6" readonly name="site_desc[ar]" class="form-control border-primary ">{{ $setting->getTranslation('site_desc', 'ar') }}</textarea>
                                                        @error('site_desc.ar')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.site_desc_en') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="6" readonly name="site_desc[en]" class="form-control border-primary ">{{ $setting->getTranslation('site_desc', 'en') }}</textarea>
                                                        @error('site_desc.en')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.meta_description_ar') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="6" readonly name="meta_description[ar]" class="form-control border-primary ">{{ $setting->getTranslation('meta_description', 'ar') }}</textarea>
                                                        @error('meta_description.ar')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('dashboard.meta_description_en') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="6" readonly name="meta_description[en]" class="form-control border-primary ">{{ $setting->getTranslation('meta_description', 'en') }} </textarea>
                                                        @error('meta_description.en')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput3">{{ __('dashboard.site_address_ar') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" id="userinput3"
                                                            class="form-control border-primary "
                                                            placeholder="{{ __('dashboard.site_address_ar') }}"
                                                            name="site_address[ar]"
                                                            value="{{ $setting->getTranslation('site_address', 'ar') }}">
                                                        @error('site_address.ar')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput3">{{ __('dashboard.site_address_en') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" id="userinput3"
                                                            class="form-control border-primary "
                                                            placeholder="{{ __('dashboard.site_address_en') }}"
                                                            name="site_address[en]"
                                                            value="{{ $setting->getTranslation('site_address', 'en') }}">
                                                        @error('site_address.en')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput3">{{ __('dashboard.site_copyright') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" id="userinput3"
                                                            class="form-control border-primary "
                                                            placeholder="{{ __('dashboard.site_copyright') }}"
                                                            name="site_copyright" value="{{ $setting->site_copyright }}">
                                                        @error('site_copyright')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end basic info --}}

                                        {{-- contact info --}}
                                        <h4 class="form-section"><i
                                                class="la la-envelope"></i>{{ __('dashboard.contact_info') }}</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.email') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="site_email"
                                                            class="form-control border-primary " type="email"
                                                            placeholder="{{ __('dashboard.email') }}" id="userinput5"
                                                            value="{{ $setting->site_email }}">
                                                        @error('site_email')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.email_support') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="email_support"
                                                            class="form-control border-primary " type="email"
                                                            placeholder="{{ __('dashboard.email_support') }}"
                                                            id="userinput5" value="{{ $setting->email_support }}">
                                                        @error('email_support')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.phone') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="site_phone"
                                                            class="form-control border-primary " type="number"
                                                            placeholder="{{ __('dashboard.phone') }}" id="userinput5"
                                                            value="{{ $setting->site_phone }}">
                                                        @error('phone')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end contact info --}}

                                        {{-- socail --}}
                                        <h4 class="form-section"><i
                                                class="la la-envelope"></i>{{ __('dashboard.social') }}</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.facebook') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="facebook_url"
                                                            class="form-control border-primary " type="url"
                                                            placeholder="{{ __('dashboard.facebook') }}" id="userinput5"
                                                            value="{{ $setting->facebook_url }}">
                                                        @error('facebook_url')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.youtube') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="youtube_url"
                                                            class="form-control border-primary " type="url"
                                                            placeholder="{{ __('dashboard.youtube') }}" id="userinput5"
                                                            value="{{ $setting->youtube_url }}">
                                                        @error('youtube_url')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.twitter') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="twitter_url"
                                                            class="form-control border-primary " type="url"
                                                            placeholder="{{ __('dashboard.twitter') }}" id="userinput5"
                                                            value="{{ $setting->twitter_url }}">
                                                        @error('twitter_url')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end social --}}

                                        {{-- Media --}}
                                        <h4 class="form-section"><i
                                                class="la la-envelope"></i>{{ __('dashboard.media') }}</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.logo') }}</label>
                                                    <div class="col-md-9">
                                                        <input name="logo" id="logo-image"
                                                            class="form-control border-primary " type="file"
                                                            placeholder="{{ __('dashboard.logo') }}">
                                                        @error('logo')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.favicon') }}</label>
                                                    <div class="col-md-9">
                                                        <input name="favicon" id="favicon-image"
                                                            class="form-control border-primary " type="file"
                                                            placeholder="{{ __('dashboard.favicon') }}">
                                                        @error('favicon')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput5">{{ __('dashboard.promotion_video_url') }}</label>
                                                    <div class="col-md-9">
                                                        <input readonly name="promotion_video_url"
                                                            class="form-control border-primary " type="text"
                                                            placeholder="{{ __('dashboard.promotion_video_url') }}"
                                                            id="userinput5" value="{{ $setting->promotion_video_url }}">
                                                        @error('promotion_video_url')
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end media --}}
                                    </div>
                                    {{-- buttons --}}
                                    <div class="form-actions right">
                                        <button hidden id="cancel_btn" type="button" class="btn btn-warning mr-1">
                                            <i class="la la-remove"></i> {{ __('dashboard.cancel') }}
                                        </button>
                                        <button hidden id="submit_btn" type="submit" class="btn btn-primary">
                                            <i class="la la-check"></i> {{ __('dashboard.save') }}
                                        </button>
                                        <button id="edit_btn" type="button" class="btn btn-info">
                                            <i class="la la-edit"></i> {{ __('dashboard.edit') }}
                                        </button>
                                    </div>
                                    {{-- end button --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- File Input (Logo & Favicon) --}}
    <script>
        var lang = "{{ app()->getLocale() }}";
        $(function() {
            $('#logo-image').fileinput({
                theme: 'fa5',
                language: lang,
                allowedFileTypes: ['image'],
                maxFileCount: 1,
                enableResumableUpload: false,
                showUpload: false,
                initialPreviewAsData: true,
                initialPreview: [
                    "{{ asset($setting->logo) }}",
                ],

            });
            $('#favicon-image').fileinput({
                theme: 'fa5',
                language: lang,
                allowedFileTypes: ['image'],
                maxFileCount: 1,
                enableResumableUpload: false,
                showUpload: false,
                initialPreviewAsData: true,
                initialPreview: [
                    "{{ asset($setting->favicon) }}",
                ],

            });

        });
    </script>

    <script>
        let originalValues = {};
        $(document).on('click', '#edit_btn', function() {
            $('#edit_btn').attr('hidden', true);
            $('#submit_btn').removeAttr('hidden');
            $('#cancel_btn').removeAttr('hidden');

            $('.setting_form input').each(function() {
                originalValues[$(this).attr('name')] = $(this).val(); // Save original values
                $(this).removeAttr('readonly');
            });
            $('.setting_form textarea').each(function() {
                originalValues[$(this).attr('name')] = $(this).val(); // Save original values
                $(this).removeAttr('readonly');
            });

            $('.setting_form input').removeAttr('readonly');
            $('.setting_form textarea').removeAttr('readonly');
        });

        // when click on cancel button
        $(document).on('click', '#cancel_btn', function() {
            // remove additional text add to inputs and textarea
            // task
            $('.setting_form input').each(function() {
                const name = $(this).attr('name');
                if (originalValues[name] !== undefined) {
                    $(this).val(originalValues[name]);
                }
            });
            $('.setting_form textarea').each(function() {
                const name = $(this).attr('name');
                if (originalValues[name] !== undefined) {
                    $(this).val(originalValues[name]);
                }
            });

            $('#edit_btn').removeAttr('hidden');
            $('#submit_btn').attr('hidden', true);
            $('#cancel_btn').attr('hidden', true);
            $('.setting_form input').attr('readonly', true);
            $('.setting_form textarea').attr('readonly', true);
        });
    </script>
@endpush