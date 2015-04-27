 <!-- navigation add javascript that rewrites the body of the dashboard--> 
    <div>
        <!-- <a href= "#" onClick = javascript() -->
        <script type="text/javascript">
          function dashShowHide(showHideDiv)
          {
              //user demographic first
              if (showHideDiv == "userDemograph") 
              {
                  document.getElementById("userDemograph").style.display = "block";
                  document.getElementById("fileUpload").style.display = "none";
                  document.getElementById("addGenus").style.display = "none";
                  document.getElementById("removeAdmin").style.display = "none";
              }

              if (showHideDiv == "fileUpload") 
              {
                  document.getElementById("userDemograph").style.display = "none";
                  document.getElementById("fileUpload").style.display = "block";
                  document.getElementById("addGenus").style.display = "none";
                  document.getElementById("removeAdmin").style.display = "none";
              }

              if (showHideDiv == "addGenus") 
              {
                  document.getElementById("userDemograph").style.display = "none";
                  document.getElementById("fileUpload").style.display = "none";
                  document.getElementById("addGenus").style.display = "block";
                  document.getElementById("removeAdmin").style.display = "none";
              }

              if (showHideDiv == "removeAdmin") 
              {
                  document.getElementById("userDemograph").style.display = "none";
                  document.getElementById("fileUpload").style.display = "none";
                  document.getElementById("addGenus").style.display = "none";
                  document.getElementById("removeAdmin").style.display = "block";
              }
          }
        </script>
    </div>

  <div class="navigation"></br>
    <div onclick=dashShowHide("userDemograph")> demographic </div>
    <div onclick=dashShowHide("fileUpload")> upload </div>
    <div onclick=dashShowHide("addGenus")> genus addition </div>  
    <div onclick=dashShowHide("removeAdmin")> admin removal </div>
  </div>


<div class="container">
    Dashboard</br>
    <!--<p style="display:none">
     <u><bold>Features to be included:</bold></u></br>
       -Deactivation of accounts</br>
	     -Administrative reactivation of accounts.</br>
       -Administrative tools for demographic data reporting</br> 
       -Entry of DNA mapping information</br>
       -Improved entry of new phage categories, clusters, sub-clusters and genus</br>
       -Addition of Cut location information</br>
       -Improved entry of Phage cut information</br> 
       -Validation of data from phageDB and nebcutter</br>
    </p>-->

 <div id="fileUpload" style="display:none">
   <form id='upload' enctype="multipart/form-data" action="dashboard/fileupload" method="POST">
      <!-- MAX_FILE_SIZE must precede the file input field -->
      <div id="phageType" name="genus" style="display:block">
          <p>&nbsp;&nbsp;<i>Update Phage Enzyme Tool Data</i></p>
            &nbsp;&nbsp;<label><input type='radio' name="filetype"  value=0 id='short' onclick=showGenusFeild()>Short CSV</label>
                        <!-- <label><input type='radio' name="filetype"  value=1 id='full' onclick=showGenusFeild()>Full CSV</label> -->
                        <label><input type='radio' name="filetype"  value=2 id='fasta' onclick=hidePhageGenus()>FASTA File</label>
                        <label><input type='radio' name="filetype"  value=3 id='nebCutData' onclick=showPhageNameFeild();>Neb Cutter Data</label>
                        &nbsp;&nbsp;
            <select id="opts" name="genusName" style='display:none'>
              <?php 

                echo "<option value='null'> None </option>";
              foreach($genusList as $genus){

                echo "<option value=".$genus['GenusID'].">".$genus['Genus']." </option>"; 
              } 
              ?>
            </select>

            <select id='phageNameFeild' name='phageName' style='display:none' >
              <?php 

                echo "<option value='null'> None </option>";
                
              foreach($phageList as $phage){

                echo "<option value=".$phage['PhageID'].">".$phage['PhageName']." </option>"; 
              } 
              ?>
            </select>
      </div>

      <input type="hidden" name="MAX_FILE_SIZE" value="56320000" />
  <!--HEEEEEEEEELLLLPPPPPP TYPE FILE... CSS ME PLEASE-->
      <!-- Name of input element determines name in $_FILES array -->
      <input name="userfile" type="file"/><input type="submit" value="Send File" />
  </form>
</div>

<script type="text/javascript">
  function showPhageNameFeild(){
    $("#phageNameFeild").css('display','block');
    $("#opts").css('display','none');
  }
  function showGenusFeild(){
    $("#phageNameFeild").css('display','none');
    $("#opts").css('display','block');
  }
  function hidePhageGenus(){
    $("#phageNameFeild").css('display','none');
    $("#opts").css('display','none');
  }
</script>


<div id="removeAdmin" style="display:none">
  <p>&nbsp;&nbsp;<i>Remove Administrator</i></p>
  <form>
    <div>
      &nbsp;&nbsp;
      <select id="admins">
        <?php 

        $counter = 0;
        foreach($adminList as $email){

          echo "<option value=".$counter.">".$email['EmailAddress']." </option>";
          $counter += 1;

        } 
        ?>
      </select>
      <input type="submit" value="Remove Admin">
    </div>
  </form>
</div>

<div id = addGenus style="display:none">
  <form action='dashboard/addGenus' method='POST'>
    <p><i>&nbsp;&nbsp;Add New Genus</i></br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Genus Name:  <input type='text' name='newGenus' text="Enter New Genus"></label>
    <input type='submit' value="submit"></p>
  </form>
</div>

<!--Divs that will hold the pie chart-->
<div id="userDemograph" style="display:block">  

<!--<div id="newuserDemograph" style="display:block; width: 350px; height:225px; float: left">
    SHOWING DEMOGRAPHIC INFORMATION
  </div>

  <div id="ulocationDemograph" style="display:block; width: 350px; height:250px; float: left">
    SHOWING DEMOGRAPHIC INFORMATION
  </div>-->
  <p><i>&nbsp;&nbsp;Demographics</i></p>
  <!--<p><img url="googleanalyticsicon.png" alt="Google Analyics Icon"></p>-->
  <div id="container">
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;For complete user demographics data, visit 
      <a href="https://www.google.com/analytics/web/?authuser=0#report/visitors-overview/a61998275w96889679p101106604/"> 
     <i>The Phage Enzyme Tool</i> <b>Google Analytics</b> profile.</a></p>
  </div>

</div>
</div>
