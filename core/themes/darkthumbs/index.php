<div id="left">
    <div id="logo">
        <p class="dash"></p>
        <p class="logo-img"><img src="core/user/gfx/core_logo_small_white.png" alt="core logotype" /></p>
    </div>
    <p class="clear"></p>
    <div id="pages">
    <? LOAD_MENU(); ?>
    </div>
    <div id="entries">
    <? LOAD_ENTRIES("LIST"); ?>
    </div>
    <div id="tags">
    <? LOAD_TAGS("LIST"); ?>
    <a class="tag-all" href="#">all</a>
    </div>
</div>
<div id="right">
<div id="load-content"></div>
<div id="thumbs">
<? LOAD_ENTRIES("THUMBS"); ?>
</div>
<p class="clear"></p>
<div id="footer">Running on <a href="http://weareastronauts.org/core-cms/" target="_blank">Core v1.2</a></div>
</div>

<div id="core-loader"><img src="<? echo $loadingImg;?>" alt="ajax loader" /></div>
<? require($theme_path . "parts/scripts.php") ?>
