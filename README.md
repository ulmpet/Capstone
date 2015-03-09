Software Requirements Specification
for
Phage Enzyme Tool v2.0 
		Version 1.0 approved
Prepared by:Micheal Bruscato, Samuel Butler, Micah Gautreaux and Heather Terrel
Computer Science 4060, Group: Mighty No.1
January 28, 2015


Table of Contents

	Revision History	

1.	Introduction	
	1.1	Purpose	
	1.2	Document Conventions	
	1.3	Intended Audience and Reading Suggestions	
	1.4	Product Scope	
	1.5	References	

2.	Overall Description	
	2.1	Product Perspective	
	2.2	Product Functions	
	2.3	User Classes and Characteristics	
	2.4	Operating Environment	
	2.5	Design and Implementation Constraints	
	2.6	User Documentation	
	2.7	Assumptions and Dependencies	

3.	External Interface Requirements	
	3.1	User Interfaces	
	3.2	Hardware Interfaces	
	3.3	Software Interfaces	
	3.4	Communications Interfaces	

4.	System Features	
	4.1	System Feature 1	
	4.2	System Feature 2 (and so on)	

5.	Other Nonfunctional Requirements	
	5.1	Performance Requirements	
	5.2	Safety Requirements	
	5.3	Security Requirements	
	5.4	Software Quality Attributes	
	5.5	Business Rules	

6.	Other Requirements	
	Appendix A: Glossary	
	Appendix B: Analysis Models	
	Appendix C: Use Cases
	Appendix D: To Be Determined List

Revision History
	Name
	Date
	Reason For Changes
	Version


Introduction

Purpose 
	This document describes the implementation of the set of tools whose original software design and prototype was built by Dr. Paul D. Wiedemeier for the University of Louisiana at Monroe Biology department as a set of tools for the analysis and categorization of unknown Mycobacteriophage. Included in this version release, there will be a fully updated user interface and new features for analysis, taxonomy, and prediction. 

Document Conventions
	Priorities for higher-level requirements are assumed to be inherited by detailed requirements.

Intended Audience and Reading Suggestions
	The intended audience for the SRS is the people who will be administrating the software after implementation: ULM Biology, and ULM Computer Science.

Product Scope
	The software to be produced is the application Phage Enzyme Tools version 2.0. The product will provide a specific set of tools to facilitate objective phage analysis for the benefit of the human race. Any general user of the application will have access to the tools and all of their uses therein. Any admin users associated with the P.E.T. v2.0 system are able to edit/add/remove information associated with changes in data on the system, and change permissions associated with any given general level user account. The updated P.E.T. v2.0 will provide an improved visual interface, improved analytics. It will also be equipped with more extensible data storage capabilities, and an entire administrator control section to manage and view enzyme and phage data entry and/or modification functions.

References
	Nebcutter - http://nc2.neb.com/NEBcutter2/
	People responsible for this site: http://nc2.neb.com/NEBcutter2/help/cite.html
	PhageDB - http://phagesdb.org/
	People involved in the management and creation of site: http://phagesdb.org/people/
	Mini PHP Framework - http://www.php-mini.com/

Overall Description

Product Perspective
	This project is to improve the existing P.E.T. by Dr. Paul D. Wiedemeier for the ULM Biology department. 

Product Functions
	The P.E.T. tool will have two distinct levels of user access, general user and administrative user.
		All users will be able to Sign Up
		All users will be able to Sign In 
		All users will be able to Reset Passwords
		All users will be able to set personal user preferences if there are any (undefined thus far…)
		All users willbe able to cancel their account
		All users will be able to have a clean log-out from the system 
		All users will be able to use the current Phage and Enzyme Cut data in the database. 
		View current Phage in the database and corresponding Enzyme Cuts 
		Compare Unknown phage cut counts to known phage cut counts
		Display Phylip generated phylogeny or restriction enzyme cut counts of known phage DNA (Both rooted and unrooted)
		Access visualizations of cut location data for known Enzyme Cut counts on known phage
		Administrator accounts have expanded usage capabilities via an Administrator Dash Board. 
		Add new Administrator level users
		Add new Phage Categories/Clusters/SubClusters
		Add and/or remove data used by P.E.T. v2.0 manually or by .fasta and/or .csv file upload. (may include different file types)
		View usage statistics for user accounts

User Classes and Characteristics
	There will be two main user groups for this project. One will be users that are participating in the HHMI Phage Hunters research program, the other will be the administrating users from ULM. The users participating in the Phage Hunter program will be our general user base. The Main purpose of this tool will be to compare the “Cuts” made by enzymes in the DNA strands of both known and unknown phages.

	The administrative users will be able to preform all the actions the regular users along with tasks that are limited to this access level. Some of these functions are updating/changing the database entries, entering new database entries. 

