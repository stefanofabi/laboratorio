@extends('administrators/default-template')

@section('js')
    <script type="text/javascript">

        function send() {
            let submitButton = $('#submit-button');
            submitButton.click();
        }

        $(document).ready(function () {
            // Select a sex from list
            $('#sex').val('{{ $patient->sex }}');
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
            <h4><i class="fas fa-id-card"></i> {{ trans('forms.complete_personal_data') }} </h4>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('administrators/patients/update', $patient->id) }}">
                @csrf
                {{ method_field('PUT') }}

                <strong> {{ trans('patients.owner_data') }} </strong>
                <div class="input-group mt-2 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.owner') }} </span>
                    </div>

                    <input type="text" class="form-control @error('owner') is-invalid @enderror" name="owner"
                           value="{{ $patient->owner }}" required>

                    @error('owner')
                    <span class="invalid-feedback" role="alert">
            	    <strong> {{ $message }} </strong>
       		    </span>
                    @enderror
                </div>

                <div class="input-group mt-2 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.dni') }} </span>
                    </div>

                    <input type="number" class="form-control" name="key" value="{{ $patient->key }}">
                </div>

                <div class="input-group mt-2 mb-4 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.home_address') }} </span>
                    </div>

                    <input type="text" class="form-control" name="address" value="{{ $patient->address }}">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.city') }} </span>
                    </div>

                    <input type="text" class="form-control" name="city" value="{{ $patient->city }}">
                </div>

                <strong> {{ trans('patients.animal_data') }} </strong>
                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.full_name') }} </span>
                    </div>

                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name"
                           value="{{ $patient->full_name }}" required>

                    @error('full_name')
                    <span class="invalid-feedback" role="alert">
            	        <strong> {{ $message }} </strong>
       		        </span>
                    @enderror
                </div>

                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.sex') }} </span>
                    </div>

                    <select class="form-control input-sm @error('sex') is-invalid @enderror" id="sex" name="sex"
                            required>
                        <option value=""> {{ trans('patients.select_sex') }} </option>
                        <option value="F"> {{ trans('patients.female') }} </option>
                        <option value="M"> {{ trans('patients.male') }} </option>
                    </select>

                    @error('sex')
                    <span class="invalid-feedback" role="alert">
            	        <strong> {{ $message }} </strong>
       		        </span>
                    @enderror
                </div>


                <div class="input-group mt-2 col-md-9 input-form">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> {{ trans('patients.birth_date') }} </span>
                    </div>

                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                           value="{{ $patient->birth_date }}">

                    @error('birth_date')
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
