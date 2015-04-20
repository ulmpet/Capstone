    <!-- navigation -->
    <div class="navigation">
        <a href="<?php echo URL; ?>phagetool">Home</a>
        <a href="<?php echo URL; ?>dashboard" <?php 
            if(isset($_SESSION['UID'])){
                if($this->getAuth() < 1){
                    echo 'style="display:none"';
                }
            }else{ 
                header('location: '. URL );
            }
            ?> >Dashboard</a>
        <a href="<?php echo URL; ?>account">Account</a>
        <!--<a href="<?php echo URL; ?>phagetool">Phage Data</a>-->
        <a href="<?php echo URL; ?>home/logout">Log Out</a>
    </div>