Operating Environment
	This will operate on a server or virtual server. The Operating System can be any Linux Distribution or version of Windows Server. Some form of web server software (Apache 2 preferred), a Maria Database (MySQL 5 compatible),  and PHP 5 are also required. 

Design and Implementation Constraints
	PHP 5.X
	Maria SQL database (compatible with MySQL)
	HTML5
	CSS
	Bootstrap
	MINI PHP Framework

User Documentation
	The Software will be accompanied by a manual and an online help file. 

Assumptions and Dependencies
	This web application will be dependent on PhagesDB for complete genome sequencing. The cut data is derived from Nebcutter (see resources) via genome files from PhagesDB.

External Interface Requirements

User Interfaces
	There will be one main interface in the application with a menu containing buttons to navigate to the home page, account settings page,  phage data tool page, and a log out button. There will be an administrative dashboard and a phage data file up-loader for the administrative users’ menu only. 

Log In/Sign Up

Phage Data Comparison Tool
	Data will be displayed in an easy to read table format after submission of choices.
		General User (left)
		Administrator (right)

Home Page
	A link to phagesdb.org and news in phage studies will be found here.

Account Settings

Administrator Dashboard
	Phage Data Update File Up-loader

Hardware Interfaces
	Must run on a web connected Server. Linux or Windows OS.
	Software Interfaces
	Software interfaces will be web browsers. (Designed for most recent versions as of 2/2/2015)
	Linux Distributions (redhat, centos, ubuntoo prefered)
	Maria Database , or MySQL5 DBMS

Communications Interfaces
	Application can be reached via HTTP over any web browser on a Internet connected device
	The application will use POST and AJAX methods of data transfer over HTTP for forms and other input

System Features

User Sign Up
4.1.1 Description and Priority
	Priority level - High
	Benefit - allowing the administrators to see usage statistics recorded by the sign up data
	Purpose - Users can create Accounts on the application.  

4.1.2 Stimulus/Response Sequences
	Users click sign up from the home page and fill out the web form. Upon submission the email address provided and other information is saved along with the encrypted password and they have an account.

4.1.3 Functional Requirements
	REQ-1:	SHA-1 hashing for passwords 
	REQ-2:	Input Validation to prevent erroneous input.

User Sign In
4.2.1 Description and Priority
	This is a High priority feature. The user will not be able to access the tools functions without first singing into their registered account.
	Priority level - High
	Benefit - Grants Users access to the application.
	Purpose - The user can use the tool and all of its features.  

4.2.2 Stimulus/Response Sequences
	No stimulus is required for the User Sign In function. 
	Once the user puts in a valid user name and password they will be taken to the Home page 

4.2.3 Functional Requirements
	REQ-1:	SHA-1 hashing for passwords
	REQ-2:	Input Validation to prevent erroneous input.

4.3 User Password Reset

4.3.1	Description and Priority
	Priority level - Low
	Benefit - Allows users to rest lost or forgotten passwords
	Purpose - enables users to recover passwords to prevent duplicate accounts 

4.3.2	Stimulus/Response Sequences
	The User will request a password reset 
	The Server will send a link to redirect the user to renewing the password via established email address. 

4.3.3	Functional Requirements
	REQ-1:	SHA-1 hashing for new passwords
	REQ-2:	Send a link user for validation and temp password


4.4 Set User Preferences
4.4.1	Description and Priority
Priority level - Low
	Benefit -  Gives users the ability to fine tune the interface. 
	Purpose - Change the layout of the application
4.4.2	Stimulus/Response Sequences
	User will click the settings tab.
	The user will be taken to the Preferences page. 
4.4.3	Functional Requirements
REQ-1:	TBD(1)

4.5 User Cancel Account
4.5.1	Description and Priority
	Priority level - Medium 
	Benefit - Allows User to remove their data from our database for statistical accuracy
	Purpose - Users can cancel their account. 
4.5.2	Stimulus/Response Sequences
	Users Select Cancel Account from the Account settings menu to remove their account from the database.
	Causes a database transaction removing the account from the database.
4.5.3	Functional Requirements
REQ-1:	Working Database
4.6  Log-out
4.6.1	Description and Priority
	Priority level - medium
	Benefit - Clears user session data from the server. 
	Purpose - Users can log out of their session from the application .
