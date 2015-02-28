<div class="container">
    <h2>Dashboard</h2>
    <pre>
     <u><bold>Features to be included:</bold></u>
       -Deactivation of accounts
	     -Administrative reactivation of accounts.
       -Administrative tools for demographic data reporting 
       -Entry of DNA mapping information
       -Improved entry of new phage categories, clusters, sub-clusters and genus
       -Addition of Cut location information
       -Improved entry of Phage cut information 
       -Validation of data from phageDB and nebcutter
 </pre>
 <?php Helper::outputArray($adminList);?>
 <form id='upload' enctype="multipart/form-data" action="dashboard/fileupload" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <div id="phageType" style="display:block">
        <select id="opts">
            <option value="0">Select a Genus</option>
            <option value="1">Mycobacterium</option>
            <option value="2">Arthrobacter</option>
            <option value="3">Bacillus</option>
            <option value="4">Streptomyces</option>
        </select>
        <label><input type='radio' name="filetype"  value=0 id='short' onchage=/>Short CSV</label>
        <label><input type='radio' name="filetype"  value=1 id='full' onchange=/>Full CSV</label>
        <label><input type='radio' name="filetype"  value=2 id='fasta' onchange=/>FASTA File</label>
  </div>

    <input type="hidden" name="MAX_FILE_SIZE" value="56320000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>

  <form>
    <div>
      <select id="admins">
      <?php 

      $counter = 0;
      foreach($adminList as $email){

        echo "<option value=".$counter.">".$email['EmailAddress']." </option>";
        $counter += 1;

      } 
      ?>

    </select>
    <br><input type="submit" value="Remove Admin"></br>
    </div>

  </form>
</div>
