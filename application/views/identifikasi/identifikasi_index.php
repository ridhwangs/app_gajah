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
    <div class="w3-panel">
        </div>
        <div class="w3-responsive" style="padding-top: 5px;">
            <div class="w3-panel w3-light-gray centered" style="padding:20px;">
                <form action="<?= site_url('identifikasi/read/identifikasi'); ?>" method="POST" id="form-login" autocomplete="yes">
                    <table border="0" cellspacing="0" width="250px">
                        <tr>
                            <td align="left"><img src="<?= base_url('assets/images/logo-mmksi.png'); ?>" width="35px"></td>
                            <td align="center"><b></b></td>
                            <td align="right"><img src="<?= base_url('assets/images/logo-fuso.png'); ?>"  width="35px"></td>
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
                            <td colspan="2"><input type="text" name="username" placeholder="Username" id="username" style="width:100%;" required></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:2px;" colspan="3"></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td colspan="2"><input type="password" name="password" placeholder="Password" id="password" style="width:100%;" required></td>
                        </tr>
                        <tr>
                            <td style="padding-top:10px; padding-bottom:10px;" colspan="3"><button type="submit" form="form-login" style="width:100%;">Login</button></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center" style="border-top:1px solid;">App V.1.0</td>
                        </tr>
                   </table>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">

            $("#username").focus();
        <?php
            if(!empty($this->session->set_input)): 
        ?>
            $("#username").val('<?= $this->session->set_input ?>');
            $("#password").focus();
        <?php
            endif; 
        ?>
    </script>
<?php $this->load->view('template/footer'); ?>