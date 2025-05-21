<!-- Modal -->
<div class="modal fade" id="faqEditModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.create_faq') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- validations error --}}
                <div class="alert alert-danger" id="error_div_{{ $item->id }}" style="display: none;">
                    <ul id="error_list_{{ $item->id }}"></ul>
                </div>

                <form faq-id="{{ $item->id }}" action="" class="form update_faq_form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">{{ __('dashboard.question_ar') }}</label>
                        <input type="text" name="question[ar]" value="{{ $item->getTranslation('question', 'ar') }}"
                            class="form-control" id="code" placeholder="{{ __('dashboard.question_ar') }}">
                        <strong class="text-danger" id="error_code"></strong>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('dashboard.question_en') }}</label>
                        <input type="text" name="question[en]" value="{{ $item->getTranslation('question', 'en') }}"
                            class="form-control" id="code" placeholder="{{ __('dashboard.question_en') }}">
                        <strong class="text-danger" id="error_code"></strong>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('dashboard.answer_ar') }}</label>
                        <textarea class="form-control" name="answer[ar]">
                         {{ $item->getTranslation('answer', 'ar') }}
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('dashboard.answer_en') }}</label>
                        <textarea class="form-control" name="answer[en]">
                            {{ $item->getTranslation('answer', 'en') }}
                        </textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="ft-x"></i>{{ __('dashboard.close') }}</button>
                        <button type="submit" class="btn btn-primary"> <i class="la la-check-square-o"></i>
                            {{ __('dashboard.save') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>