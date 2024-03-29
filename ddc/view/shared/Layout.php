                                              <!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?=$this->viewBag['title']?></title>
    <!-- page styles -->
    <?php $this->htmlLink('bootstrap.min.css','stylesheet')?>
    <?php $this->htmlLink('shared.css','stylesheet')?>
    <?php $this->htmlScript('jquery-1.10.2.min.js','text/javascript')?>
</head>
<body>

<div id="header-row" class="row">
    <?php
        $this->shared('header');
    ?>
</div>


<div id="content-row" class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?php
            $this->layout_body();
        ?>
    </div>
    <div class="col-md-1"></div>
</div>


<div id="footer-row" class="row">
    <?php
        $this->shared('footer');
    ?>
</div>

<!--<pre>
       <?php
    /*    print_r($_SERVER);
      */?>
                        </pre>-->


<!-- page scripts -->
<?php $this->htmlScript('sswap-lib.js','text/javascript')?>
<?php $this->htmlScript('app/app_services.js','text/javascript')?>
<?php $this->htmlScript('controllers/shared.controller.js','text/javascript')?>
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                