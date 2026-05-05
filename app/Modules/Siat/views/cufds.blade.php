<?php
?>
@extends($layout)
@section('title', __('home.home'))

@section('content')
<section class="content-header">
  
	<div class="card-header text-center text-white mb-3" style="background-color: #3399FF">
		<div class="col-sm-12 d-flex justify-content-between align-items-center">
			<h6 class="mb-0 col-md-11">CUFDs SIAT</h6>
		</div>
	</div>
</section>
<!-- Main content -->
<section class="content">
	<div id="siat-app">
		<siat-cufd-listing />
	</div>
</section>
@endsection
@if( $siat_settings->isUltimatePOS() )
@section($section_scripts)
@else
@push($section_scripts)
@endif
<script>window.lt = {baseurl: '{{ url('/') }}'};</script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.13"></script>
<script src="{{ asset('js/modules/siat/config.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/processing.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/toast.js') }}"></script>
<script src="{{ asset('js/modules/siat/siat-config.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/Model.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/User.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/invoice.js') }}"></script>
<script src="{{ asset('js/modules/siat/api.js') }}"></script>
<script src="{{ asset('js/modules/siat/service-invoices.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/cufd-listing.js') }}"></script>
<script src="{{ asset('js/modules/siat/app.js') }}"></script>
@if( $siat_settings->isUltimatePOS() )
@endsection
@else
@endpush
@endif
