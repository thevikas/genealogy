/*
 * if target is set, they set the value there and quit. otherwise, they move the
 * webpage to that object.
 * #20141026L:vikas:#150:Lima:Refactored most of this for making ajax efficient across all pages of the site.
 * created common system for ajax jumper. needs top be setup all broken ajax callers now.
 * there is also a mjor performance improvement on editing the site after these changes.
 * #201707091050:vikas:Gurgoan:third deployment, genealogy project
 */
$(function() {
	function autojump(event, ui, gourl) {
		if (event.target.hasAttribute('target')) {
			t = event.target.getAttribute('target');
			$("#" + t).val(ui.item.value);
			event.target.value = ui.item.label;
			return false;
		}
		url = gourl + ui.item.value;
		window.location.href = url;
	}

	function dgqajax(request, response, gourl) {
		// request.term is the term searched for.
		// response is the callback function you must call to update the
		// autocomplete's
		// suggestion list.
		$.ajax({
			url : gourl,
			data : {
				q : request.term
			},
			dataType : "json",
			success : response,
			error : function() {
				response([]);
			}
		});
	}
	
	function dgqajaxr(request, response) {
		dgqajax(request, response, '/site/jsobjects/t/r');
	}
	
	$(".person_quick").autocomplete({
		source : dgqajaxr,
		minLength : 3,
		select : function(event, ui) {
			if(event.shiftKey)
				return autojump(event, ui, "/person/update/id/");
			return autojump(event, ui, "/person/view/id/");
		}
	});

	console.log("setup");
});
