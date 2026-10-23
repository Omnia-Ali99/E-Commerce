<div>
    <!-- Modal -->
    <div class="modal fade contacts-reply-modal-shell" id="replayContactModal" tabindex="-1" role="dialog" aria-labelledby="replayContactModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content contacts-reply-modal">
                <div class="modal-header">
                    <div class="contacts-modal-brand">
                        <img src="{{ asset($setting->logo) }}" alt="Logo">
                    </div>
                    <div>
                        <h5 class="modal-title" id="replayContactModalLabel">
                            {{ __('dashboard.replay_contact') }}
                        </h5>
                        <p>{{ __('dashboard.reply_to_customer_email') }}</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="replayContact" class="form">
                        <input type="hidden" wire:model="id" id="contactId">

                        <div class="contacts-reply-grid">
                            <div class="form-group">
                                <label for="userEmail"><i class="fas fa-envelope"></i> {{ __('dashboard.email') }}</label>
                                <input readonly wire:model="email" id="userEmail" class="form-control" type="email">
                            </div>

                            <div class="form-group">
                                <label for="contactSubject"><i class="fas fa-tag"></i> {{ __('dashboard.subject') }}</label>
                                <input readonly wire:model="subject" id="contactSubject" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="replayMessage"><i class="fas fa-comment-dots"></i> {{ __('dashboard.replay_message') }}</label>
                            <textarea rows="4" wire:model="replayMessage" id="replayMessage" class="form-control"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> {{ __('dashboard.close') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> {{ __('dashboard.send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Livewire.on('luanch-replay-contact-modal', () => {
        $('#replayContactModal').modal('show');
    });
    Livewire.on('close-modal', () => {
        $('#replayContactModal').modal('hide');
    });
</script>
@endscript