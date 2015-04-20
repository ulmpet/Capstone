
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
        $("#phageOptions").submit();
    }else{
        console.log($("[name='visType']:checked").val());
        if($("[name='visType']:checked").val() == 0){
            $.ajax({
                method: "POST",
                url: url + "/ajax/getKnownCutData",
                data: $("#phageOptions").serialize() }
                )
                .done(function(result){
                    $('#resultTable').children().remove();
                    console.log(result);

                    var info = $.parseJSON(result);
                    if(info['message'] != null){
                        $("#resultTable").html(info['message']);
                        return;
                    }
                    //console.log(info);
                    //$("#resultTable").html(info['rows']);
                    if ( $.fn.dataTable.isDataTable( '#resultTable' ) ) {
                        $.fn.dataTableExt.sErrMode = 'console';
                        $("#resultDiv").html("<table id='resultTable' class='display cell-border'></table>");
                        var table = $("#resultTable").DataTable({
                            
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns'],
                            "columnDefs": [
                                {className: "dt-center", "targets": "_all"},
                            ]
                            
                        });
                        new $.fn.dataTable.FixedColumns( table );
                        $('html, body').animate({
                            scrollTop: $("#resultDiv").offset().top
                        }, 300);
                    }else{
                        $.fn.dataTableExt.sErrMode = 'console';
                        var table = $("#resultTable").DataTable({
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns'],
                            "columnDefs": [
                                {className: "dt-center", "targets": "_all"},
                            ]
                        });
                        new $.fn.dataTable.FixedColumns( table );
                    }
                });
        }else if($("[name='visType']:checked").val() == 1){
            $.ajax({
                method: "POST",
                url: url + "/ajax/buildUknownModal",
                data: $("#phageOptions").serialize() }
                ).done(function(result){
                    $("#unknownData").html(result);
                    $("#unknownData").dialog({
                        modal: true,
                        width: "600",
                        height: "600",
                        title: "select unknown Cuts",
                        buttons: [{
                            text: "Submit",
                            click: function(){
                                submitUnknownData();
                                $(this).dialog("close");
                            },
                        },{
                            text: "Cancel",
                            click: function(){
                                $(this).dialog("close");
                            }
                        }
                        ]
                    })
                });
        }else{
            window.alert("Please select an option under preconditions.")
        }
    }


});
});

function submitUnknownData(){
    //console.log(otherFormData);
    $.ajax({
        type: "POST",
        url: url + "/ajax/getUnknownCutData",
        data: $("form").serialize() }
        )
        .done(function(result){
                    $('#resultTable').children().remove();
                    console.log(result);

                    var info = $.parseJSON(result);
                    if(info['message'] != null){
                        $("#resultTable").html(info['message']);
                        return;
                    }
                    //console.log(info);
                    //$("#resultTable").html(info['rows']);
                    if ( $.fn.dataTable.isDataTable( '#resultTable' ) ) {
                        $.fn.dataTableExt.sErrMode = 'console';
                        $("#resultDiv").html("<table id='resultTable' class='display cell-border'></table>");
                        var table = $("#resultTable").DataTable({
                            
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns'],
                            "columnDefs": [
                                {'className': "dt-center", "targets": "_all"},
                                {"targets": [1], "visible":false, "searchable": false}
                            ],
                            "aaSortingFixed": [[1,'asc']]
                        });
                        new $.fn.dataTable.FixedColumns( table );
                        $('html, body').animate({
                            scrollTop: $("#resultDiv").offset().top
                        }, 300);
                    }else{
                        $.fn.dataTableExt.sErrMode = 'console';
                        var table = $("#resultTable").DataTable({
                            "scrollX" : "100%",
                            "data" : info['rows'],
                            "columns": info['columns'],
                            "columnDefs": [
                                {className: "dt-center", "targets": "_all"},
                                {"targets": [1], "visible":false, "searchable": false}
                            ],
                            "aaSortingFixed": [[1,'asc']]
                        });
                        new $.fn.dataTable.FixedColumns( table );
                    }
                });
}