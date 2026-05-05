<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<style>
    body {
        margin: 0px 0px 0px 0px;
        font-size: 12px;
        font-weight: normal;
        line-height: 1.5; 
        font-family: Arial;
    }
    .title h2{
        text-align:center;
        margin: 0px 0px 0px 0px;
    }
    .title h3{
        text-align:center;
        font-weight: bold;
        margin: 0px 0px 0px 0px;
    }
    .title h4{
        text-align:center;
        font-weight: normal;
        margin: 0px 0px 0px 0px;
    }
    .footer h4{
        text-align:center;
        font-weight: normal;
        margin: 0px 0px 0px 0px;
    }
    .footer h4{
        text-align:center;
        font-weight: normal;
        margin: 1px 1px 1px 1px;
    }
    .codigo-qr {
        padding: 10px 10px 10px 10px;
        width: 70%;
        margin: 12px 10px 0 10px;
        display:block;
        margin:auto;
    }
    .table {
        display: table;
        margin-left: 10px;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        line-height: 1.5;
        vertical-align: top;
    }
    .table-head {
        display: table;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        line-height: 1.5;
    }
    .table-body {
        display: table;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        line-height: 1.5;
    }
    .table-footer {
        display: table;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        line-height: 1.5;
    }
</style>
<title>Ticket</title>
</head>
    <body>
        <div class='title'>
            <table class="table">
                <tr>
                    <td style="text-align: center;">
                        <strong><FONT FACE="COURIER" SIZE=5>{{ $nombre_empresa }}</FONT></strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <FONT FACE="COURIER" SIZE=3>{{_('Dir. ')}}: {{ $direccion_empresa }}</FONT>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <FONT FACE="COURIER" SIZE=3>{{_('De. ')}}: {{ $nombre_empresa }}</FONT>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <FONT FACE="COURIER" SIZE=3>{{_('Tel. ')}}: {{ $telefono_empresa }}</FONT>
                    </td>
                </tr>
            </table>
            {{-- <h2>{{ $nombre_empresa }}</h2>
            <h4>{{_('Dir. ')}}: {{ $direccion_empresa }}</h4>
            <h4>{{_('De. ')}}: {{ $nombre_empresa }}</h4>
            <h4>{{_('Tel. ')}}: {{ $telefono_empresa }}</h4> --}}
            <hr style='height: 1px; width: 100%; margin: 5px 1px 1px 1px; background-color: black;'>
            <h3 style="font-size: 12px">{{__('NOTA VENTA')}} - {{ $id}}</h3>
            <hr style='height: 1px; width: 100%; margin: 1px 1px 5px 1px; background-color: black;'>
            <h4></h4>
            <table class="table">
                <tr >
                    <td style="text-align: center;">
                        <strong><FONT FACE="COURIER" SIZE=3>{{ $mesa }}</FONT></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <FONT FACE="COURIER" SIZE=3>Fecha: {{ $fecha }}</FONT>
                    </td>
                </tr>
                <tr>
                    <td>
                        <FONT FACE="COURIER" SIZE=3>Mesero: {{ $vendedor }}</FONT>
                    </td>
                </tr>
                <tr>
                    <td>
                        <FONT FACE="COURIER" SIZE=3>SR(ES): {{ $cliente }}</FONT>
                    </td>
                </tr>
            </table>
            <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
            <table class="table-head">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 20%;"><FONT FACE="COURIER" SIZE=3>CANT.</FONT></th>
                        <th colspan="2" style="text-align: center; width: 40%"><FONT FACE="COURIER" SIZE=3>DETALLE</FONT></th>
                        <th colspan="2" style="text-align: center; width: 40%"><FONT FACE="COURIER" SIZE=3>P/U</FONT></th>
                        <th style="text-align: center; width: 30%;"><FONT FACE="COURIER" SIZE=3>SUB TOTAL</FONT></th>
                    </tr>
                </thead>
            </table>
            <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
            <table class="table-body">
                <tbody>
                    @foreach($detalles as $det)
                    @if($id==$det->id_venta)
                    <tr>
                        <td style="text-align: center; width: 30%">{{ $det->cantidad}}</td>
                        <td style="text-align: center; width: 30%">{{ $det->producto}}</td>  
                        <td style="text-align: center; width: 30%">{{ $det->costo_venta}}</td>  
                        <td style="text-align: center; width: 30%">{{ $det->sub_total}}</td>
                    </tr> 
                    @endif
                    @endforeach
                </tbody>
            </table>
            <hr style='text-align: right; height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
            </div>
            {{-- <table style="width: 100%">

            @if($descuento>0)
                <tr style="width: 100%">
                    <td style="text-align: right; width: 20%">
                    <td style="text-align: left; width: 20%">   
                    <td style="text-align: right; width: 30%"><FONT FACE="COURIER" SIZE=3>SUB TOTAL:</FONT></td>
                    <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $sub_total}}</FONT></td>
                </tr> 
                <tr style="width: 100%">
                    <td style="text-align: right; width: 20%">
                    <td style="text-align: left; width: 20%">   
                    <td style="text-align: right; width: 30%"><FONT FACE="COURIER" SIZE=3>DESCUENTO:</FONT></td>
                    <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $descuento}}</FONT></td>
                </tr> 
                <tr style="width: 100%">
                    <td style="text-align: right; width: 20%">
                    <td style="text-align: left; width: 20%">   
                    <td style="text-align: right; width: 30%"><FONT FACE="COURIER" SIZE=3>TOTAL:</FONT></td>
                    <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $total}}</FONT></td>
                </tr> 
            @else
                <tr style="width: 100%">
                    <td style="text-align: right; width: 20%">
                    <td style="text-align: left; width: 20%">   
                    <td style="text-align: right; width: 30%">
                        <FONT FACE="COURIER" SIZE=3>TOTAL:</FONT>

                    </td>
                    <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $total}}</FONT></td>
                </tr>
            @endif
                
            </table> --}}
            <table class="table-body p-2">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: left; width: 30%"><strong><FONT FACE="COURIER" SIZE=3>TOTAL NETO Bs.</FONT></strong></td>
                        <td style="text-align: center; width: 30%"></td>  
                        <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $total}}</td>
                    </tr> 
                    @if($efectivo == 0)

                    @else
                    <tr>
                        <td colspan="2" style="text-align: left; width: 30%"><strong><FONT FACE="COURIER" SIZE=3>EFECTIVO Bs.</FONT></strong></td>
                        <td style="text-align: center; width: 30%"></td>  
                        <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $efectivo}}</td>
                    </tr> 
                    @endif
                    @if($cambio == 0)

                    @else
                    <tr>
                        <td colspan="2" style="text-align: left; width: 30%"><strong><FONT FACE="COURIER" SIZE=3>CAMBIO Bs.</FONT></strong></td>
                        <td style="text-align: center; width: 30%"></td>  
                        <td style="text-align: center; width: 30%"><FONT FACE="COURIER" SIZE=3>{{ $cambio}}</td>
                    </tr> 
                    @endif
                </tbody>
            </table>
            <br>
            <table class="table-body p-2">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: left; width: 30%"><FONT FACE="COURIER" SIZE=3>Son: {{ $total_palabra}}</FONT></td>
                    </tr> 
                </tbody>
            </table>
        </div>
        <br>


        <div class='footer'>
            <table style="width: 100%">
                <tr style="width: 100%">
                    <td style="text-align: center;width: 100%;height: 15px;">
                        @if($estado == 'Registrado')
                            <FONT FACE="COURIER" SIZE=3>PRE CUENTA POR PAGAR</FONT>
                        @else
                            <FONT FACE="COURIER" SIZE=3>CANCELADO</FONT>
                        @endif
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="text-align: center;width: 100%;height: 15px;">
                    <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
                        {{-- {{ '¡Gracias por su preferencia!'}} --}}
                        <FONT FACE="COURIER" SIZE=3>GRACIAS POR SU PREFERENCIA</FONT>
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="text-align: center;width: 100%;">
                    <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
    </body>
</html>