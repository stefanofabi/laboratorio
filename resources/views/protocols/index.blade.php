@extends('protocols/protocols')

@section('results')
<div class="default">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th> {{ trans('protocols.protocol_number') }} </th>
				<th> {{ trans('patients.patient') }} </th>
				<th> {{ trans('protocols.completion_date') }} </th>
				<th> {{ trans('protocols.type') }} </th>
				<th class="text-right"> {{ trans('forms.actions') }} </th>
			</tr>

			@foreach ($protocols as $protocol)
			<tr>
				<td> @if (date('Y-m-d') == $protocol->completion_date) 
						<span class="badge badge-success">New</span>
					@endif 

					{{ $protocol->id }} 
				</td>

				<td> {{ $protocol->patient }} </td>
				<td> {{ $protocol->completion_date }} </td>
				<td> 
					@if ($protocol->type == 'our') 
						<span class="badge badge-primary">Our</span>
					@else 
						<span class="badge badge-secondary">Derived</span>
					@endif 
				
				</td>

				<td class="text-right">
					<a href="" class="btn btn-info btn-sm" title="{{ trans('patients.show_patient') }}" > <i class="fas fa-eye fa-sm"></i> </a> 
					<a href="" class="btn btn-info btn-sm" title="{{ trans('patients.destroy_patient') }}"> <i class="fas fa-trash fa-sm"></i> </a>
				</td>
			</tr>
			@endforeach


			<tr>
				<td colspan=7>
					<span class="float-right">
							{!! $paginate !!}
					</span>
				</td>
			</tr>

		</table>
	</div>
</div>
@endsection
