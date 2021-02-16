<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style>
    body{
        background-color: #34495e;
    }


    .rowItem:hover {background-color:#bdc3c7;} 

    /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    /* The Close Button */
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
</style>
    <div class="w3-top">
        <div class="w3-bar w3-light-grey">
            <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
            <button onclick="reloadList()" class="w3-button w3-left"><i class="fas fa-sync-alt"></i> Refresh</button>
            <button class="w3-button w3-right" onclick="goTo('<?= site_url('work_orders/print?id_master='.$this->input->get('id_master')); ?>')"><i class="fas fa-print"></i> Print Preview</button>
        </div>
    </div>
   
    <div class="w3-panel" style="padding-top:20px;">
        <div class="w3-panel w3-light-gray"  style="padding-bottom:20px;" >
             <table width="100%" border="0" cellspacing="0" >
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
                    <td colspan="3"><?= $row_master->no_invoice; ?></td>
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
        </div>
        
        <div class="w3-responsive w3-light-gray" >
            <table border='0' width="100%" cellspacing="0" >
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
                    echo '<tr class="rowItem" style="cursor:pointer;" onclick="doEdit(\''.$row['id_details'].'\')">
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
                <td colspan="3">: <?= $row_master->no_wo; ?></td>
                <td colspan="2">PPN</td>
                <td class="w3-right-align"><?= number_format($row_master->ppn) ?></td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td colspan="3">: <?= $row_master->created_by; ?> </td>
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
            </table>
        </div>
    </div>
    <!-- The Modal -->
    <div id="modal-edit" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h4>Edit Kategori</h4>
        </div>
        <div class="modal-body">
          <table border='0' width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th style="border-top:thin solid;border-bottom: thin solid;" width="150px;">KATEGORI</th>
                        <th style="border-top:thin solid;border-bottom: thin solid;">KODE</th>
                        <th style="border-top:thin solid;border-bottom: thin solid;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-top:8px;" valign="center">
                            <form method="POST" action="<?= site_url('work_orders/update/kategori'); ?>" autocomplete="off" id="form-edit">
                                <input type="hidden" name="id_details" id="id_details">
                                <select id="kategori" name="kategori" style="width:80%">
                                    <option value="JASA">1. JASA</option>
                                    <option value="OLI">2. OLI</option>
                                    <option value="SPAREPARTS">3. SPAREPARTS</option>
                                    <option value="SUB MATERIAL">4. SUB MATERIAL</option>
                                    <option value="SUB ORDER">5. SUB ORDER</option>
                                    <option value="EQUIPMENT">6. EQUIPMENT</option>
                                </select>
                            </form>
                       
                        </td>
                        <td valign="center"><span id="kode">Membaca...</span></td>
                        <td valign="center"><span id="keterangan">Membaca...</span></td>
                    </tr>
                </tbody>
          </table>
        </div>
          <div class="modal-footer w3-right-align" style="padding-top:10px;">
              <button type="submit" form="form-edit" class="w3-button w3-white w3-border w3-small ">Simpan</button>
        </div>
      </div>
    </div>
<script>
    // Get the modal
    var modal = document.getElementById("modal-edit");
    var span = document.getElementsByClassName("close")[0];
    function doEdit(id_details){
        $.ajax({
            url: "<?= site_url('work_orders/read/details'); ?>",
            method: "POST",
            data: {
              id_details: id_details,
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                $('#form-edit')[0].reset();
                $("#id_details").val(data.id_details);
                $("#kategori").val(data.kategori);
                $("#kode").html(data.kode);
                $("#keterangan").html(data.keterangan);
                modal.style.display = "block";
            }
        });
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }


</script>
<?php $this->load->view('template/footer'); ?>
