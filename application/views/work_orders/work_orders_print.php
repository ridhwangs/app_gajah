<!DOCTYPE html>
<html>
    <title>Work Order Tools V.1</title>
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
                <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders/edit?id_master='.$this->input->get('id_master')); ?>')" class="w3-button w3-left"><i class="fas fa-pencil-alt"></i> Edit</a>

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
                        <div class="Column"><?= $row_master->alamat_kantor; ?></div>
                    </div>
                    <div style="padding-left:125px;">
                        
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column"><?= $row_master->kota_kantor; ?></div>
                        <div class="Column"><b>INVOICE</b></div>
                        <div class="Column" style="width:120px;"></div>
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column">Telp. <?= $row_master->telp_kantor; ?></div>
                        <div class="Column"><font style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_invoice; ?></b></font></div>
                        <div class="Column" style="width:120px;"></div>
                    </div>
                    <div class="Row">
                        <div class="Column" style="width:120px;"></div>
                        <div class="Column">NPWP : <?= $row_master->npwp_kantor; ?></div>
                        <div class="Column"><i><?= $row_master->service_category; ?></i></div>
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
				<td colspan="1">No. Pelanggan</td>
				<td colspan="3">: <?= $row_master->no_pelanggan; ?></td>
				<td colspan="1">No. Polisi</td>
				<td colspan="2">: <?= $row_master->no_polisi; ?></td>
			</tr>
			<tr>
				<td colspan="1">Nama</td>
				<td colspan="3">: <?= $row_master->nm_pelanggan; ?></td>
				<td colspan="1">Model/Type</td>
				<td colspan="2">: <?= $row_master->model; ?></td>
			</tr>
			<tr>
				<td colspan="1">Alamat</td>
				<td colspan="3">: <?= $row_master->alamat_pelanggan; ?></td>
				<td colspan="1">No. Rangka</td>
				<td colspan="2">: <?= $row_master->no_rangka; ?></td>
			</tr>
			<tr>
				<td colspan="1">No. Telp/Fax</td>
				<td colspan="3">: <?= $row_master->no_telp; ?></td>
				<td colspan="1">No. Mesin</td>
				<td colspan="2">: <?= $row_master->no_mesin; ?></td>
			</tr>
			<tr>
				<td colspan="1">NPWP</td>
				<td colspan="3">: -</td>
				<td colspan="1">Thn. Produksi</td>
				<td colspan="2">: <?= $row_master->th_produksi; ?></td>
			</tr>
			<tr>
				<td colspan="1">NIK</td>
				<td colspan="3">: <?= $row_master->nik; ?></td>
				<td colspan="1">KM. Masuk</td>
				<td colspan="2">: <?= $row_master->CurrentMileageWOValue; ?></td>
			</tr>
			<tr>
				<td colspan="1"></td>
				<td colspan="3"></td>
				<td colspan="1">Tgl. Masuk</td>
				<td colspan="2">: <?= date('d/m/Y', strtotime($row_master->tgl_masuk)); ?></td>
			</tr>
			<tr>
				<td colspan="1"></td>
				<td colspan="3"></td>
				<td colspan="1">Tgl. Keluar</td>
				<td colspan="2">: <?= date('d/m/Y', strtotime($row_master->tgl_keluar)); ?></td>
			</tr>
			<tr>
				<td colspan="7" style="padding:4px;"></td>
			</tr>
			<tr>
				<th style="border-top:thin solid;border-bottom: thin solid;" width="120px">KODE</th>
				<th style="border-top:thin solid;border-bottom: thin solid;">KETERANGAN</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">HARGA SATUAN</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;" width="80px">QTY</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">SUB TOTAL</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">DISCOUNT</th>
				<th width="90px" style="border-top:thin solid;border-bottom: thin solid;">TOTAL</th>
			</tr>
			<?php
			$total = 0;
			$no = 0;
			$count = 0;
			$sub_harga_satuan = $sub_qty = $sub_before = $sub_discount = $sub_after = $grand_before = $grand_discount = $grand_after = $grand_harga_satuan = $grand_qty = 0;
			
			foreach ($query_details as $key => $row) {
				$count++;
				$total++;
				$sub_harga_satuan += $row['harga_satuan'];
				$sub_qty += $row['qty'];
				$sub_before += $row['sub_total_before'];
				$sub_discount += $row['discount'];
				$sub_after += $row['sub_total_after'];

				

					if (@$query_details[$key-1]['kategori'] != $row['kategori']) {
						$no++;
						echo '<tr>
								<td colspan="7"><b>'.$no.'. ',$row['kategori'].'</b></td>
							</tr>';
					}

					
					
					echo '<tr class="sparepart">
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row['kode'].'&nbsp;&nbsp;</td>
						<td>'.$row['keterangan'].'</td>
						<td class="w3-right-align">'.number_format($row['harga_satuan']).'</td>
						<td class="w3-center">'.number_format($row['qty'],2).'</td>
						<td class="w3-right-align">'.number_format($row['sub_total_before']).'</td>
						<td class="w3-right-align">'.number_format($row['discount']).'</td>
						<td class="w3-right-align">'.number_format($row['sub_total_after']).'</td>
					</tr>';

					if (@$query_details[$key+1]['kategori'] != $row['kategori']) {
						echo '<tr>
								<td colspan="3" class="w3-right-align w3-wide">Sub Total</td>
								<td class="w3-center" style="border-top:thin dashed;"><b>'.number_format($sub_qty, 2).'</b></td>
								<td class="w3-right-align" style="border-top:thin dashed;"><b>'.number_format($sub_before).'</b></td>
								<td class="w3-right-align" style="border-top:thin dashed;"><b>'.number_format($sub_discount).'</b></td>
								<td class="w3-right-align" style="border-top:thin dashed;"><b>'.number_format($sub_after).'</b></td>
							</tr>';
						echo '<tr>
								<td colspan="7"></td>
							</tr>';
						$sub_harga_satuan = 0;
						$sub_qty = 0;
						$sub_before = 0;
						$sub_discount = 0;
						$sub_after = 0;
					}
					$grand_harga_satuan += $row['harga_satuan'];
					$grand_qty += $row['qty'];
					$grand_before += $row['sub_total_before'];
					$grand_discount += $row['discount'];
					$grand_after += $row['sub_total_after'];
				}
			?>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:8px;"></div></td>
			</tr>
			<tr>
				<td colspan="3" class="w3-right-align w3-wide" style="border-top:thin solid;border-bottom: thin solid;"><b>Total</b></td>
				<td class="w3-center" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_qty,2)?></b></td>
				<td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_before)?></b></td>
				<td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_discount)?></b></td>
				<td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_after)?></b></td>
			</tr>
			<tr>
				<td colspan="7" style="padding:4px;"></td>
			</tr>
			<?php if($row_master->jenis_wo == "WITH TAX"):  ?>
			<tr>
				<td colspan="1">Cara Pembayaran</td>
				<td colspan="3">: <?= $row_master->MethodOfPayment7; ?></td>
				<td colspan="2">DPP</td>
				<td colspan="1" class="w3-right-align"><?= number_format($row_master->dpp) ?></td>
			</tr>
			<tr>
				<td colspan="1">No. Work Order</td>
				<td colspan="3">: <span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_wo; ?></b></span></td>
				<td colspan="2">PPN</td>
				<td colspan="1" class="w3-right-align"><?= number_format($row_master->ppn) ?></td>
			</tr>
			<tr>
				<td colspan="1">Dicetak Oleh</td>
				<td colspan="3">: <?= $dicetak_oleh; ?> </td>
				<td colspan="2">Biaya Materai</td>
				<td colspan="1" class="w3-right-align"><?= number_format($row_master->BeaMaterai) ?></td>
			</tr>
			<tr>
				<td colspan="1">Tanggal Cetak</td>
				<td colspan="3">: <?= date('d/m/Y H:i'); ?></td>
				<td colspan="2" style="border-top:thin dashed;"><b class="w3-wide" style="font-size:12pt;">Grand Total</b></td>
				<td colspan="1" class="w3-right-align" style="border-top:thin dashed;"><b style="font-size:12pt;"><?= number_format($row_master->grand_total) ?></b></td>
			</tr>
		<?php else: ?>
				<tr>
					<td colspan="1">Cara Pembayaran</td>
					<td colspan="3">: <?= $row_master->MethodOfPayment7; ?></td>
					<td colspan="2">Biaya Materai</td>
					<td colspan="1" class="w3-right-align"><?= number_format($row_master->BeaMaterai) ?></td>
				</tr>
				<tr>
					<td colspan="1">No. Work Order</td>
					<td colspan="3">: <span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_wo; ?></b></span></td>
					<td colspan="2" style="border-top:thin dashed;"><b class="w3-wide" style="font-size:12pt;">Grand Total</b></td>
					<td colspan="1" class="w3-right-align" style="border-top:thin dashed;"><b style="font-size:12pt;"><?= number_format($row_master->grand_total) ?></b></td>
				</tr>
				<tr>
					<td colspan="1">Dicetak Oleh</td>
					<td colspan="3">: <?= $dicetak_oleh; ?> </td>
					<td colspan="2"></td>
					<td colspan="1"></td>
				</tr>
				<tr>
					<td colspan="1">Tanggal Cetak</td>
					<td colspan="3">: <?= date('d/m/Y H:i'); ?></td>
					<td colspan="2"></td>
					<td colspan="1"></td>
				</tr>
		<?php endif; ?>
		
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
				<td colspan="7" valign="bottom"><?= $row_master->keterangan; ?></td>
			</tr>
			<tr>
				<td colspan="7" valign="bottom"><div style="margin-bottom:10px;"></div></td>
			</tr>
			<tr>
				<td align="center">Service Advisor,</td>
				<td></td>
				<td align="center">Kasir</td>
				<td></td>
				<td></td>
				<td align="center">Pelanggan</td>
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
				<td align="center" style="border-bottom: thin solid;"></td>
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
