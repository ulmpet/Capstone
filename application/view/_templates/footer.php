</div>
<div class="site-footer">

    Footer works
    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
    <script>
        var url = "<?php echo URL; ?>";
    </script>

    <!-- our JavaScript -->
    <script src="<?php echo URL; ?>js/application.js"></script>
    <!--div class="footerlinks"> Contact Us </div-->
    <?php if(isset($_REQUEST['url']) && $_REQUEST['url'] == "phagetool"){
    echo '<script type="text/javascript" src="'. URL .'js/phagetool.js"></script>';
    echo '<script src="' . URL . 'js/select2.min.js"></script>';
    echo '<link href="'. URL . 'css/select2.css" rel="stylesheet" />';
    echo '<script src="' . URL . 'js/jquery.dataTables.js"></script>';
    echo '<link href="'. URL . 'css/jquery.dataTables.css" rel="stylesheet" />';
    echo '<script src="' . URL . 'js/dataTables.fixedColumns.js"></script>';
    echo '<link href="'. URL . 'css/dataTables.fixedColumns.css" rel="stylesheet" />';
    echo '<script src="' . URL . 'js/jquery-ui.js"></script>';
    echo '<link href="'. URL . 'css/jquery-ui.css" rel="stylesheet" />';
    echo '<link href="'. URL . 'css/jquery-ui.structure.css" rel="stylesheet" />';
    echo '<link href="'. URL . 'css/jquery-ui.theme.css" rel="stylesheet" />';
    echo '<script type="text/javascript"> makeBoxes() </script>';
	}?>

    <?php if(isset($_REQUEST['url']) && $_REQUEST['url'] == "dashboard"){
    echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
    echo '<script type="text/javascript" src="'. URL .'js/newuserDemograph.js"></script>';
    echo '<script type="text/javascript" src="'. URL .'js/ulocationDemograph.js"></script>';
    }?>
    
    <?php include_once("analyticstracking.php") ?>
</div>
</body>
</html>
