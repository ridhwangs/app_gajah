<?php $this->load->view('template/header'); ?>
<style>
    body{
        background-color: #34495e;
    }
    page[size="A4"] {  
        width: 210mm;
        min-height: 275mm; 
    }
    .rowItem:hover {background-color:#bdc3c7;} 
    .Row {
        display: table;
        width: 100%; /*Optional*/
        table-layout: fixed; /*Optional*/
        border-spacing: 0px; /*Optional*/
    }
    .Column {
        display: table-cell;
    }
</style>    
     <div class="w3-top">
        <div class="w3-bar w3-light-grey">
            <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
            <?php if(!empty($this->input->get('id_master'))): ?>
                <button class="w3-button w3-right" onclick="goTo('<?= site_url('work_orders/print?id_master='.$this->input->get('id_master')); ?>')"><i class="fas fa-print"></i> Print Preview</button>
            <?php endif; ?>
        </div>
    </div>
    <div class="w3-panel" style="margin-top: 50px;">
        <div class="w3-light-gray"  style="padding:5px; padding-bottom:10px;">
            <div class="w3-row">
              <div class="w3-half w3-container">
                <form method="POST" action="<?= site_url('work_orders/doCari'); ?>" autocomplete="off">
                    <table border='0' width="100%" cellspacing="0" style="white-space: nowrap;">
                        <tr>
                            <td width="1px">Dari Tanggal</td>
                            <td width="10px" class="w3-center">:</td>
                            <td><input type="date" class="w3-border w3-small" name="tgl_awal" id="tgl_awal" placeholder="Kosongkan jika tidak perlu"></td>
                        </tr>
                        <tr>
                            <td width="1px">Hingga Tanggal</td>
                            <td width="1px" class="w3-center">:</td>
                            <td><input type="date" class="w3-border w3-small" name="tgl_akhir" id="tgl_akhir" placeholder="Kosongkan jika tidak perlu"></td>
                        </tr>
                        <tr>
                            <td width="1px">
                                <select class="w3-small  w3-border" name="on_table" id="on_table" onchange="berdasarkan()">
                                    <option value="">-- Tidak digunakan</option>
                                    <option value="no_invoice">1. No. Invoice</option>
                                    <option value="no_wo">2. No. Work Order</option>
                                    <option value="no_polisi">3. No. Polisi</option>
                                    <option value="nm_pelanggan">4. Nama</option>
                                    <option value="no_rangka">5. No Rangka</option>
									<option value="dpp">6. Total DPP</option>
                                    <option value="ppn">7. Total PPN</option>
                                    <option value="grand_total">8. Grand Total</option>
                                </select>
                            </td>
                            <td class="w3-center">:</td>
                            <td>
                                <input class="w3-border w3-small" type="text" placeholder="Search..." style="width: 350px;" name="q" id="q">
                                <button class="w3-small">Cari</button>
                            </td>
                        </tr>
                    </table>
                </form>
              </div>
              <div class="w3-half w3-container w3-right-align">
                <table border='0' width="100%" cellspacing="0" style="white-space: nowrap;">
                    <tr>
                        <td >Masuk per Hari ini (MMKSI)</td>
                        <td width="3%" class="w3-center">:</td>
                        <td width="5%"><b><?= $count_wo_mmksi ?></b></td>
                    </tr>
                    <tr>
                        <td>Masuk per Hari ini (MFTBC)</td>
                        <td style="border-bottom: thin solid;" class="w3-center">:</td>
                        <td style="border-bottom: thin solid;"><b><?= $count_wo_mftbc ?></b></td>
                    </tr>
                    <tr>
                        <td class="w3-right-align">Total per Hari ini</td>
                        <td class="w3-center">:</td>
                        <td><b><?= $count_wo_mmksi + $count_wo_mftbc ?></b></td>
                    </tr>
                </table>
              </div>
            </div>
            
        </div>
        <div class="w3-row w3-white" style="margin-top:10px;">
            <page size="A4">   
              <div class="w3-col m4 l3" style="overflow-y: scroll; height:205mm;">
                    <div class="w3-responsive w3-white">
                        <table class="" border='0' width="100%" cellspacing="0" style="white-space: nowrap;">
                                <?php
                                    echo '<tbody>';
                                    $no = 1;
                                    foreach ($query_master as $key => $row) {
                                        if($row['tgl_keluar'] != '1970-01-01'){
                                            $tgl_keluar = date('d/m/Y', strtotime($row['tgl_keluar']));
                                        }else{
                                            $tgl_keluar = '-';
                                        }
                                        $get = [
                                            'tgl_awal' => $this->input->get('tgl_awal'),
                                            'tgl_akhir' => $this->input->get('tgl_akhir'),
                                            'on_table' => $this->input->get('on_table'),
                                            'q' => $this->input->get('q'),
                                            'id_master' => $row['id_master']
                                        ];
                                        if($row['id_master'] == $this->input->get('id_master')){
                                            $icon = '<i class="fas fa-hand-point-right"></i> ';
                                            $style = 'style="background-color:#bdc3c7;cursor:pointer"';
                                        }else{
                                            $icon = '';
                                            $style = '';
                                        }
                                        echo '<tr '.$style.' class="rowItem" onclick="goTo(\''. site_url('work_orders/cari?'.http_build_query($get)).'\')" style="cursor:pointer">
                                                 <td style="border:thin dotted;">'.$icon.'<b>'.substr($row['no_wo'], 7).'</b> - <i>KM. '.$row['CurrentMileageWOValue'].'</i></td>
                                            </tr>';

                                    }
                                    echo '</tbody>';
                                ?>
                        </table>
                    </div>
              </div>
              <div class="w3-col m7 l9" style="overflow-y: scroll; height:205mm;">
                <?php if(!empty($this->input->get('id_master'))): ?>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="padding:10px;">
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
				<th style="border-top:thin solid;border-bottom: thin solid;">KODE</th>
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

					
					
					echo '<tr>
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
				<td colspan="2">: <?= $row_master->MethodOfPayment7; ?></td>
				<td colspan="2">DPP</td>
				<td colspan="2" class="w3-right-align"><?= number_format($row_master->dpp) ?></td>
			</tr>
			<tr>
				<td colspan="1">No. Work Order</td>
				<td colspan="2">: <span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_wo; ?></b></span></td>
				<td colspan="2">PPN</td>
				<td colspan="2" class="w3-right-align"><?= number_format($row_master->ppn) ?></td>
			</tr>
			<tr>
				<td colspan="1">Dibuat Oleh</td>
				<td colspan="2">: <?= $row_master->created_by; ?> </td>
				<td colspan="2">Biaya Materai</td>
				<td colspan="2" class="w3-right-align"><?= number_format($row_master->BeaMaterai) ?></td>
			</tr>
			<tr>
				<td colspan="1">Tanggal Cetak</td>
				<td colspan="2">: <?= date('d/m/Y H:i'); ?></td>
				<td colspan="2" style="border-top:thin dashed;"><b class="w3-wide" style="font-size:12pt;">Grand Total</b></td>
				<td colspan="2" class="w3-right-align" style="border-top:thin dashed;"><b style="font-size:12pt;"><?= number_format($row_master->grand_total) ?></b></td>
			</tr>
		<?php else: ?>
				<tr>
					<td colspan="1">Cara Pembayaran</td>
					<td colspan="2">: <?= $row_master->MethodOfPayment7; ?></td>
					<td colspan="2">Biaya Materai</td>
					<td colspan="2" class="w3-right-align"><?= number_format($row_master->BeaMaterai) ?></td>
				</tr>
				<tr>
					<td colspan="1">No. Work Order</td>
					<td colspan="2">: <span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_wo; ?></b></span></td>
					<td colspan="2" style="border-top:thin dashed;"><b class="w3-wide" style="font-size:12pt;">Grand Total</b></td>
					<td colspan="2" class="w3-right-align" style="border-top:thin dashed;"><b style="font-size:12pt;"><?= number_format($row_master->grand_total) ?></b></td>
				</tr>
				<tr>
					<td colspan="1">Dibuat Oleh</td>
					<td colspan="2">: <?= $row_master->created_by; ?> </td>
					<td colspan="2"></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="1">Tanggal Cetak</td>
					<td colspan="2">: <?= date('d/m/Y H:i'); ?></td>
					<td colspan="2"></td>
					<td colspan="2"></td>
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
		</tfoot>		
	</table>
                <?php else: ?>
                 <p  style="padding:20px;">Tidak ada data yang di pilih, Silahkan pilih item di sebelah kiri..</p>
                <?php endif; ?>
              </div>
            </page>
        </div>
    
    </div>
<script>
    $("#tgl_awal").val('<?= $this->input->get('tgl_awal') ?>');
    $("#tgl_akhir").val('<?= $this->input->get('tgl_akhir') ?>');
    $("#q").val('<?= $this->input->get('q') ?>');
    $("#on_table").val('<?= $this->input->get('on_table') ?>');
    berdasarkan();
    function berdasarkan (argument) {
        var key = $("#on_table").val();
        if (key === "") {
            $("#q").attr('disabled', true).prop('required', false);
            $("#q").val("").attr("placeholder", "Tidak menggunakan kata pencarian");
        } else {
            $("#q").attr('disabled', false).prop('required', true).focus().attr("placeholder", "Apa yang akan di cari?");
        }
    }
</script>
<?php $this->load->view('template/footer'); ?>