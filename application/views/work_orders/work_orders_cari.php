<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style>
    body{
        background-color: #34495e;
    }
    page[size="A4"] {  
        width: 210mm;
        min-height: 275mm; 
    }
    .rowItem:hover {background-color:#bdc3c7;} 
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
                                            $style = 'style="background-color:#bdc3c7;"';
                                        }else{
                                            $icon = '';
                                            $style = '';
                                        }
                                        echo '<tr '.$style.' class="rowItem" onclick="goTo(\''. site_url('work_orders/cari?'.http_build_query($get)).'\')" style="cursor:pointer">
                                                 <td style="border:thin dotted;">'.$icon.'<b>'.substr($row['no_wo'], 7).'</b> - <i>'.$row['service_category'].'</i></td>
                                            </tr>';

                                    }
                                    echo '</tbody>';
                                ?>
                        </table>
                    </div>
              </div>
              <div class="w3-col m7 l9" style="overflow-y: scroll; height:205mm;">
                <?php if(!empty($this->input->get('id_master'))): ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w3-white" style="padding:20px;">
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="3"><b>INVOICE</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="3"><span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_invoice; ?></b></span></td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="bottom"><div style="padding:5px;border-bottom: solid thin; margin-bottom:10px;"></div></td>
                            </tr>
                            <tr>
                               <td width="135px">No. Pelanggan</td>
                               <td width="5px">:</td>
                               <td width="350px"><?= $row_master->no_pelanggan; ?></td>
                               <td width="135px">No. Polisi</td>
                               <td width="5px">:</td>
                               <td width="200px"><?= $row_master->no_polisi; ?></td>
                            </tr>
                            <tr>
                               <td>Nama Pelanggan</td>
                               <td>:</td>
                               <td><?= $row_master->nm_pelanggan; ?></td>
                               <td>Model/Type</td>
                               <td>:</td>
                               <td><?= $row_master->model; ?></td>
                            </tr>
                            <tr>
                               <td>Alamat Pelanggan</td>
                               <td>:</td>
                               <td><?= $row_master->alamat_pelanggan; ?></td>
                               <td>No. Rangka</td>
                               <td>:</td>
                               <td><?= $row_master->no_rangka; ?></td>
                            </tr>
                            <tr>
                               <td>No. Telp/Fax</td>
                               <td>:</td>
                               <td><?= $row_master->no_telp; ?></td>
                               <td>No. Mesin</td>
                               <td>:</td>
                               <td><?= $row_master->no_mesin; ?></td>
                            </tr>
                            <tr>
                               <td>NPWP</td>
                               <td>:</td>
                               <td>-</td>
                               <td>Thn. Produksi</td>
                               <td>:</td>
                               <td><?= $row_master->th_produksi; ?></td>
                            </tr>
                            <tr>
                               <td>NIK</td>
                               <td>:</td>
                               <td><?= $row_master->nik; ?></td>
                               <td>KM. Masuk</td>
                               <td>:</td>
                               <td><?= $row_master->CurrentMileageWOValue; ?></td>
                            </tr>
                            <tr>
                               <td colspan="3"></td>
                               <td>Tgl. Masuk</td>
                               <td>:</td>
                               <td><?= date('d/m/Y', strtotime($row_master->tgl_masuk)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                               <td>Tgl. Keluar</td>
                               <td>:</td>
                                <td><?php if($row_master->tgl_keluar == '1970-01-01'): echo '-'; else: echo date('d/m/Y', strtotime($row_master->tgl_keluar)); endif; ?></td>
                           
                            </tr>
                            <tr>
                                <td colspan="6" valign="bottom"><div style="margin-bottom:15px;"></div></td>
                            </tr>
                        </table>
                        <table border='0' width="100%" cellspacing="0" cellpadding="0" class="w3-white" style="padding:20px;">
                            <tbody>
                                <tr>
                                    <td colspan="7" >
                                        <table border='0' width="100%" cellspacing="0" cellpadding="0" >
                                            <thead>
                                                <tr>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">KODE</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">KETERANGAN</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">HARGA SATUAN</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;" width="80px">QTY</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">SUB TOTAL</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">DISCOUNT</th>
                                                    <th style="border-top:thin solid;border-bottom: thin solid;">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $total = 0;
                                            $no = 0;
                                            $sub_before = $sub_discount = $sub_after = $grand_before = $grand_discount = $grand_after = 0;
                                            foreach ($query_details as $key => $row) {
                                                $total++;
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
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$row['kode'].'</td>
                                                        <td>'.$row['keterangan'].'</td>
                                                        <td class="w3-right-align">'.number_format($row['harga_satuan']).'</td>
                                                        <td class="w3-center">'.number_format($row['qty'],2).'</td>
                                                        <td class="w3-right-align">'.number_format($row['sub_total_before']).'</td>
                                                        <td class="w3-right-align">'.number_format($row['discount']).'</td>
                                                        <td class="w3-right-align">'.number_format($row['sub_total_after']).'</td>
                                                    </tr>';

                                                if (@$query_details[$key+1]['kategori'] != $row['kategori']) {
                                                    echo '<tr>
                                                            <td colspan="4" class="w3-right-align w3-wide">Sub Total</td>
                                                            <td class="w3-right-align" style="border-top:thin dotted;"><b>'.number_format($sub_before).'</b></td>
                                                            <td class="w3-right-align" style="border-top:thin dotted;"><b>'.number_format($sub_discount).'</b></td>
                                                            <td class="w3-right-align" style="border-top:thin dotted;"><b>'.number_format($sub_after).'</b></td>
                                                        </tr>';
                                                    echo '<tr>
                                                            <td colspan="7"></td>
                                                        </tr>';
                                                    $sub_before = 0;
                                                    $sub_discount = 0;
                                                    $sub_after = 0;
                                                }
                                                    $grand_before += $row['sub_total_before'];
                                                    $grand_discount += $row['discount'];
                                                    $grand_after += $row['sub_total_after'];
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="7" valign="bottom"><div style="margin-bottom:8px;"></div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="w3-right-align w3-wide" style="border-top:thin solid;border-bottom: thin solid;"><b>Total</b></td>
                                                <td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_before)?></b></td>
                                                <td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_discount)?></b></td>
                                                <td class="w3-right-align" style="border-top:thin solid;border-bottom: thin solid;"><b><?= number_format($grand_after)?></b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot >
                                
                                <tr>
                                    <td colspan="7" valign="bottom"><div style="margin-bottom:10px;"></div></td>
                                </tr>
                                <tr>
                                    <td>Cara Pembayaran</td>
                                    <td colspan="3">: <?= $row_master->MethodOfPayment7; ?></td>
                                    <td colspan="2">DPP</td>
                                    <td class="w3-right-align"><?= number_format($row_master->dpp) ?></td>
                                </tr>
                                <tr>
                                    <td>No. Work Order</td>
                                    <td colspan="3">: <span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_wo; ?></b></span></td>
                                    <td colspan="2">PPN</td>
                                    <td class="w3-right-align"><?= number_format($row_master->ppn) ?></td>
                                </tr>
                                <tr>
                                    <td>Dicetak Oleh</td>
                                    <td colspan="3">: <?= $row_master->dicetak_oleh; ?> </td>
                                    <td colspan="2">Biaya Materai</td>
                                    <td class="w3-right-align"><?= number_format($row_master->BeaMaterai) ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Cetak</td>
                                    <td colspan="3">: <?= date('d/m/Y H:i'); ?></td>
                                    <td colspan="2" style="border-top:thin dotted;"><b class="w3-wide">Grand Total</b></td>
                                    <td class="w3-right-align" style="border-top:thin dotted;"><b><?= number_format($row_master->grand_total) ?></b></td>
                                </tr>
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
                                    <td colspan="7" valign="bottom"><small class="w3-small"><?= $row_master->keterangan; ?></small></td>
                                </tr>
                                <tr>
                                    <td colspan="7" valign="bottom"><div style="margin-bottom:10px;"></div></td>
                                </tr>
                            </tfoot>
                        </table>
                <?php else: ?>
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