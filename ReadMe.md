MakerSpace Manager - BETA


MakerSpace Manager is a facility, credential, and member management application tailored to the unique needs of makerspaces.  This software is currently in beta, and some functionalities may not yet be fully implemented.  For a list of features known to not be fully implemented please see the section “Features Under Current Development” at the end of this document.  The project is under continued development and this document will be updated as changes are made.  




Installation:  


MakerSpace Manager uses a client/server architecture and is designed to be run on a web server and accessed via a browser on a client machine.  As a web app, MSM relies on the LAMP (Linux, Apache, Mysql, PHP) stack to function.  MSM was built against MySQL 5.5, PHP 5.6, Apache 2.4, and Ubuntu 14.04.  Theoretically all components of the system should work with any later version, but we make no guarantee this is actually the case.  


Once you have cloned or downloaded the git repository, place the MSM directory in the www directory of your Apache installation.  Log into your MySQL installation and create a new database named “members.”  Create a username and password that can be used by the MSM application and grant it all privileges (other than grant) on the members database.  Open the file src/classes/dbCore.php in the MSM directory and fill the hostname, username and password you created for the application into lines 17 - 19; you will need to replace the test data that is prefilled in here.  


Navigate via command line to the “sql” directory of the MSM application.  In the sql directory you will find two mysql dump files “members_db.sql” and “members_db_clean.sql.”  Both these files contain the data to create the required tables and views for the MSM application.  The members_db_clean.sql will create empty tables while members_db.sql contains dummy data.  If you are evaluating MSM for use and want to be able to immediately test all functions, use the members_db.sql file as the test data contained within it will allow for evaluation and use of all functions of the program without the need to create your own test data.  If you plan to put the system into production, opt for the members_db_clean.sql file.  To use the dump file to create the members database enter the following command from the sql directory of the MSM application:


mysql -u [userName] -p[passWord] members < members_db[_clean].sql


WARNING!  DO NOT USE MAKERSPACE MANAGER ON A PUBLIC FACING WEB SERVER!
As of this writing no access control has been implemented in the MSM application.  This means anyone who can access the server will have full access to any data stored in your instance of MSM.  Just don’t do it.


USE
Once the application is installed in your server’s www directory, the correct databases have been created and the credentials entered into the dbCore.php file, you should be able to access the application by by pointing a web browser with access to the server to the address you set up for the application /msm.php.  So, if MSM were the only application in the www directory, and the folder containing the application were named SpaceManager, you would point your browser to SpaceManager/msm.php to access the application.  If there were no containing directory, you would simply point your browser to msm.php.  




SUPPORT:
MakerSpace Manager is currently in beta, and though we have tried to find and fix as many bugs as possible during the alpha testing, there will inevitably be some that we missed.  Bug reports should be directed to the project’s github issues page:


https://github.com/stiles-j/msm_beta/issues


Requests for support can be directed to MakerSpaceManager@gmail.com  However, please note this project is currently an all volunteer effort with no funding.  Though we will make an attempt to help resolve issues in a timely manner, we cannot guarantee that we will be able to resolve your issue or that it will in fact be in any particular time-frame when we do.  Additionally, this email address is for support that is specific to MakerSpace Manager; we cannot offer support for other software, including that which MSM is built on such as the LAMP stack.  


FEATURES UNDER CURRENT DEVELOPMENT:


2014/07/03:  The reporting module is under development.  Though the UI is fully implemented, and in fact uses AJAX to make queries to the database to fully define the parameters of a requested report, no report will currently return a result.  Rather, all reports will return a message stating “This Report Coming Soon” and a dump of the data entered by the user.