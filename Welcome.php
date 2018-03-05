<?
include "UtilityFunctions.php";

$values = $_GET["values"];
$SessionId = $_GET["SessionId"];
$UserId = $_GET["UserId"];
$CurURL = "http://www.comsc.uco.edu/~gq011/Welcome.php?SessionId=" . $SessionId . "&UserId=" . $UserId;

verify_session($SessionId);


$sql = "select Name, Type from Users " .
       "where UserId ='$UserId' ";
	   
$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

$values = oci_fetch_array ($cursor);
oci_free_statement($cursor);

$Name = $values[0];
$Type = $values[1];

// Here we can generate the content of the welcome page
echo("<h2>Welcome $Name!</h2>");

if($Type == "s_admin" || $Type == "admin"){
	echo("<h2>Admin Menu:</h2>");
	echo("<FORM name=\"UserManagement\" method=\"post\" action=\"UserManagement.php?SessionId=$SessionId&UserId=$UserId\"> 
		  <INPUT type=\"hidden\" name=\"PrevURL\" value=$CurURL>
		  <INPUT type=\"submit\" name=\"UserManagement\" value=\"User Management\" style=\"height:25px; width:150px\"> 
		  </FORM>");
	  
	echo("<FORM name=\"StudentManagement\" method=\"post\" action=\"StudentManagement.php?SessionId=$SessionId\"> 
		  <input type=\"hidden\" name=\"SessionId\" value=$SessionId>
		  <INPUT type=\"submit\" name=\"StudentManagement\" value=\"Student Management\" style=\"height:25px; width:150px\"> 
		  </FORM>");

	echo("<br />");
	echo("<br />");
}

if($Type == "s_admin" || $Type == "student"){
	echo("<h2>Student Menu:</h2>");
	echo("Not implemented yet");  

	echo("<br />");
	echo("<br />");
}


echo("<FORM name=\"ChangePassword\" method=\"post\" action=\"ChangePassword.php?SessionId=$SessionId\"> 
	  <h2>Change Password</h2>
	  New Password:  <INPUT type=\"password\" name=\"NewPassword\" size=\"8\" maxlength=\"8\"> <br />
	  <INPUT type=\"hidden\" name=\"PrevURL\" value=$CurURL>
	  <INPUT type=\"submit\" name=\"ChangePassword\" value=\"Change Password\"> 
	  </FORM>");

echo("<br />");
echo("<br />");

echo("<FORM name=\"Logout\" method=\"post\" action=\"LogoutAction.php?SessionId=$SessionId\"> 
	  <input type=\"hidden\" name=\"SessionId\" value=$SessionId>
	  <INPUT type=\"submit\" name=\"Logout\" value=Logout> 
	  </FORM>");
?>

