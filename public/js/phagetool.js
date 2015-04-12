
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
         $.ajax(url + "/ajax/getSubClusters")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    var jsonResult = $.parseJSON(result);
                    //console.log(jsonResult);
                    //console.log(jsonResult.length);
                    for (var i = 0; i < jsonResult.length ; i++) {
                        var temp = jsonResult[i];
                        $("select[name='selSubCluster[]']").append($("<option></option>")
                                                            .attr("value",temp['ID'])
                                                            .text(temp['name']));
                        //console.log(temp['ID'] +" :"+temp['name']);
                        //console.log(i);                    
                    }
                });
                
});

$(window).load(function(){

    //anytime the values of a select box change run this function
$("#clicker").click(function(){
    //console.log( "Phage values: " + $("[name='selPhage[]']").select2("val"));
    //console.log( "Cluster Values: " + $("[name='selCluster[]']").select2("val"));
    //console.log( "Enzyme Values: "+ $("[name='selNeb[]']").select2("val"));
    //console.log( "CUT Values: "+ $("[name='selCuts[]']").select2("val"));

    if($("#boolTree").is(':checked')){
        console.log("makephylipTree!!!!!!!!!!!!!!");
    }else{
        console.log($("[name='visType']:checked").val());
        if($("[name='visType']:checked").val() == 0){
            $.ajax({
                method: "POST",
                url: url + "/ajax/getKnownCutData",
                data: $("#phageOptions").serialize() }
                )
                .done(function(result){
                    $('#resultDiv').children().remove();
                    //console.log(result);
                    var info = $.parseJSON(result);
                    //console.log(info);
                    $("#resultDiv").html(info['rows']);
                    if ( $.fn.dataTable.isDataTable( '#resultDiv' ) ) {
                        $.fn.dataTableExt.sErrMode = 'console';
                        var table = $("#resultDiv").DataTable({
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns'],
                            "destroy": true
                        });
                        new $.fn.dataTable.FixedColumns( table );
                    }else{
                        $.fn.dataTableExt.sErrMode = 'console';
                        var table = $("#resultDiv").DataTable({
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns']
                        });
                        new $.fn.dataTable.FixedColumns( table );
                    }
                });
        }else if($("[name='visType']:checked").val() == 1){
            $.ajax({
                method: "POST",
                url: url + "/ajax/getUnknownCutData",
                data: $("#phageOptions").serialize() }
                )
                .done(function(result){
                    $("#resultDiv").html(result);
                    $("#resultDiv").DataTable();
                });
        }else{
            window.alert("Please select an option under preconditions.")
        }
    }


});
});
/***************************************************
//phageOptions form processing ajax/json

$(function proccessForm(){
    if{
        //code to select which and how the ajax functions should execute
    }
    $.ajax({
        url: '/ajax/knownPhage',
        dataType: 'json',
        type: 'post',
        contentType: 'application/json'
        data:() 
        });

        $.ajax({
            url: '/ajax/unknownPhage',
            dataType: 'json',
            type: 'post',
            contentType: 'application/json'
            data:() 
            });

        $.ajax({
            url: '/ajax/rootPhylip',
            dataType: 'json',
            type: 'post',
            contentType: 'application/json'
            data:()
            });

        $.ajax({
            url: '/ajax/unrootPhylip',
            dataType: 'json',
            type: 'post',
            contentType: 'application/json'
            data:()
            });
});
***************************************************/