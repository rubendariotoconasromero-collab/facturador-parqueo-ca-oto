<?php
?>
@extends($layout)
@section('title', __('home.home'))

@section('content')
<style>
	.custom-input {
        width: 80%; /* Puedes ajustar este valor según tus necesidades */
    }
	.dropdown-wrapper {
  position: relative;
}

.dropdown-wrapper .selected-item {
  height: 25px;
  border-radius: 5px;
  padding: 5px 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dropdown-wrapper .selected-item .drop-down-icon {
  transform: rotate(0deg);
  transition: all 0.5s ease;
}

.dropdown-wrapper .selected-item .drop-down-icon.dropdown {
  transform: rotate(180deg);
}

.dropdown-wrapper .dropdown-popover {
  position: absolute;
  border: 2px solid lightgray;
  top: 46;
  left: 0;
  right: 0;
  background-color: #fff;
  max-width: 100%;
  align-items: center;
  padding: 10px;
  visibility: hidden;
  transition: all 0.35s linear;
  max-height: 0px;
  overflow: hidden;
}

.dropdown-wrapper .dropdown-popover.visible {
  max-height: 450px;
  visibility: visible;
}

.dropdown-wrapper .dropdown-popover input {
  width: 100%;
  height: 30px;
  border: 2px solid lightgray;
  font-size: 18px;
  padding-left: 8px;
}

.dropdown-wrapper .dropdown-popover .options {
  width: 100%;
  padding-top: 12px;
}

.dropdown-wrapper .dropdown-popover .options ul {
  list-style: none;
  text-align: left;
  padding-left: 2px;
  max-height: 200px;
  overflow-y: scroll;
  overflow-x: hidden;
}

.dropdown-wrapper .dropdown-popover .options li {
  width: 100%;
  border-bottom: 1px solid lightgray;
  padding: 5px;
  border: 1px solid lightgray;
  background-color: #f1f1f1;
  cursor: pointer;
}

.dropdown-wrapper .dropdown-popover .options li:hover {
  background: #44536E;
  color: #fff;
  font-weight: bold;
}
</style>
<section class="content-header">
    <div class="card-header text-center text-white mb-3 bg-info">
		<div class="col-sm-12 d-flex justify-content-between align-items-center">
			<h6 class="mb-0 col-md-11">FACTURADOR - SIAT</h6>
		</div>
	</div>
</section>
<!-- Main content -->
<section class="content">
	<div id="siat-app">
		<siat-invoicer></siat-invoicer>
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
<script src="{{ asset('js/modules/siat/functions.js') }}"></script>
<script src="{{ asset('js/modules/siat/config.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/processing.js') }}"></script>
<script src="{{ asset('js/modules/siat/plugins/toast.js') }}"></script>
<script src="{{ asset('js/modules/siat/siat-config.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/Model.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/User.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/invoice.js') }}"></script>
<script src="{{ asset('js/modules/siat/models/evento.js') }}"></script>
<script src="{{ asset('js/modules/siat/api.js') }}"></script>
<script src="{{ asset('js/modules/siat/service-invoices.js') }}"></script>
@if( $siat_settings->isUltimatePOS() )
<script src="{{ asset('js/modules/siat/service-up-customers.js') }}"></script>
@else
<script src="{{ asset('js/modules/siat/service-customers.js') }}"></script>
@endif
<script src="{{ asset('js/modules/siat/service-events.js') }}"></script>
<script src="{{ asset('js/modules/siat/mixins/mixin-common.js') }}"></script>
<script src="{{ asset('js/modules/siat/mixins/mixin-events.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/completion.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/dropdown.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/customer-form.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/cerrar-evento.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/hoteles.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/hospitales.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/colegios.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/entidad-financiera.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/turistico-hospedaje.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/tasa-cero.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/exportacion-servicio.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/exportacion.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/alquiler.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/sectores/prevalorada.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/invoicer-top.js') }}"></script>
<script src="{{ asset('js/modules/siat/components/invoicer.js') }}"></script>
<script src="{{ asset('js/modules/siat/app.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@if( $siat_settings->isUltimatePOS() )
@endsection
@else
@endpush
@endif
