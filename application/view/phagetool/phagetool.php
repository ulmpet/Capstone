<script type="text/javascript">
 function makeBoxes(){
    $(".js-example-basic-multiple").select2({width:"75%"});
    }
</script>
    
    <div class="container">
        <form id="phageOptions" name="options" method="post" action="">
    <table border="0" width="100%">
        <tbody>
            <tr>
                <td colspan="3">
                    <h1><i>Phage Enzyme Tool</i></h1>
                    <h3>Preconditions</h3>
                    <input type="radio" name="visType" value="0" checked=checked>Known phage &nbsp;
                    <input type="radio" name="visType" value="1">Known & unknown phage<br><br>
                    <input type="checkbox" name="boolTree" id="boolTree" value="1">Phylip Tree &nbsp;
                    <input name='postCheck' style='display:none'>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="3">
<!--                     <h3>Select genus</h3>
                    <select name="selGenus[]">
                        <option value="null">Any Genus</option>

                    </select> -->
                </td>
            </tr>

            <tr>
                <td >
                    <h3>Select phage</h3>
                    <select class="js-example-basic-multiple" data-placeholder="Select Phage" name="selPhage[]" multiple="multiple">
                        <option value='all'> All </option>
                        
                    </select>
                </td>
            
                <td >
                    <h3>Select cluster</h3>
                    <select class="js-example-basic-multiple" data-placeholder="Select Cluster" name="selCluster[]" multiple="multiple">
                        <option value="all">ALL</option>
                    </select>
                </td>
            
                <td >
                    <h3>Select sub-cluster</h3>
                    <select class="js-example-basic-multiple" data-placeholder="Select Subcluster" name="selSubCluster[]" multiple="multiple">
                        <option value="all">ALL</option>

                    </select>
                </td>
            </tr>
        
            <tr>    

                <td>
                    <h3>Select NEB enzyme</h3>
                    <select class="js-example-basic-multiple" name="selNeb[]" data-placeholder="Select Enzymes" multiple="multiple">
                        <option value="all">ALL</option>
                    </select>
                </td>

                <td>
                    <h3>Select cut frequency</h3>
                    <select class="js-example-basic-multiple" name="selCuts[]" data-placeholder="Select Cut Frequency" multiple="multiple">
                        <option value="0">None (# of cuts = zero)</option>
                        <option value="1">Few (1 <= # of cuts <= 5)</option>
                        <option value="2">Some (5 <= # of cuts <= 16)</option>
                        <option value="3">Many (16 <= # of cuts <= 41)</option>
                        <option value="4">A lot (# of cuts >= 41)</option>
                    </select>
                </td>
            </tr>
        
            <tr>
                <td align="right" colspan="3">
                    </br><input type="button" id="clicker" value="submit">
                </td>
            </tr>
    </tbody>
    </table>
    
</form>


<div id="resultDiv"  >
    <table id='resultTable' class='display cell-border'>
    </table>
</div>

<div id='unknownData'>
    </div>

</div>

<!--<p>
   <u><bold>Features to be included:</bold></u></br>
   -Phylip (Philo-tree) generation</br>  
   -Weighted comparison of Enzyme cut information from unknown phage to known phage</br>
   -Visualization of known phage cut information</br> 
   -Visualization of unknown phage cut information</br> 
   -Guided Enzyme selection</br>
</p>-->

