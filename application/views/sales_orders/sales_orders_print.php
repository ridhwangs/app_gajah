<?php 
    $bu = substr($row_master->no_invoice, 0, 6);
    $dealer = $this->crud_model->spsarana_read('dealer', ['dealerID' => $bu])->row();
?> 
<!DOCTYPE html>
<html>
    <title>Sales Order Tools V.1 - <?= $bu ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url(); ?>node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="<?= base_url(); ?>node_modules/jquery/dist/jquery.min.js"></script>
<body>
     <div id="cover-spin"></div>
<style type="text/css">
    body {
        background: rgb(204,204,204); 
        -webkit-print-color-adjust: exact;
        top:0;
        font-size: 9pt;
        font-family: Calibri, Verdana, Segoe, sans-serif;
    }
    w3-wide{letter-spacing:4px}
    page {
        background: white;
        display: block;
        margin: 0 auto;
    }
    .Row {
        display: table;
        width: 100%; /*Optional*/
        table-layout: fixed; /*Optional*/
        border-spacing: 0px; /*Optional*/
    }
    .Column {
        display: table-cell;
    }
    .w3-bar-block .w3-dropdown-hover,.w3-bar-block .w3-dropdown-click{width:100%}
    
    page[size="A4"] {  
        width: 210mm;
        min-height: 275mm;   
    }


    #print-head {
        top: 0;
        padding-top: 10px;
        overflow :auto;
        height:3cm;
        border-bottom: solid thin; 
    }

    .w3-button:hover{color:#000!important;background-color:#9c88ff!important}
    .w3-btn,.w3-button{border:none;display:inline-block;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap}
    .w3-btn:hover{box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)}
    .w3-btn,.w3-button{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}   
    .w3-disabled,.w3-btn:disabled,.w3-button:disabled{cursor:not-allowed;opacity:0.3}.w3-disabled *,:disabled *{pointer-events:none}
    .w3-btn.w3-disabled:hover,.w3-btn:disabled:hover{box-shadow:none}
    .w3-light-grey,.w3-hover-light-grey:hover,.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#f1f1f1!important}
    .w3-left{float:left!important}.w3-right{float:right!important}
    .w3-wide{letter-spacing:4px}
    .w3-left-align{text-align:left!important}.w3-right-align{text-align:right!important}.w3-justify{text-align:justify!important}.w3-center{text-align:center!important}
    table td, table td * {
        vertical-align: top;
    }
    @media print {
        .no-print, .no-print *{
            display: none !important;
        }
    }
	.sparepart {
		line-height: 22px;
	}
</style>
        <div class="w3-top no-print">
            <div class="w3-bar w3-light-grey">
                <a href="javascript:void(0);" onclick="goTo('<?= site_url('sales_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                
                <button style="position:fixed;right:0;" class="w3-button w3-right" onclick="doPrint();"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
   
