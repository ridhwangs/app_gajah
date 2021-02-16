<?php $this->load->view('template/header'); ?>
<?php $dir = getenv("HOMEDRIVE") . getenv("HOMEPATH").'\Downloads'; ?>
<style>
    body{
        background-color: #34495e;
    }
    .centered {
      position: fixed;
      top: 50%;
      left: 50%;
      /* bring your own prefixes */
      transform: translate(-50%, -50%);
    }
</style>
   <div class="w3-top no-print">
        <div class="w3-bar w3-light-grey">
            <a href="javascript:void(0);" onclick="goTo('<?= site_url('work_orders'); ?>')" class="w3-button w3-left"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
        </div>
    </div>
    <div class="w3-panel">
        </div>
        <div class="w3-responsive" style="padding-top: 5px;">
            <div class="w3-panel w3-light-gray centered" style="padding:20px;">
                <form action="<?= site_url('profile/update/identifikasi'); ?>" method="POST" id="form-profile" autocomplete="yes">
                	<input type="hidden" name="username" value=<?= $row_user->username; ?>>
                    <table border="0" cellspacing="0" width="400px">
                        <tr>
                            <td colspan="3" align="center"><b>Edit Profile</b></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:5px;" colspan="3"></td>
                        </tr>
                        <?php
                            if(!empty($this->session->msg)){
                        ?>
                            <tr>
                                <td colspan="3" class="w3-lime" style="padding:3px;"><?= $this->session->msg; ?></td>
                            </tr>
                        <?php    
                            } 
                        ?>
                        <tr>
                            <td style="padding-top:5px; border-top:1px solid;" colspan="3"></td>
                        </tr>
                        <tr>
                            <td >Username</td>
                            <td colspan="2"><input type="text" placeholder="Username" id="username" style="width:100%;" required value="<?= $row_user->username; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:2px;" colspan="3"></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td colspan="2"><input type="text" name="password" placeholder="Password" id="password" style="width:100%;" required value="<?= $row_user->password; ?>"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td colspan="2"><input type="text" name="nama" placeholder="Nama Lengkap" id="password" style="width:100%;" required value="<?= $row_user->nama; ?>"></td>
                        </tr>
                        <tr>
                            <td style="padding-top:10px; padding-bottom:10px;" colspan="3"><button type="submit" form="form-profile" style="width:100%;">Simpan</button></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center" style="border-top:1px solid;">Version 3.1.11 LTS</td>
                        </tr>
                   </table>
                </form>
            </div>
        </div>
    </div>
<?php $this->load->view('template/footer'); ?>