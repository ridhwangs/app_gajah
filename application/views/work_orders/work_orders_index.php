<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style>
    body{
        background-color: #34495e;
    }


    .rowItem:hover {background-color:#bdc3c7;} 
</style>    
     <div class="w3-top">
        <div class="w3-bar w3-light-grey">
            <button onclick="reloadList()" class="w3-button w3-left"><i class="fas fa-sync-alt"></i> Refresh</button>      
            <button class="w3-button w3-right" onclick="goTo('<?= site_url('doLogout'); ?>')"><i class="fas fa-sign-out-alt"></i> Logout</button>
            <button class="w3-button w3-right" onclick="goTo('<?= site_url('profile'); ?>')" class="w3-button w3-left"><i class="fas fa-user"></i> Profile</button>
        </div>
    </div>
    <div class="w3-panel">
        <div class="w3-responsive w3-white" style="margin-top: 40px;">
            <table class="w3-hoverable w3-small" >
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th width="1px"></th>
                        <th width="1px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // error_reporting(0);
                    // Opens directory
                    $myDirectory = opendir($dir);

                    // Gets each entry
                    while ($entryName = readdir($myDirectory)) {
                        $dirArray[] = $entryName;
                    }

                    // Finds extensions of files
                    function findexts($filename) {
                        $filename = strtolower($filename);
                        $exts = explode("[/\\.]", $filename);
                        $n = count($exts) - 1;
                        $exts = $exts[$n];
                        return $exts;
                    }

                    // Closes directory
                    closedir($myDirectory);

                    // Counts elements in array
                    $indexCount = count($dirArray);

                    // Sorts files
                    sort($dirArray);

                    // Loops through the array of files
                    for ($index = 0; $index < $indexCount; $index++) {
                        // Allows ./?hidden to show hidden files
                        if ($_SERVER['QUERY_STRING'] == "hidden") {
                            $hide = "";
                            $ahref = $dir;
                            $atext = "Hide";
                        } else {
                            $hide = ".";
                            $ahref = "./?hidden";
                            $atext = "Show";
                        }

                        if (substr($dirArray[$index], 0, 1) != $hide) {

                            // Gets File Names
                            $name = $dirArray[$index];
                            $namehref = str_replace('\\','\\\\', $dir).'\\\\'.$dirArray[$index];

                            // Gets Extensions 
                            $extn = pathinfo($dirArray[$index], PATHINFO_EXTENSION);

                            // Gets file size 

                            $size = number_format(@filesize($dir . $dirArray[$index]));

                            // Gets Date Modified Data
                            $modtime = date("M j Y g:i A", @filemtime($dir . $dirArray[$index]));
                            $timekey = date("YmdHis", @filemtime($dir . $dirArray[$index]));
                            // Prettifies File Types, add more to suit your needs.
                            $extn = strtoupper($extn) . " File";

                            // Separates directories
                            if (is_dir($dirArray[$index])) {
                                $extn = "&lt;Directory&gt;";
                                $size = "&lt;Directory&gt;";
                                $class = "dir";
                            } else {
                                $class = "file";
                            }

                            // Cleans up . and .. directories 
                            if ($name == ".") {
                                $name = ". (Current Directory)";
                                $extn = "&lt;System Dir&gt;";
                            }
                            if ($name == "..") {
                                $name = ".. (Parent Directory)";
                                $extn = "&lt;System Dir&gt;";
                            }
                            if($extn == "XML File"){
                                   // Print 'em
                            echo '
                            <tr ondblclick="goTo(\''.site_url('work_orders/read/xml?url='.$namehref).'\')" class='.$class.' style="cursor:pointer;">
                                <td><a onclick="goTo(\''.site_url('work_orders/read/xml?url='.$namehref).'\')" href="#">'.$name.'</a></td>
                                <td><a class="w3-button w3-white w3-border w3-tiny w3-border-blue" onclick="goTo(\''.site_url('work_orders/read/xml?url='.$namehref).'\')" href="javascript:void(0)"><i class="fas fa-upload"></i> Proses</a></td>
                                    <td><a class="w3-button w3-white w3-border w3-tiny w3-border-red" onclick="goTo(\''.site_url('work_orders/delete/xml?url='.$namehref).'\')" href="javascript:void(0)"><i class="fas fa-trash"></i></a></td>
                            </tr>';
                            }
                         
                        }
                    }
                    ?>
                </tbody>
            </table>  
        </div>
    </div>
    <div class="w3-panel">
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
        <div class="w3-responsive w3-white" style="padding-top: 5px;">
            <table class="w3-table w3-small w3-bordered " border='0' width="100%" cellspacing="0" style="white-space: nowrap;">
                    <?php
                    echo '<thead>
                            <th>No.</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            <th>Service Category</th>
                            <th>No WO</th>
                            <th>No Invoice</th>
                            <th>Nama</th>
                            <th>No Polisi</th>
                            <th>DPP</th>
                            <th>PPN</th>
                            <th>Grand Total</th>
                            <th>Pembayaran</th>
                            <th>Kasir</th>
                        </thead>
                        <tbody>';
                        $no = 1;
                        foreach ($query_master as $key => $row) {
                            if($row['tgl_keluar'] != '1970-01-01'){
                                $tgl_keluar = date('d/m/Y', strtotime($row['tgl_keluar']));
                            }else{
                                $tgl_keluar = '-';
                            }   
                            echo '<tr class="rowItem" onclick="goTo(\''. site_url('work_orders/print?id_master='.$row['id_master']).'\')" style="cursor:pointer">
                                <td>'.$no++.'.</td>
                                <td class="w3-center">'.date('d/m/Y', strtotime($row['tgl_masuk'])).'</td>
                                <td class="w3-center">'.$tgl_keluar.'</td>
                                <td>'.$row['service_category'].'</td>
                                <td><b>'.substr($row['no_wo'], 7).'</b></td>
                                <td>'.substr($row['no_invoice'], 7).'</td>
                                <td>'.$row['nm_pelanggan'].'</td>
                                <td>'.$row['no_polisi'].'</td>
                                <td class="w3-right-align">'.number_format($row['dpp']).'</td>
                                <td class="w3-right-align">'.number_format($row['ppn']).'</td>
                                <td class="w3-right-align">'.number_format($row['grand_total']).'</td>
                                <td class="w3-center">'.$row['MethodOfPayment7'].'</td>
                                <td class="w3-center">'.$row['kasir'].'</td>
                            </tr>';

                        }
                        echo '</tbody>';
                    ?>
                 <?php
                 if(empty($this->input->get('q'))){ 
                    $show_more = 5 + $list;
                    $fullURL = '?list='.$show_more;
                ?>
                <?php if($num_list > 9): ?>
                 <tfoot style="cursor:pointer">
                    <tr>
                        <td colspan="12" class="w3-center" onclick="goTo('<?= site_url('work_orders'.$fullURL) ?>');"><i class="fas fa-angle-double-down"></i> Tampilan Lebih banyak</td>
                    </tr>
                </tfoot>
                 <?php  endif; } ?>
            </table>
        </div>
    </div>
    <script type="text/javascript">
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