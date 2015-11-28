<div class="entry" name="entry-<? echo $entry_id; ?>">
    
    <p class="entry-title">
		<? echo $entry_title; ?>
        <span class="entry-date"> 
		<? echo $entry_date; ?> — <? echo $entry_tags; ?>
        </span>
    </p>
    <p class="media">
    	<? LOAD_MEDIA($entry_title); ?>
    </p>
    
    <div class="entry-text">
    <div class="entry-text-top">
    <p class="entry-extra1"><? echo $entry_extra1; ?></p>
    <p class="entry-extra2"><? echo $entry_extra2; ?></p>
    <p class="clear"></p>
    </div>
    	<? echo $entry_text; ?><br />
    </div>
    
    <a id="close-entry" href="#">close</a>
    
    <p class="entry-line"></p>
    
</div>