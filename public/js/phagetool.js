
$(function(){
	$.ajax(url + "/ajax/getPhageNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < result.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selPhage[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    };
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed

                });
    	$.ajax(url + "/ajax/getGenusNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < result.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selGenus[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    };
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed

                });
        $.ajax(url + "/ajax/getClusterNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < result.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selCluster[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    };
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed

                });
        $.ajax(url + "/ajax/getEnzymeNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < result.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selNeb[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    };
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed

                });
});

