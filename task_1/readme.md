# Task 1

  The following notes are based on the code review of the provided original.php 


  Lines # / Remarks
  
  2. mysql_connect / mysql_select_db are pare of the old mysql extension which is deprecated - its actually
     completely removed in PHP version 7. Solution is to use mysqli or PDO instead.
  4. unsanitized user input is later being used as is to build a query - its an SQL injection waiting to happen.
  5. unsafe variable $id was used as is from $_GET - also building a query by string concatenation can lead to problems.
     in this particular case a quick fix would be to cast $id into an int at line 4 or use mysql_real_escape_string. The
     best solution though would be to use a prepared statement (supported by both mysqli and PDO) to bind the parameter.
  6. I assume id is the primary key in the newsletters table which means at most one result will be returned from the
     query making the while loop redundant. could be replaced with an if statement.
  9. unvalidated $_GET['id'] is used for output to user's browser. Can be exploited via XSS.
     $_SERVER['PHP_SELF'] is also vulnerable to XSS (a malicious user may concatenate a script tag on the URL which will
     then get executed in the browser). 
  
  There is also no checking if a row was actually retrieved - if not a blank page will show up without the user knowing what went wrong


You can find the corrected version in revised.php   