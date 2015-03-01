<?php
/**********************************************************************
<script type="text/javascript">
    function showForm() {
        var selopt = document.getElementById("opts").value;

        if (selopt == "0") {
            document.getElementById("formMyc").style.display = "none";
            document.getElementById("formArt").style.display = "none";
            document.getElementById("formStr").style.display = "none";
            document.getElementById("formBac").style.display = "none";
        }
        if (selopt == "Myco") {
            document.getElementById("formMyc").style.display = "block";
            document.getElementById("formArt").style.display = "none";
            document.getElementById("formStr").style.display = "none";
            document.getElementById("formBac").style.display = "none";
        }
        if (selopt == "Art") {
            document.getElementById("formMyc").style.display = "none";
            document.getElementById("formArt").style.display = "block";
            document.getElementById("formStr").style.display = "none";
            document.getElementById("formBac").style.display = "none";
        }
        if (selopt == "Str") {
            document.getElementById("formMyc").style.display = "none";
            document.getElementById("formArt").style.display = "none";
            document.getElementById("formStr").style.display = "block";
            document.getElementById("formBac").style.display = "none";
        }
        if (selopt == "Bac") {
            document.getElementById("formMyc").style.display = "none";
            document.getElementById("formArt").style.display = "none";
            document.getElementById("formStr").style.display = "none";
            document.getElementById("formBac").style.display = "block";
        }
    }
</script>

<div class="container">
    <h2>Phage Tool</h2>

    <select id="opts" onchange="showForm()">

    <option value="0">Select Genus</option>
    <option value="Myco">Mycobaterium</option>
    <option value="Art">Arthrobacter</option>
    <option value="Str">Streptomyces</option>
    <option value="Bac">Bacillus</option>
    </select>

<div id="formMyc" style="display:none">
    <form name="Mycobacterium">
        <select id="opts" onchange="showForm()">
            <option value="0">Select Cluster</option>
            <option value="1">Option 1A</option>
            <option value="2">Option 1B</option>
        </select>
    </form>

  </div>

<div id="formArt" style="display:none">
    <form name="Arthrobacter">
        <select id="opts" onchange="showForm()">
            <option value="0">Select Cluster</option>
            <option value="1">Option 2A</option>
            <option value="2">Option 2B</option>
        </select>
    </form>
</div>

<div id="formStr" style="display:none">
    <form name="Streptomyces">
        <select id="opts" onchange="showForm()">
            <option value="0">Select Cluster</option>
            <option value="1">Option 3A</option>
            <option value="2">Option 3B</option>
        </select>
    </form>
</div>

<div id="formBac" style="display:none">
    <form name="Bacillus">
        <select id="opts" onchange="showForm()">
            <option value="0">Select Cluster</option>
            <option value="1">Option 4A</option>
            <option value="2">Option 4B</option>
        </select>
    </form>
</div>
**********************************************************************/
?>
    <form id="phageOptions" name="options" method="post" action="google.php">
        <table border="0" width="100%">
            <tbody>
            <tr>
                <td align="center">
                    <h3>Select genus</h3>
                    <select name="selGenus[]">
                        <option value="0">None</option>
                        <option value="1">Mycobacterium</option>
                        <option value="2">Arthrobacter</option>
                        <option value="3">Streptomyces</option>
                        <option value="4">Bacillus</option>
                    </select>
                </td>
    
                <td align="center">
                    <h3>Select phage</h3>
                    <select name="selPhage[]" multiple="multiple">
                        <option value="0">None</option>
                        <option value="1">Phage 1</option>
                        <option value="2">Phage 2</option>
                        <option value="3">Phage 3</option>
                        <option value="4">Phage 4</option>
                        <option value="5">Phage 5</option>
                    </select>
                </td>
    
                <td align="center">
                    <h3>Select cluster</h3>
                    <select name="selCluster[]" multiple="multiple">
                        <option value="0">None</option>
                        <option value="1">Cluster 1</option>
                        <option value="2">Cluster 2</option>
                        <option value="3">Cluster 3</option>
                        <option value="4">Cluster 4</option>
                        <option value="5">Cluster 5</option>
                    </select>
                </td>
    
                <td align="center">
                    <h3>Select sub-cluster</h3>
                    <select name="selSubCluster[]" multiple="multiple">
                        <option value="0">None</option>
                        <option value="1">Sub-cluster 1</option>
                        <option value="2">Sub-cluster 2</option>
                        <option value="3">Sub-cluster 3</option>
                        <option value="4">Sub-cluster 4</option>
                        <option value="5">Sub-cluster 5</option>
                    </select>
                </td>

                <td align="center">
                    <h3>Select NEB enzyme</h3>
                    <select name="selNeb[]" multiple="multiple">
                        <option value="0">None</option>
                        <option value="1">NEB enzyme 1</option>
                        <option value="2">NEB enzyme 2</option>
                        <option value="3">NEB enzyme 3</option>
                        <option value="4">NEB enzyme 4</option>
                        <option value="5">NEB enzyme 5</option>
                    </select>
                </td>

                <td align="center">
                    <h3>Select cut frequency</h3>
                    <select name="selCuts[]" multiple="multiple">
                        <option value="0">None (# of cuts = zero)</option>
                        <option value="1">Few (1 <= # of cuts <= 5)</option>
                        <option value="2">Some (5 <= # of cuts <= 16)</option>
                        <option value="3">Many (16 <= # of cuts <= 41)</option>
                        <option value="4">A lot (# of cuts >= 41)</option>
                    </select>
                </td>
            </tr>
                </br>
                </br>
                </br>
            
            <tr>
                <td align="center">
                    <input type="submit" name="Submit" value="Submit"/>
                </td>
            </tr>
        
        </tbody>
        </table>
    </form>


    <pre>
       <u><bold>Features to be included:</bold></u>
       -Phylip (Philo-tree) generation  
       -Weighted comparison of Enzyme cut information from unknown phage to known phage
       -Visualization of known phage cut information 
       -Visualization of unknown phage cut information 
       -Guided Enzyme selection
    </pre>

