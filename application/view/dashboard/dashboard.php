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
    <div onclick=dashShowHide("userDemograph")> Demographic </div>
    <div onclick=dashShowHide("fileUpload")> Upload </div>
    <div onclick=dashShowHide("addGenus")> Genus Addition </div>  
    <div onclick=dashShowHide("removeAdmin")> Admin Removal </div>
  </div>


<div class="container">
    Dashboard</br></br>
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
        
          <label><input type='radio' name="filetype"  value=0 id='short' onclick=showGenusFeild()>Short CSV</label>
          <!-- <label><input type='radio' name="filetype"  value=1 id='full' onclick=showGenusFeild()>Full CSV</label> -->
          <label><input type='radio' name="filetype"  value=2 id='fasta' onclick=hidePhageGenus()>FASTA File</label>
          <label><input type='radio' name="filetype"  value=3 id='nebCutData' onclick=showPhageNameFeild();>Neb Cutter Data</label>
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
  <form action='dashboard/processAdmin' method='post'>
    <div>
      <select id="admins" name="removeAdmin">
        <option value="none">Select An Admin</option>
      <?php 


      foreach($adminList as $admin){

        echo "<option value=".$admin['UserID'].">".$admin['EmailAddress']." </option>";


      } 
      ?>

    </select>
    <input type="submit" value="Remove Admin">
    <select id="users" name="makeAdmin">
      <option value="none">Select A User</option>
      <?php 


      foreach($userList as $user){

        echo "<option value=".$user['UserID'].">".$user['EmailAddress']." </option>";


      } 
      ?>
    </select>
    <input type="submit" value="Grant Admin">
    </div>

  </form>
</div>
<div id = addGenus style="display:none">
  <form action='dashboard/addGenus' method='POST'>
    <p><label>New Genus Name:  <input type='text' name='newGenus' text="Enter New Genus"></label>
    <input type='submit' value="Add Genus"></p>
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

  <div id="container">
    <p>For complete user demographics data, please visit the <a href="https://www.google.com/analytics/web/?authuser=0#report/visitors-overview/a61998275w96889679p101106604/"> phage tool's Google Analytics profile.</a></p>
  </div>

</div>
</div>