<page size="A4">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead>
            <tr>
                <td colspan="7">
                <div id="print-head">
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column"><i style="font-family: 'Arial Black'; font-size:12pt;">PT. SURYAPUTRA SARANA</i></div>
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column"><?= $dealer->alamat; ?></div>
                    </div>
                    <div style="padding-left:125px;">
                        
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column">NPWP : <?= $dealer->npwp ?></div>
                        <div class="Column"><b>SALES INVOICE</b></div>
                        <div class="Column" style="width:120px;"></div>
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column">Telp. <?= $dealer->telp ?></div>
                        <div class="Column"><font style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_invoice; ?></b></font></div>
                        <div class="Column" style="width:120px;"></div>
                    </div>
                </div>
                </td>
            </tr>
        </thead>
		<tbody>
			<tr>
				<td colspan="7" style="padding:4px;"></td>
			</tr>
			<tr>
				<td colspan="1">Nama <span style="float:right;">:</span></td>
				<td colspan="3"><?= $row_master->konsumen; ?></td>
                <td colspan="1">Tanggal Invoice <span style="float:right;">:</span></td>
                <td colspan="2"><?= $row_master->tgl_invoice; ?></td>
			</tr>
			<tr>
				<td colspan="1">Alamat <span style="float:right;">:</span></td>
				<td colspan="3"><?= $row_master->address; ?></td>
                <td colspan="1">Jatuh Tempo <span style="float:right;">:</span></td>
                <td colspan="2"><?= $row_master->jatuh_tempo; ?></td>
			</tr>
            <tr>
				<td colspan="1">Kota & Provinsi <span style="float:right;">:</span> </td>
				<td colspan="3"><?= $row_master->kota; ?></td>
                <td colspan="1">Jalur Penjualan <span style="float:right;">:</span></td>
                <td colspan="2"><?= $row_master->xts_deliveryordernumber; ?></td>
			</tr>
            <tr>
				<td colspan="1"></td>
				<td colspan="3"></td>
                <td colspan="1">No DO <span style="float:right;">:</span></td>
                <td colspan="2"><?= $row_master->no_do; ?></td>
			</tr>
			<tr>
				<td colspan="7" style="padding:4px;"></td>
			</tr>
			<tr>
				<th style="border-top:thin solid;border-bottom: thin solid;" width="120px">Kode Produk</th>
				<th style="border-top:thin solid;border-bottom: thin solid;">Deskripsi Produk</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">Jumlah</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;" width="80px">Satuan</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">Harga</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">Diskon</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">Total</th>
			</tr>
			<?php
			$sub_total = 0;
			$no = 0;
			$count = 0;
			
			foreach ($query_details as $key => $row) {
				$count++;
				$sub_total += $row['total'];
			
					
					echo '<tr class="sparepart">
						<td>&nbsp;&nbsp;&nbsp;'.$row['no'].'. &nbsp;&nbsp;'.$row['xts_accountreceivableinvoice1'].'&nbsp;&nbsp;</td>
						<td>'.$row['deskripsi'].'</td>
						<td class="w3-center">'.number_format($row['jumlah'],2).'</td>
						<td>'.$row['satuan'].'</td>
						<td class="w3-right-align">'.number_format($row['harga']).'</td>
						<td class="w3-right-align">'.number_format($row['diskon']).'%</td>
						<td class="w3-right-align">'.number_format($row['total']).'</td>
					</tr>';
				}
			?>
            <tr>
                <td colspan="4" style="border-top:thin solid;"></td>
                <td colspan="2" style="border-top:thin solid;">Sub Total</td>
                <td colspan="1" style="border-top:thin solid;" class="w3-right-align"><?= number_format($row_master->total_after) ?></td>
            </tr>
            <?php if($row_master->jenis_so == "WITH TAX"):  ?>
            <tr>
                <td colspan="4" style=""></td>
                <td colspan="2" style="">PPN</td>
                <td colspan="1" style="" class="w3-right-align">0</td>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="4" style=""></td>
                <td colspan="2" style="">Materai</td>
                <td colspan="1" style="" class="w3-right-align"><?= number_format($row_master->sum_MateraiValue) ?></td>
            </tr>
            <tr>
                <td colspan="4" style=""></td>
                <td colspan="2" style="">Misc Charge</td>
                <td colspan="1" style="" class="w3-right-align"><?= number_format($row_master->sum_AdministrasiValue) ?></td>
            </tr>
            <tr>
                <td colspan="4" style=""></td>
                <td colspan="2" style="border-top:thin dashed;"><b class="w3-wide" style="font-size:12pt;">Grand Total</b></td>
                <td colspan="1" style="border-top:thin dashed;" class="w3-right-align"><b style="font-size:12pt;"><?= number_format($row_master->total_after) ?></b></td>
            </tr>    
		
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:10px;"></div></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom">Terbilang:</td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><b><i># <?= $row_master->terbilang; ?> #</i></b></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:5px;"></div></td>
			</tr>
			<tr>
				<td colspan="7" style="padding:4px;"></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><?= $row_master->note_rek; ?></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:10px;"></div></td>
			</tr>
			<tr>
				<td align="center">Disetujui Oleh,</td>
				<td></td>
				<td align="center">Pelanggan</td>
				<td></td>
				<td></td>
				<td align="center"></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:55px;"></div></td>
			</tr>
			<tr>
				<td  align="center"class="w3-center" style="border-bottom: thin solid;"><?= word_limiter($dicetak_oleh,1,''); ?></td>
				<td></td>
				<td align="center" style="border-bottom: thin solid;"></td>
				<td></td>
				<td></td>
				<td align="center" ></td>
				<td></td>
			</tr>
		</tfoot>		
	</table>
</page>
<script>
//    doPrint();
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == ctrlKey && event.keyCode == 80) {
                doPrint();
            }
        });
    });
    function doPrint(){
        window.print();
    }
    function goToBack(){
        window.history.back();
    }
</script>

<?php $this->load->view('template/footer'); ?>
