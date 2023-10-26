Create a simple 'birthday countdown' script, the script will count the number of days
between current day and birth day


// Firstly create a database with name "loginsystem" and table name "day" in phpmyadmin and the table structure will be like this 
Name		      Type			       Constraints
sno		      int(11)		    	       primary key / AUTO_INCREMENT
name		      varchar(100)		
birthdate	      current_timestamp()	

Use this SQL command to create the table on Mysql
CREATE TABLE `day` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `birthdate` DATE NOT NULL
);


// Create a folder name birthday and place process_form.php, countdown.php and _dbconnect.php files,
when you start XAMPP and open this in browser enter your birthday and name and click submit on "process_form.php" page then you will get a userID keep that in mind now paste "/localhost/birthday/countdown.php " in you browser url and enter your userID to know the remaining days to your next birthday
