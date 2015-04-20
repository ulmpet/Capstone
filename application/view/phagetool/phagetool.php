<form id="phageOptions" name="options" method="post" action="google.php">
    
    <div class="container">
    <table border="0" width="100%">
        <tbody>
        <tr>
            <td align="center" colspan="3">
                <h3>Preconditions</h3>
                <input type="radio" name="visualization type" value="1">Known phage &nbsp;
                <input type="radio" name="visualization type" value="1">Known & unknown phage<br><br>
                <input type="checkbox" name="visualization type" value="1">Phylip Tree &nbsp;
                <select name="phylip visualization">
                    <option value="0">rooted</option>
                    <option value="1">unrooted</option>
                </select>
            </td>
        </tr>
    </div>

    <div>
        <tr>
            <td align="center" colspan="3">
                <h3>Select genus</h3>
                <select name="selGenus[]">
                    <option value="0">No genus</option>
                    <option value="1">Mycobacterium</option>
                    <option value="2">Arthrobacter</option>
                    <option value="3">Streptomyces</option>
                    <option value="4">Bacillus</option>
                </select>
            </td>
        </tr>
    </div>
    
    <div>
        <tr>
            <td align="center">
                <h3>Select phage</h3>
                <select name="selPhage[]" multiple="multiple">
                    <option value="0">No phage</option>
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
                    <option value="0">No cluster</option>
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
                    <option value="0">No sub-cluster</option>
                    <option value="1">Sub-cluster 1</option>
                    <option value="2">Sub-cluster 2</option>
                    <option value="3">Sub-cluster 3</option>
                    <option value="4">Sub-cluster 4</option>
                    <option value="5">Sub-cluster 5</option>
                </select>
            </td>
        </tr>
    </div>
        
    <div>
        <tr>    
            <td align="center">
                <h3>Enzyme presets</h3>
                <select name="selPresets[]" multiple="multiple">
                    <option value="0">No preset</option>
                    <option value="1">preset 1</option>
                    <option value="2">preset 2</option>
                    <option value="3">preset 3</option>
                    <option value="4">preset 4</option>
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
    </div>

    <div>
        <tr>
            <td align="center" colspan="3">
                <input type="submit" name="Submit" value="Submit"/>
            </td>
        </tr>
    </div>
    
    </tbody>
    </table>
</form>


<!--<p>
   <u><bold>Features to be included:</bold></u></br>
   -Phylip (Philo-tree) generation</br>  
   -Weighted comparison of Enzyme cut information from unknown phage to known phage</br>
   -Visualization of known phage cut information</br> 
   -Visualization of unknown phage cut information</br> 
   -Guided Enzyme selection</br>
</p>-->

