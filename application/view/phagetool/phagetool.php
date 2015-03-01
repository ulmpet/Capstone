
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

<div>
<form id="selPhage" name="phages" method="post" action="google.php">
    <h3>Select genus</h3>
    <select name="selGenus[]">
        <option value="0">Mycobaterium</option>
        <option value="1">Arthrobacter</option>
        <option value="2">Streptomyces</option>
        <option value="3">Bacillus</option>
    </select>
    
    <h3>Select phage</h3>
    <select name="selPhage[]" multiple="multiple">
        <option value="0">Phage 0</option>
        <option value="1">Phage 1</option>
        <option value="2">Phage 2</option>
        <option value="3">Phage 3</option>
        <option value="4">Phage 4</option>
        <option value="5">Phage 5</option>
    </select>
    
    &nbsp;
    <input type="submit" name="Submit" value="Submit"/>

</form>
</div>

    <pre>

     <u><bold>Features to be included:</bold></u>
       -Phylip (Philo-tree) generation  
       -Weighted comparison of Enzyme cut information from unknown phage to known phage
       -Visualization of known phage cut information 
       -Visualization of unknown phage cut information 
       -Guided Enzyme selection

 </pre>
</div>