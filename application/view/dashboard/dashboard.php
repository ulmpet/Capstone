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
 <form enctype="multipart/form-data" action="dashboard/fileupload" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="56320000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
</div>
