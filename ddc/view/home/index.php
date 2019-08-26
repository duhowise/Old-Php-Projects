<?php $this->htmlLink('home.css','stylesheet')?>
<?php $this->htmlLink('bootstrap.min.css','stylesheet')?>

    <!--we are coming to display the contents of the side content container-->
    <!--<pre>
        <?php
        /*
           print_r($this->get_content("SlideShow"));
         */?>
    </pre>-->

    <div class="row">
        <div id="slideShow" class="edge">
            <div id="myCarousel" class="carousel slide">
                <?php
                    $data = $this->get_content("SlideShow");
                    $chk = 0;

                    echo '<ol class="carousel-indicators">';
                    foreach ($data["SlideShow"] as $slide) {
                        $class = $chk == 0? 'active':'';
                        echo "<li data-target=\"#myCarousel\" data-slide-to=\"{$chk}\" class=\"{$class}\"></li>";
                        $chk++;
                    }
                    echo '</ol>';
                ?>

                <div class="carousel-inner">
                    <?php
                        $chk = 0;

                        foreach ($data["SlideShow"] as $key => $slide) {
                            $class = $chk == 0? 'active':'';
                            echo "
            <div class=\"item {$class}\">
                <img src=\"{$slide->url}\" alt=\"\">
                <div class=\"carousel-caption\">
                    <p>{$data["children"]["SlideShow_Caption"][$key]->text}</p>
                </div>
            </div>";
                            ++$chk;
                        }
                    ?>

                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
        </div>
    </div>

    <div class="row margin-top">
        <div class="col-md-8">
            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">Listen Now</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">Watch Now</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">AO4J</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">Ministerial Meetings</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">Community Soccer</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pod edge">
                    <div class="pod-header">Spiritual Emphasis Week</div>
                    <div class="pod-body"></div>
                    <div class="pod-footer"></div>
                </div>
            </div>
        </div>
        <!--daily devotional-->
        <div class="col-md-4">
            <div class="dev-container edge">
                <div class="dev-header">
                    <div class="main-header">Today's Devotional</div>
                    <div class="sub-header">-Tuesday, August 4 2015</div>
                </div>
                <div class="dev-body">
                    <article>
                        How beautiful are the feet of Him who brings good news by Andrew Pappoe Jnr
                        Isaiah 52:7 ¶ How beautiful upon the mountains are the feet of him that bringeth good tidings,
                        that publisheth peace; that bringeth good tidings of good, that publisheth salvation; that saith unto Zion, Thy God reigneth!
                        The watchman discovers from afar the feet of the messenger bringing the much wished-for news of the deliverance from Babylonian
                        Captivity.
                        Today, the Lord is still releasing people from captivity and desires that millions will spread themselves on the mountains, valleys,
                        hamlets and wherever men can be found that to bring good news that Jesus saves and that Jesus reigns.
                        May your feet be among the bearers of the expected and much wished-for news that there is a release from captivity.
                        I bring you the good news today. Jesus saves and is willing to save you.
                        Can you say this with me, I will be one of the beautiful feet.
                    </article>
                </div>
            </div>
        </div>
    </div>
<?php $this->htmlScript('bootstrap.min.js','text/javascript')?>
<?php $this->htmlScript('home.js','text/javascript')?>