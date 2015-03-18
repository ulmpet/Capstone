$(function(){
	$.ajax(url + "/ajax/getPhageNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    console.log(result);
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed

                });
});