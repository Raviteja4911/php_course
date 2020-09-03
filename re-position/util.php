<?php

function flashmessage()
{
  if(isset($_SESSION['error']))
  {
    echo '<p style="color:red;class="col-sm-10 col-sm-offset-2";">'.htmlentities($_SESSION['error']).'</p>';
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['success']))
  {
    echo '<p style="color:green;class="col-sm-10 col-sm-offset-2";">'.htmlentities($_SESSION['success']).'</p>';
    unset($_SESSION['success']);
  }
}

function validprofile()
{
  if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1)
    {
        $_SESSION['error'] = "All values are required";
        return false;
    }
    for ($i=1; $i<=9; $i++)
    {
    	if ( ! isset($_POST['year'.$i]) ) continue;
		if ( ! isset($_POST['desc'.$i]) ) continue;

		$year = htmlentities($_POST['year'.$i]);
		$desc = htmlentities($_POST['desc'.$i]);

    	if (strlen($year) < 1)
    	{
    		$_SESSION['error'] = "All values are required";
    		return false;
    	}

	    if (strlen($desc) < 1)
	    {
			$_SESSION['error'] = "All values are required";
        	return false;
	    }

	    if(!is_numeric($year))
    	{
    		$_SESSION['error'] = "Position year must be numeric";
    		return false;
    	}
    }

    if (strpos($_POST['email'], '@') === false)
    {
        $_SESSION['error'] = "Email address must contain @";
        return false;
    }

    return true;
}

function validatePos() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['desc'.$i]) ) continue;

    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];
    if ( ! is_numeric($year) ) {
      return "Position year must be numeri";
    }
    if ( strlen($year)==0  || strlen($desc) == 0 ) {
      return "All values are required";
    }


  }
  return true;
}
?>
