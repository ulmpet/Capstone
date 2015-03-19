$(function(){
	$.ajax(url + "/ajax/getPhageNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < jsonResult.length-1 ; i++) {
                    	var temp = jsonResult[i];
                        //console.log(temp);
                    	$("select[name='selPhage[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']))
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    }
                });
    	$.ajax(url + "/ajax/getGenusNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < jsonResult.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selGenus[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    }
                });
        $.ajax(url + "/ajax/getClusterNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < jsonResult.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                        //console.log(temp);
                    	$("select[name='selCluster[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    }
                });
        $.ajax(url + "/ajax/getEnzymeNames")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < jsonResult.length ; i++) {
                    	var temp = $.parseJSON(jsonResult[i]);
                    	$("select[name='selNeb[]']").append($("<option></option>")
                    										.attr("value",temp['ID'])
                    										.text(temp['name']));
                    	//console.log(temp['ID'] +" :"+temp['name']);
                    	//console.log(i);                    
                    }
                });
});


$(function proccessForm(){

});