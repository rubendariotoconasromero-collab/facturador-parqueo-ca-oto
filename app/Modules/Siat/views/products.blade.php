<?php
?>
@extends($layout)
@section('title', __('home.home'))

@section('content')
<section class="content-header">
	<div class="card-header text-center text-white mb-3 bg-info">
		<div class="col-sm-12 d-flex justify-content-between align-items-center">
			<h6 class="mb-0 col-md-11">LISTADO DE PRODUCTOS - SIAT</h6>
		</div>
	</div>
</section>
<!-- Main content -->
<section class="content">
	<div id="siat-app">
		<siat-products-list />
	</div>
</section>
@endsection
@if( $siat_settings->isUltimatePOS() )
@section($section_scripts)
@else
@push($section_scripts)
@endif
<script>window.lt = {baseurl: '{{ url('/') }}'};</script>
<script src="https://v2.vuejs.org/js/vue.js"></script>
<script src="{{ asset('js/modules/siat/config.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/processing.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/toast.js') }}"></script>
<script src="{{ asset('js/modules/siat/siat-config.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/Model.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/User.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/invoice.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/evento.js') }}"></script>
<script src="{{ asset('js/modules/siat/api.js') }}"></script>

<script src="{{ asset('js/modules/siat/components/pager.js') }}"></script>

<script src="{{ asset('js/modules/siat/service-invoices.js') }}"></script>
<script src="{{ asset('js/modules/siat/service-products.js') }}"></script>
<script src="{{ asset('js/modules/siat/mixins/mixin-events.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/completion.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/product-form.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/products-list.js') }}"></script>
<script src="{{ asset('js/modules/siat/app.js') }}"></script>
@if( $siat_settings->isUltimatePOS() )
@endsection
@else
@endpush
@endif
