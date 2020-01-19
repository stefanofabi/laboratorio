	<div class="card margins-boxs-tb">
		<div class="card-header">
			<h4><i class="fas fa-heartbeat"></i> {{ trans('social_works.social_works') }} </h4>
		</div>

		<div class="card-body">
			<div class="input-group mb-3">
				<div class="input-group-prepend mb-3">
					<span class="input-group-text"> {{ trans('social_works.social_work') }} </span>
				</div>

				<select class="form-control input-sm col-md-6" id="affiliate" style="margin-right: 1%">
					<option value=""> {{ trans('social_works.select_social_work') }}</option>
					@foreach ($affiliates as $affiliate)
					<option value="{{ $affiliate->id }}"> 
						@if ($affiliate->expiration_date < date("Y-m-d"))
						** {{ trans('social_works.expired_card') }} **
						@endif

						{{ $affiliate->social_work }} {{ $affiliate->plan }} 

						@if (!empty($affiliate->affiliate_number))
						[{{ $affiliate->affiliate_number }}]
						@endif

						@if (!empty($affiliate->security_code))
						({{ $affiliate->security_code }})
						@endif
					</option>
					@endforeach
				</select>

				<div>
					<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editAffiliate" onclick="return editAffiliate()">
						<span class="fas fa-edit"></span> 
					</button>

					<button type="button" class="btn btn-info btn-md" onclick="return destroyAffiliate()">
						<span class="fas fa-trash"></span> 
					</button>
				</div>
			</div>
		</div>
	</div>