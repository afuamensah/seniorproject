# Herdr
This was the website I created my senior project by the name of Herdr. Herdr is a roommate-finding app for students at Lipscomb University. I focused on the administration side, where admins can accept/deny roommate match requests, and view/take action on student reports.

### PHP folder
Consists of the php files coded. 13 out of the 18 pages are static webpages used to display the information. 

#### index.php
Login page for the website.

#### dashboard.php
Accessed once login is successful. Displays new matches and reports. Has a sidebar of navigations and a button to log out at any time.

#### matches.php
Full list of checked and unchecked match requests. Clicking on each student will reveal basic details about the student. There are buttons to confirm or deny match requests on each request if unchecked. If checked, a confirmed or denied status is displayed. Complete with a search bar to search through reports based on the student's ID number.

#### profile.php
Details about the student (once link on matches.php page is clicked). There is a button to go back to the matches center.

#### reports.php
Full list of checked and unchecked reports on students. There is a button to view the details of the report, which is required in order to take further action. Complete with a search bar to search through reports based on the student's ID number.

#### report-details.php
Details about a single report, including reason. If no action has been taken, there are buttons to warn and suspend a student based on the admin' discretion.

#### mresults.php, rresults.php
Displays match results or report results based on the ID inputted.

#### help.php
Gives guidelines for the admin to navigate the web app easily.

#### email-config.php
Used to set what email the automated emails are coming from. The email in this file is set to 'herdrcontact@gmail.com'.

#### SMTP.php, PHPMailer.php, Exception.php
Pulled from AWS. I used their Simple Email Service in order to send automated emails and added these files into my web app.

#### dbconnect.php
Area to put your database information, including hostname, username, password, and database name. All of these are required in order for the connection to work. Default is set to localhost with 'root' as username and an empty value as password.


### IMG folder
Houses all the images used for the web app, including the logo.

### CSS folder
Consists of the **style.css** file, which was coded to style the web app.

### JS folder
consists of the **function.js** file, which was coded to run the help (help.php) page of the web app.

<br/>

***This web app needs a web server (such as Apache or Nginx) and a MySQL database with the same table and attribute names in order for it to work.***

- I use the XAMPPP stack: https://www.apachefriends.org/index.html
