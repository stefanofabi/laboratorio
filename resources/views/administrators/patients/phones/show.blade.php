<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text"> {{ trans('phones.phones') }} </span>
	</div>

	<select class="form-control input-sm col-md-6" style="margin-right: 1%" readonly>
		<option value=""> {{ trans('forms.select_option') }}</option>

		@foreach ($patient->phones as $phone)
		<option value="{{ $phone->id }}"> {{ $phone->phone }}</option>
		@endforeach
	</select>
</div>
