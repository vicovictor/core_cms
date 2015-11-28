jQuery.extend({
	
	//content
	firstLoad: function(id) {
		if(!id) id = $(".entry-link:first a").attr("href").replace(/#/,'');
		if(!location.hash) {
			$.sendRequest(id);
		}
	},
	
	contentTarget: undefined,
	
	portfolioPage: undefined,
	
	latestLoad: undefined,
	
	sendRequest: function(id) {
		if(!id) return;
		id = decodeURIComponent(id);
		if(id == jQuery.latestLoad) return;
		if(id.search("tag-") < 0) jQuery.contentLoad(id);
		else jQuery.tagClick(id);
	},
	
	contentLoad: function(id) {
		
		$(".entry-link a").removeClass("link-active");
		$(".entry-link a[href=#"+id+"]").addClass("link-active");
		
		jQuery.contentTarget.animate({"opacity":0},200);
		
		$.ajax({
			type: "POST",
			url: "core/functions/get_entry.php",
			data: "id="+id,
			success: function(data){
				$('html').animate({scrollTop:0}, 200);
				if(/^\d*$/.test(id) || id == $.portfolioPage) $.showMenu();
				else $.hideMenu();
				
				jQuery.latestLoad = id;
				jQuery.contentInsert(data);
			}
		});
	},
	
	showMenu: function() {
		$("#entries, #tags").fadeIn(200);
	},
	
	hideMenu: function() {
		$("#entries, #tags").fadeOut(200);
	},
	
	contentInsert: function(data) {
		var id = jQuery.contentTarget.attr("id");
		jQuery.contentTarget.html(data);
		
		$("#close-entry").click(function(){
			$(".entry-text").removeClass("link-active");
			jQuery.latestLoad = "";
			$(this).parent().html("");
		});
		
		jQuery.contentTarget.animate({"opacity":1},200);
	},
	
	//tags
	tagArray: undefined,
	
	tagClick: function(id) {
		$.showMenu();
		var text,tag,arr,ex,top;
			
		$(".tag-link.link-active").each(function(){
			$(this).removeClass("link-active");								 
		});
		
		$(".tag-link[href='#"+id+"']").each(function(){
			$(this).addClass("link-active");
			tag = $(this).attr("name");
		});
			
		arr = (jQuery.tagArray[tag]);
		top = 0;
		
		if(!arr) arr = [];
		
		$(".entry-link a").each(function() {
			ex = false;
			for (var i = 0;i<arr.length;i++){
				var e_id = $(this).attr("href").replace(/#/,'');
				if( e_id == arr[i] ) ex = true;
			}
			
			if(ex) $(this).css("display","block");
			else $(this).css("display","none");
		});
		
		if($.latestLoad == undefined) {
			top = $(".entry-link a:visible:first").attr("href").replace(/#/,'');
			$.sendRequest(top);
		}

	},
	
	tagAll: function() {
		$.latestLoad = "";
		$(".tag-link.link-active").each(function() {
			$(this).removeClass("link-active");
		});
									 
		$(".entry-link a").each(function() {
			$(this).css("display","block");
		});
	}
});

