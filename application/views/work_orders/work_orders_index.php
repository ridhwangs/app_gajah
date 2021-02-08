<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style>
    body{
        background-color: #34495e;
    }
</style>
     <div class="w3-top">
        <div class="w3-bar w3-light-grey">
            <button onclick="reloadList()" class="w3-button w3-left"><i class="fas fa-sync-alt"></i> Refresh</button>
            <button class="w3-button w3-right" onclick="goTo('<?= site_url('doLogout'); ?>')"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </div>
    <div class="w3-panel">
        <div class="w3-responsive" style="padding-top: 40px;">
            <table class="w3-table-all w3-hoverable w3-small">
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
        <div class="w3-light-gray"  style="padding:5px;">
            <form method="GET" autocomplete="off">
                <div class="w3-row">
                    <select class="w3-small  w3-border" name="on_table" id="on_table" required="">
                        <option value="" disabled>-- Berdasarkan</option>
                        <option value="no_invoice">1. No. Invoice</option>
                        <option value="no_wo">2. No. Work Order</option>
                        <option value="no_polisi">3. No. Polisi</option>
                        <option value="nm_pelanggan">4. Nama</option>
                    </select>
                    <input class="w3-border w3-small" type="text" placeholder="Search..." style="width: 350px;" name="q" id="q">
                    <?php if(!empty($this->input->get('q'))): ?>
                    <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>');">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
          
        </div>
        <div class="w3-responsive" style="padding-top: 5px;">
            <table class="w3-table-all w3-hoverable w3-small" style="white-space: pre;">
                <thead>
                    <th>No.</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Keluar</th>
                    <th>Service Category</th>
                    <th>No Invoice</th>
                    <th>No WO</th>
                    <th>Nama</th>
                    <th>No Polisi</th>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        foreach ($query_master as $row) {
                            echo '<tr onclick="goTo(\''. site_url('work_orders/print?id_master='.$row->id_master).'\')" style="cursor:pointer">
                                    <td>'.$no++.'.</td>
                                    <td>'.date('d/m/Y', strtotime($row->tgl_masuk)).'</td>
                                    <td>'.date('d/m/Y', strtotime($row->tgl_keluar)).'</td>
                                    <td>'.$row->service_category.'</td>
                                    <td>'.$row->no_invoice.'</td>
                                    <td>'.$row->no_wo.'</td>
                                    <td>'.$row->nm_pelanggan.'</td>
                                    <td>'.$row->no_polisi.'</td>
                                </tr>';
                        }
                    ?>
                </tbody>
                 <?php
                 if(empty($this->input->get('q'))){ 
                    $show_more = 5 + $list;
                    $fullURL = '?list='.$show_more.'&on_table='.$this->input->get('on_table').'&q='.$this->input->get('q'); 
                ?>
               
                <?php if($num_list > 1): ?>
                 <tfoot style="cursor:pointer">
                    <tr>
                        <td colspan="8" class="w3-center" onclick="goTo('<?= site_url('work_orders'.$fullURL) ?>');"><i class="fas fa-angle-double-down"></i> Tampilan Lebih banyak</td>
                    </tr>
                </tfoot>
                 <?php  endif; } ?>
            </table>
        </div>
    </div>
<script>
    $("#q").val('<?= $this->input->get('q') ?>');
    $("#on_table").val('<?= $this->input->get('on_table') ?>');
    $("#on_table").on('change', function() {
         $("#q").select();
      });
</script>
<?php $this->load->view('template/footer'); ?>