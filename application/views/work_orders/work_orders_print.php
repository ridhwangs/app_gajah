<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style type="text/css">
    body {
        background: rgb(204,204,204); 
    }
    page {
        background: white;
        display: block;
        margin: 0 auto;
    }
    page[size="A4"] {  
        width: 210mm;
        min-height: 275mm;   
    }
    table td, table td * {
        vertical-align: top;
    }
    @media print {
        .no-print, .no-print *{
            display: none !important;
        }
    }
</style>
     <div class="w3-top no-print">
        <div class="w3-bar w3-light-grey">
            <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
            <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders/edit?id_master='.$this->input->get('id_master')); ?>')" class="w3-button w3-left"><i class="fas fa-pencil-alt"></i> Edit</a>
            <button class="w3-button w3-right" onclick="doPrint();"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
<div style="padding-top:50px" class="no-print"></div>
<page size="A4">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td></td>
            <td colspan="5"><i style="font-family: 'Arial Black'; font-size:12pt;">PT. SURYAPUTRA SARANA</i></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><?= $row_master->alamat_kantor; ?></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><?= $row_master->kota_kantor; ?></td>
            <td colspan="3"><b>INVOICE</b></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Telp. <?= $row_master->telp_kantor; ?></td>
            <td colspan="3"><span style="font-family: 'Tahoma'; font-size:11pt;"><b><?= $row_master->no_invoice; ?></b></span></td>
        </tr>
         <tr>
            <td></td>
            <td colspan="2">NPWP : <?= $row_master->npwp_kantor; ?></td>
            <td colspan="3"><i><?= $row_master->service_category; ?></i></td>
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
    <table border='0' width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="7" style="height:12cm;">
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
                <td colspan="3">: <?= $dicetak_oleh; ?> </td>
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
    <table border='0' width="100%" cellspacing="0" cellpadding="0" >
            <tr>
                <td width="200px">Service Advisor,</td>
                <td width="200px"></td>
                <td width="200px">Kasir</td>
                <td width="200px"></td>
                <td width="200px">Pelanggan</td>
                <td width="200px"></td>
            </tr>
            <tr>
                <td colspan="6" valign="bottom"><div style="margin-bottom:55px;"></div></td>
            </tr>
            <tr>
                <td style="border-bottom: thin solid;"></td>
                <td></td>
                <td style="border-bottom: thin solid;"></td>
                <td></td>
                <td style="border-bottom: thin solid;"></td>
                <td></td>
            </tr>
    </table>
</page>
<script>
//    doPrint();
    function doPrint(){
        window.print();
    }
    function goToBack(){
        window.history.back();
    }
</script>

<?php $this->load->view('template/footer'); ?>