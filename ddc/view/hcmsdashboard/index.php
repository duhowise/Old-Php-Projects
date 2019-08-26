

<?php $this->htmlLink('hcmsdashboard.css','stylesheet')?>

<div class="grid-container">
    <div class="col-12">
        <div class="col-1"></div>
        <div class="col-2">
            <!--page list-->
            <aside>
                <ul id="page-list">
                    <?php
                        $count = 1;
                        foreach($this->viewBag["hcms_data"]["pages"] as $page){
                            $current = $count == 1 ? 'class="current"' : '';
                            echo "<li data-page = \"{$page->name}\" {$current}>{$page->name}</li>\n";
                            ++$count;
                        }
                    ?>
                </ul>
            </aside>
        </div>

        <div class="col-8">
            <!--page containers zone-->
            <?php
                /*echo "<pre>";
                print_r($this->viewBag["hcms_data"]["containers"]);
                echo "</pre>";*/
                foreach($this->viewBag["hcms_data"]["containers"] as $key => $containers){
                    echo "<div class=\"container-wrapper\" data-page=\"{$key}\">";
                    echo "<!--container pods-->";
                    echo "
                        <div class=\"col-12\">
                            <h2>
                                {$key} Page
                            </h2>
                        </div>
                    ";
                    echo "<form action=\"http://localhost/ddc/hcmsdashboard/upload\" method=\"post\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name = \"page_name\" value = \"{$key}\" />";
                    foreach($containers as $container){
                        $this->render_container($container);
                    }
                    echo "
                            <!-- upload button-->
                            <div class=\"col-12\">
                                <div class=\"col-3\"></div>
                                <div class=\"col-6\">
                                    <!--upload button-->
                                    <button class=\"btn\" type=\"submit\" name=\"upload-submit\">Upload</button>
                                </div>
                                <div class=\"col-3\"></div>
                            </div>
                        ";
                    echo "</form>";
                    echo "</div>";
                }
            ?>







        </div>
        <div class="col-1"></div>

    </div>
</div>
<?php $this->htmlScript("controllers/hcmsdashboard.controller.js","text/javascript")?>

