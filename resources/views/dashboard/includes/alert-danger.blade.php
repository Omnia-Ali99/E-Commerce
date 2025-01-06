@if($errors->has('error'))
<div class="row mt-1">
    <button type="button" class="btn btn-lg btn-block btn-outline-danger mb-2" id="type-danger">{{ $errors->first('error') }}</button>
</div>
@endif