4.6.2	Stimulus/Response Sequences
	User Clicks log out from the left menu and their session data is erased. 
4.6.3	Functional Requirements
REQ-1:	A working session to be cleared.
4.7 View known Phage information from the database.
4.7.1	Description and Priority
	Priority level - High
	Benefit - Core Functionality of the application. 
	Purpose - Users can Query the database and have displayed to them information regarding known phages.  
4.7.2	Stimulus/Response Sequences
	User selects from drop down menus the phages they wish displayed along with the enzymes they want to see interaction data for. The program then displays on the same page a table of the selected data. 
4.7.3	Functional Requirements
REQ-1:	Database Connection
REQ-2:	Phage information 
REQ-3:	Ajax call for data request (prevents page refresh)
REQ-4:	Multi Select Dropdown menus
4.8 Compare unknown phage cut counts to known phage cut counts
4.8.1	Description and Priority
	Priority level - High
	Benefit - Core Functionality and purpose of application.
	Purpose - Users can be shown potential cluster and sub cluster matches for their unknown phage. 
4.8.2	Stimulus/Response Sequences
	Users select unknown phage from the phage list along with the enzymes to test against. A Modal dialog box will become visible and request further information about the phage and enzyme interactions. the application will then calculate and query the database for an accurate prediction of cluster and sub-cluster of the unknown phage. 
4.8.3	Functional Requirements
REQ-1:	Database with phage and enzyme interaction information
REQ-2:	JQuery Modal 
REQ-3:	Ajax call to prevent page refresh
REQ-4:	Multi select drop down boxes for enzyme and phage selections
4.9 Display Phylip generated phylogeny or restriction enzyme cut counts of known phage DNA (both rooted and unrooted) 
4.9.1	Description and Priority
	Priority level - Medium
	Benefit - provide a predictive tool for classification of Phage based on DNA
	Purpose - Displays created PHYLIP trees in PDF format
4.9.2	Stimulus/Response Sequences
		Users select view Tree selection from a menu.
4.9.3	Functional Requirements
REQ-1:	Phylip Library
REQ-2:	TBD(2)

4.10 Access visualizations of cut location data of Known Phages
4.10.1  Description and Priority
	Priority level - Medium
	Benefit -  This will allow the users to see the data in a more tangible form.
	Purpose - This function is to represent the cut locations in a visual manner. 
4.10.2  Stimulus/Response Sequences
	The user will simply select the appropriate tab.
	The Application will show the user the appropriate visualizations. 
4.10.3	  Functional Requirements
REQ-1:	TBD(3)
4.11 Create new Admin level accounts
4.11.1  Description and Priority
	Priority level - Low
	Benefit - New Administrators to input data.
	Purpose - The existing admins will have the ability to add new admin level accounts so that more meaningful data can be added to the database.
4.11.2  Stimulus/Response Sequences
	Admin will created a new account that has admin rights.
	The system will create a new account that has admin privledges. 
4.11.3  Functional Requirements
REQ-1:	The Administrator will have the ability to create new admins. 
REQ-2:    The current admin can query for an existing email or create a new account.
4.12 Add new Phage Categories/Clusters/SubClusters
4.12.1  Description and Priority
	Priority level - Medium
	Benefit - Allows the project to be expanded to other types of Phages. 
	Purpose - This feature will allow admins to add new types of phage that may not be listed in the primary database. 
4.12.2  Stimulus/Response Sequences
	From the administration Dash Board Administrators will have the option to manually enter in new Genus/Cluster/and Sub-cluster entries
4.12.3  Functional Requirements
REQ-1:	Database interactions
REQ-2:	Form Validation and Processing.
4.13 Add and/or remove data used by P.E.T. v2.0 manually or by .fasta and/or .csv file upload. (may include different file types)
4.13.1  Description and Priority
	Priority level - High
Benefit - Allows simple database updating via a dashboard and file        processing rather than manual code editing
	Purpose - Administrative users can upload files to be processed and added to the database automatically.
4.13.2  Stimulus/Response Sequences
From the administrative dashboard the admin can select to update or add to the database. They then navigate to the file on their computer and upload it where it is parsed and processed and added to the database. 
4.13.3  Functional Requirements
REQ-1:	Database Link
REQ-2:	File Parser for each file format
4.14 View usage statistics for user account
4.14.1  Description and Priorities
	Priority level - Low
	Benefit - Allow admins to see the frequency of users using the site.
	Purpose - Admins will be able to determine how frequently the site is being used by users and project a possible growth in the use of the tool. 
