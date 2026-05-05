error_reporting(0); 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<style>
    body {
        margin: 1px 1px 1px 1px;
        font-size: 11px;
        font-weight: normal;
        line-height: 1.5;
        color: #151b1e;           
    }
    .title h2{
        text-align:center;
        margin: 1px 1px 1px 1px;
    }
    .title h3{
        text-align:center;
        font-weight: bold;
        margin: 1px 1px 1px 1px;
    }
    .title h4{
        text-align:center;
        font-weight: normal;
        margin: 1px 1px 1px 1px;
    }
    .footer h4{
        text-align:center;
        font-weight: normal;
        margin: 1px 1px 1px 1px;
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
                    <td >
                        <strong><FONT FACE="COURIER" SIZE=4>Copia - {{ $mesa }} {{ $anulado }}</FONT></strong>
                    </td>
                </tr> 
            </table>
            <table class="table">
                <tr>
                    <td >
                        <FONT FACE="COURIER" SIZE=3>N.Venta: {{ $id }} - Fecha:  {{ $fecha }}</FONT>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <FONT FACE="COURIER" SIZE=3>Mesero: {{ $vendedor }}</FONT>
                    </td>
                </tr>
            </table>
            <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'>
            <table class="table-head">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 20%"><FONT FACE="COURIER" SIZE=4>Cant.</FONT></th>
                        <th style="text-align: center; width: 25%"><FONT FACE="COURIER" SIZE=4>Producto</FONT></th>
                        <th style="text-align: center; width: 20%"><FONT FACE="COURIER" SIZE=4>SubTotal</FONT></th>
                        
                    </tr>
                </thead>
            </table>
            <hr style='height: 1px; width: 100%; margin: 5px 1px 1px 1px; background-color: black;'>
            <!-- <hr style='height: 1px; width: 100%; margin: 1px 1px 1px 1px; background-color: black;'> -->
            <table class="table-body">
                <tbody>
                    @foreach($detalles as $det)
                    <tr>
                        <td style="text-align: center; width: 20%"> <FONT FACE="COURIER" SIZE=3>{{ $det->cantidad}}</FONT></td>
                        <td style="text-align: center; width: 20%"> <FONT FACE="COURIER" SIZE=3>{{ $det->producto}}</FONT></td>  
                        <td style="text-align: center; width: 20%"> <FONT FACE="COURIER" SIZE=3>{{ $det->preciov}}</FONT></td>
                    </tr> 


                    @endforeach
                </tbody> 
            </table>
            @if($observacion == '')

            @else
            <table class="table">
                <tr>
                    <td >
                        <strong><FONT FACE="COURIER" SIZE=3>Observacion</FONT></strong>
                    </td>
                </tr> 
                <tr>
                    <td >
                        <FONT FACE="COURIER" SIZE=2>{{ $observacion}}</FONT>
                    </td>
                </tr> 
            </table>
            @endif

    </body>
</html>