<div id="logotype">
	<p class="logo-img"><img src="core/themes/simple2/gfx/logo.jpg" /></p>
    <div id="core-loader"><img src="<? echo $loadingImg;?>" /></div>
</div>

<div id="menu">
	<div class="menu-item">
    <? LOAD_MENU(); ?>
    </div>
    
	<div class="menu-item" id="tags">
    <? LOAD_TAGS("LIST"); ?>
    <a class="tag-all" href="#">all</a>
    </div>
    
    <div class="menu-item" id="entries">
    <? LOAD_ENTRIES("LIST"); ?>
    </div>
</div>

<div id="content">
</div>

<p class="clear"></p>
<div id="footer"><a href="http://weareastronauts.org/core-cms/" target="_blank">Core v1.2</a></div>
</div>

<? require($theme_path . "parts/scripts.php") ?>
