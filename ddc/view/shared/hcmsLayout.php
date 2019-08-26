<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?=$this->viewBag["title"]?></title>
    <?php $this->htmlLink('hcms.css','stylesheet')?>
    <?php $this->htmlLink('responsive.css','stylesheet')?>
    <?php $this->htmlScript('jquery-1.10.2.min.js','text/javascript')?>
    <?php $this->htmlScript('sswap-lib.js','text/javascript')?>
</head>
<body>
        <?php
        $this->shared('hcmsHeader');

        $this->layout_body($this->page);

        //            print_r($_SERVER);
        ?>


<!--<pre>
    <?/*= print_r($this->viewBag["hcms_page_data"]);*/?>
</pre>-->

</body>
</html>