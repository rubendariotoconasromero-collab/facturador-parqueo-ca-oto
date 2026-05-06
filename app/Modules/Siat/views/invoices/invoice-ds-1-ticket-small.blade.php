<style>
@page {
  size: 80mm 120mm portrait;
  margin: 0;
}
* {
    font-size: 9px;
    font-family: "Courier New", Courier, monospace;
    color: #000;
    line-height: 1.2;
}
body {
    width: 72mm;
    margin: 0 auto;
    padding: 4mm 0;
    background-color: #fff;
}
.text-center { text-align: center; }
.bold { font-weight: bold; }
.header { font-size: 13px; margin-bottom: 2px; }
.separator { border-top: 1px dashed #000; margin: 5px 0; }
.table-data {
    width: 100%;
    border-collapse: collapse;
}
.table-data td {
    padding: 0;
}
.footer {
    font-size: 7px;
    margin-top: 10px;
}
.qr-image {
    width: 25mm;
    height: 25mm;
    display: inline-block;
}
</style>

<div class="text-center bold header">PARQUEO CAÑOTO S.R.L</div>
<div class="text-center">CASA MATRIZ</div>

<div class="separator"></div>

<table class="table-data">
    <tr>
        <td style="width: 65%; vertical-align: middle;">
            <div><span class="bold">Razón Social:</span> <?php echo $invoice->customer; ?></div>
            <div><span class="bold">Factura N.:</span> <?php echo $invoiceNum; ?></div>
            <div><span class="bold">NIT/CI/CEX:</span> <?php printf("%s%s", $invoice->nit_ruc_nif, (!empty($invoice->complemento) ? ('-'.$invoice->complemento) : '')) ?></div>
            <div><span class="bold">Fecha:</span> <?php echo sb_format_datetime($invoice->invoice_datetime, 'd/m/Y'); ?></div>
            <div><span class="bold">Importe:</span> <?php echo sb_number_format($invoice->total, 2); ?></div>
            <div><span class="bold">Placa:</span> <?php 
                $placa = '';
                foreach($invoice->items as $item) {
                    if ($item->imei) {
                        $placa = $item->imei;
                        break;
                    }
                }
                echo strtoupper($placa);
            ?></div>
        </td>
        <td style="width: 35%; text-align: right; vertical-align: middle;">
            <img src="<?php print $qr64 ?>" alt="QR" class="qr-image" />
        </td>
    </tr>
</table>

<div class="footer text-center">
    VISUALICE SU FACTURA DESDE EL QR
</div>

