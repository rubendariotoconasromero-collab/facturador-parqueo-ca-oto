<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">  

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Factura - Tarjeta</title>
</head>
@php
    $color1 = "#001843";
    $color2 = "#E46C0A";
    $color3 = "#dedbb6";
    $color4 = "#a2d972";
    $color5 = "#000000";
    $color6 = "#E46C0A";
@endphp
<style>
    @page {
        margin: 0.7cm 0.7cm 0.7cm 0.7cm;
        font-size: 12px;
        font-family: Arial;
    }
    body {
        position: relative;
        color: #555555;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 10px;
    }
    .table {
        display: table;
        width: 100%;
        max-width: 100%;
        background-color: transparent;
        border-collapse: collapse;
    }
    .table th {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table td {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table-pago {
        display: table;
        width: 80%;
        max-width: 80%;
        background-color: transparent;
        border-collapse: collapse;
    }
    .table-pago th {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table-pago td {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table-description{
        display: table;
        width: 95%;
        max-width: 95%;
        background-color: transparent;
        border-collapse: collapse;
    }
    .table-description th {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table-description td {
        padding: 0.5rem;
        vertical-align: top;
    }
    .table-head {
        width: 100%;
        max-width: 100%;
        border-collapse: separate;
        border-spacing: 5px;
    }
    .table-head th {
        vertical-align: center;
    }
    .table-body {
        display: table;
        width: 100%;
        max-width: 100%;
        background-color: transparent;
        border-collapse: collapse;
    }
    .table-body th {
        vertical-align: top;
    }
    .table-body td {
        vertical-align: top;
        padding-top: 5px;
        padding-bottom: 2px;
    }
    .table-footer{
        border-top: 1px solid <?php echo $color1; ?>;
        font-size: 10px; 
    }
    .table-saldo{
        text-align: right;
        vertical-align: top;
    }
    .footer-centro{
        position: absolute;
        bottom: 50%;
        left: 0;
        right: 0;
    }
    .footer-inferior{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .A{
        float: left;
        width: 20%; 
        height: 100px; 
        text-align:center;
    }
    .AA{
        float: left;
        text-align:center;
    }
    .BB{
        float: left;
        text-align:center;
    }
    .CC{
        float: left;
        text-align:center;
    }
    .DD{
        float: left;
        text-align:center;
    }
    .EE{
        float: left;
        text-align:center;
    }
    
    .container{
        height: 100px; 
    }
    .container2{
        height: 40px; 
    }
     #lateral { 
        width: 80px; 
    }
    #lateral { 
        height: 100px; 
    } 
    .page_break {
        page-break-before: always;
        @php $tamaño=0 @endphp
    }
    .mostrar {
        display: block;
    }
    .nomostrar {
        display: none;
    }
    .colocar_pie {
        page-break-before: always;

    }

    footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 1.5cm;
            }

</style>
<header>
    <div class="m-0 p-0 text-start">
        {{-- <img src="img/logo/logo_login.png" alt="" height="75" width="125"> --}}
        <?php
            $image = file_get_contents('img/logo/logo.png');

            $html = '<img src="data:image/png;base64,' . base64_encode($image) . '" height="60px" width="150px">';    
            echo $html;
        ?>
    </div>
    <div class="mb-0 pb-0">
        <h2 style="color: black;" class="text-center text-dark">REPORTE DE FACTURACION - PAGOS CON TARJETA</h2>
    </div>
    
    <h2 style="color: black;" class="text-center">
        Desde 
        <strong>
            <?php echo $fecha_inicio?> 
        </strong>
        hasta 
        <strong>
            {{$fecha_fin}}
        </strong>
    </h2>
    <div class="row mt-2">
        <div class="col-md-4">
            <h2 style="color: black;">
                Usuario: 
                <strong class="bg-warning">
                    {{$nombre_usuario}}
                </strong>
            </h2>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <h2 style="color: black;">
                Total facturado Bs.: 
                <strong class="bg-warning">
                    {{$total_facturado}}
                </strong>
            </h2>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-4">
            <h2 style="color: black;">
                Total facturas anuladas Bs.: 
                <strong class="bg-warning">
                    {{$total_anuladas}}
                </strong>
            </h2>
        </div>
    </div>
 
</header>
<body>
    {{-- <br> --}}
    <table class="table table-bordered text-center" style="color: black;">
        <thead>
            <tr class="bg-info" style="background-color: rgb(19, 53, 9); color:white">
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Fecha</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Nº Factura</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Cliente</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Importe Bs.</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Credito Fiscal Bs.</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Método pago</th>
                <th style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">Anulado</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach($items as $item)
          
            <tr>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">{{$item->invoice_datetime}}</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">{{$item->invoice_number}}</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-start text-white">{{$item->customer}}</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">{{$item->total}}</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">{{$item->tax}}</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">TARJETA</td>
                <td style="font-size:1rem; border: 1px solid rgb(77, 71, 71)" class="text-white">{{($item->status=="VOID")?"SI":"NO"}}</td>
            </tr>
            @endforeach
        </tbody>
        
    </table>

</body>



</html>

