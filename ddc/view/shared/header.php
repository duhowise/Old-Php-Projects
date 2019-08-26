
<div class="row">
        <header>
            <div class="navbar">
                <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->

                <div class="logo">
                    <div class="img"></div>
                    <div class="text">HERITAGE BAPTIST CHURCH</div>
                </div>

                <nav class="nav-list">
                    <ul>
                        <li><?php $this->htmlAnchor('','Home',null,null,' <span class="glyph-fa">&#xf015;</span>');?></li>
                        <li><a href="javascript:" class="right-arr">Ministries <span class="glyph-fa">&#xf085;</span></a>
                            <ul class="sublink">
                                <li><?php $this->htmlAnchor('ministries/MenOfHonor','Men Of Honor');?></li>
                                <li><?php $this->htmlAnchor('ministries/WomenOfHonor','Women Of Honor');?></li>
                                <li><?php $this->htmlAnchor('ministries/Choir','Choir');?></li>
                                <li><?php $this->htmlAnchor('ministries/AllOut','AO4J');?></li>
                            </ul>
                        </li>
                        <li><?php $this->htmlAnchor('news','Branches',null,null,' <span class="glyph-fa">&#xf1ea;</span>');?></li>
                        <!--<li><?php /*$this->htmlAnchor('multimedia','Multimedia',null,null,' <span class="glyph-fa">&#xf030;</span>');*/?></li>-->
                        <li><?php $this->htmlAnchor('about','About Us',null,null,' <span class="glyph-fa">&#xf004;</span>');?></li>
                        <li><?php $this->htmlAnchor('contact','Contact Us',null,null,' <span class="glyph-fa">&#xf095;</span>');?></li>
                        <li class="join"><?php $this->htmlAnchor('join','Join Us',null,null,' ');?></li>
                    </ul>
                </nav>

            </div>
        </header>
</div>