4.14.2  Stimulus/Response Sequences
		Admin will select usage data from admin tools.
		The server will return the appropriate data. 
4.14.3  Functional Requirements
REQ-1:	database access
REQ-2:	data processing
REQ-3:	Javascript visualization of data. (charts and graphs)

Other Nonfunctional Requirements
Performance Requirements
The application will be able to preform its operations with less than 2 second delay in the calculations and under load of multiple users on the application at the same time.

User Requirements: 
Windows
OS Compatibility: Windows XP, Windows Vista, Windows 7, or Windows 8.x
128 MB of RAM
Mac
OS Compatibility: Mac OS X 10.4 or higher, Mac OS X Leopard
256 MB of RAM
Server Requirements:
Linux:
OS Compatibility: Linux kernel 2.2.14 or higher
The following libraries or services:
PHP 5
mysql-server
httpd
256 MB of RAM
Safety Requirements
Giving out an email address to anyone always carries some amount of risk. Worst case someone succeeds in getting the user list from the site. To prevent SQL injection measures will be taken. see section 5.3
Security Requirements
User and Administer passwords will be stored hashed in the database. All queries to the database will be done using PDO to avoid SQL injection.
Software Quality Attributes
Reliability
The application will provide the most reliable data possible and give consistent results. 
Availability
The availability of the application is entirely dependent on the final server platform used for hosting, along with access to the database.
Maintainability
The coding practices used in this project are to be industry standard to that others after this team can maintain that code base. 
the database data can be maintained and updated from the administrators section.
Portability
The application is a web application that will be scalable to phones and tablets and usable on the most popular browsers.
Business Rules
Administrative users will have the ability to manage the phage data and update the database easily and will be limited to persons on ULM campus or other trusted individuals.

Appendix A: Glossary
P.E.T. v2.0 - Phage Enzyme Tool version 2.0
ULM - University of Louisiana at Monroe
HHMI - Howard Hues Medical Institute
User - anyone who has registered for an account to use P.E.T. v2.0
User Admin (UA) or Administrator - an individual(s) who is responsible for the moderation of incoming/outgoing data and user access levels and privileges
General User (GU) - a non-admin user of P.E.T v2.0
PHP Data Objects (PDO) - server-side code that isn’t visible to the user
MVC - Model View Controller  
Appendix B: Analysis Models
Data Flow Diagram for MVC architecture:


Page Request from Users Browser to Sever
The invoked controller calls a model’s method to get/input data
The Model Queries the database
The database returns data or a confirmation of transaction to the model 
The model formats the data and passes it back to the requesting controller
The controller inserts the formatted data into a view. 
The content in the view is then passed back to the controller 
The controller serves the new dynamically built web page to the browser. 



Use case Diagram:

Appendix C: Use Cases
User
Register User: The registrant will enter information about themselves including required fields denoted by an asterisk; things like email, and first/last name and perhaps institution if made to be available exclusively through an educational foundation.
View current data: After completing user account registration, and granted access into the site, the user will be able to access all current phage and/or enzyme data that they choose within the limits of the P.E.T. v2.0 range of operation. Current data will also include recent news about changes to the site, which may or may not happen very frequently. However, and data changes site-wide will be displayed within the ‘News’ portion of the web-site.
Save session data: Any data generated from a user work session may be preserved by the user to the database with a limit of one save per user.
Export session data: Any data generated from a user work session may be downloaded by the user to their local machine’s hard disk drive in .txt file to the destination of their choosing.
User Admin
View current data: After completing UA log-in, and granted access into the site, the UA will be able to access all current phage and/or enzyme data that they choose within the limits of the P.E.T. v2.0 range of operation. Current data will also include recent news about changes to the site, which may or may not happen very frequently. However, and data changes site-wide will be displayed within the ‘News’ portion of the web-site.
View registrants: The User Admin may choose to view the list of active users of the P.E.T. v2.0 application. While in this view, the UA will have the option to change general user settings individually, thereby having the ability to ban certain users from the site or adversely grant them additional privileges per the needs of the situation. 
Edit phage/enzyme data: The UA will also have the ability to alter any phage or enzyme data associated with the site’s P.E.T. v2.0 application. This will include any information associated with individual phages, their clusters/sub-clusters, and enzymes and the cut ranges associated with them. After any and all changes have been made, the UA will be able to save the current state of the database and publish the changes made at will after completion
Appendix D: To Be Determined List
(1)  Set User Preferences
(2) Display Phylip generated phylogeny or restriction enzyme cut counts of known phage DNA (both rooted and unrooted)
(3) Access visualizations of cut location data of Known Phages
