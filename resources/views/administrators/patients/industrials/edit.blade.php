@extends('administrators/default-template')

@section('js')
    <script type="text/javascript">

        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

        $(document).ready(function () {
            // Select a sex from list
            $('#tax_condition').val("{{ $patient->tax_condition }}");
        });
    </script>

    @include('administrators/patients/phones/js')
    @include('administrators/patients/emails/js')
    @include('administrators/patients/social_works/affiliates/js')

@endsection

@section('title')
    {{ trans('patients.edit_patient') }}
@endsection

@section('active_patients', 'active')

@section('menu-title')
    {{ trans('forms.menu') }}
@endsection

@section('menu')
    @include('administrators/patients/edit_menu')

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('administrators/patients/show', $patient->id) }}"> <img
                    src="{{ asset('images/drop.png') }}" width="25" height="25"> {{ trans('forms.go_back') }} </a>
        </li>
    </ul>
@endsection

@section('content-title')
    <i class="fas fa-user-edit"></i> {{ trans('patients.edit_patient') }}
@endsection

@section('content')

    @include('administrators/patients/phones/edit')
    @include('administrators/patients/emails/edit')
    @include('administrators/patients/social_works/affiliates/edit')

    <div class="card mt-3">
        <div class="card-header">
            <h4><i class="fas fa-toolbox"></i> {{ trans('forms.complete_personal_data') }} </h4>
        </div>

        <div class="card-body">
            <form method="post"
                  action="{{ route('administrators/patients/update', $patient->id) }}">
                @csrf
                {{ method_field('PUT') }}


                <div class="input-group mb-6 col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.full_name') }} </span>
                    </div>

                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $patient->full_name }}" required>

                    @error('full_name')
                    <span class="invalid-feedback" role="alert">
            	        <strong> {{ $message }} </strong>
       		        </span>
                    @enderror
                </div>

                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.business_name') }}</span>
                    </div>

                    <input type="text" class="form-control" name="business_name" value="{{ $patient->business_name }}">
                </div>

                <div class="input-group mt-2 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.cuit') }} </span>
                    </div>

                    <input type="number" class="form-control" name="key" value="{{ $patient->key }}">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.tax_condition') }} </span>
                    </div>

                    <select class="form-control input-sm" name="tax_condition" id="tax_condition">
                        <option value=""> {{ trans('patients.select_condition') }} </option>
                        <option value="Exempt"> {{ trans('patients.exempt') }} </option>
                        <option value="Monotax"> {{ trans('patients.monotax') }} </option>
                        <option value="Not responsible"> {{ trans('patients.not_responsible') }} </option>
                        <option value="Registered Responsible"> {{ trans('patients.registered_responsible') }} </option>
                    </select>
                </div>

                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.fiscal_address') }} </span>
                    </div>

                    <input type="text" class="form-control" name="fiscal_address"
                           value="{{ $patient->fiscal_address }}">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.city') }} </span>
                    </div>

                    <input type="text" class="form-control" name="city" value="{{ $patient->city }}">
                </div>

                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.start_activity') }} </span>
                    </div>

                    <input type="date" class="form-control @error('start_activity') is-invalid @enderror" name="start_activity" value="{{ $patient->start_activity }}">

                    @error('start_activity')
                    <span class="invalid-feedback" role="alert">
            	        <strong> {{ $message }} </strong>
       		        </span>
                    @enderror
                </div>

                <input id="submit-button" type="submit" style="display: none;">

            </form>
        </div>

        <div class="card-footer">
            <div class="text-right">
                <button onclick="send();" class="btn btn-primary">
                    <span class="fas fa-save"></span> {{ trans('forms.save') }}
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4><i class="fas fa-book"></i> {{ trans('forms.complete_contact_information') }} </h4>
        </div>

        <div class="card-body">
            @include('administrators/patients/phones/index')

            @include('administrators/patients/emails/index')

        </div>
    </div>

    @include('administrators/patients/social_works/affiliates/index')

@endsection
