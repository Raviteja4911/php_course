
<?php
session_start();
require_once 'pdo.php';
require_once 'util.php';
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']))
{
  validprofile();
    if(!validprofile())
    {
        header("Location: add.php");
        return;
    }
$stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)');

$stmt->execute(array(
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['first_name'],
  ':ln' => $_POST['last_name'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
);

$profile_id = $pdo->lastInsertId();

if(!validatePos())
{
  $_SESSION['error'] = "All values are required";
header('Location: add.php');
return;
}
else{
    $rank = 1;
    for ($i=1; $i<=9; $i++)
    {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;

        $year = htmlentities($_POST['year'.$i]);
        $desc = htmlentities($_POST['desc'.$i]);

        $stmt = $pdo->prepare("
            INSERT INTO position (profile_id, rank, year, description)
            VALUES (:profile_id, :rank, :year, :description)
        ");

        $stmt->execute([
            ':profile_id' => $profile_id,
            ':rank' => $rank,
            ':year' => $year,
            ':description' => $desc,
        ]);

        $rank++;

    }
        $_SESSION['success'] = 'record added';

        header('Location: index.php');
    	return;
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Akula Tarak Mani Ravi Teja's Profile Add</title>
<?php require_once 'head.php';?>
</head>

<body>
<div class="container">
<h1>Adding Profile for UMSI</h1>
<?php flashmessage() ?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
Position: <input type="submit" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
<script>
countPos = 0;


$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});
</script>
</div>
</body>
</html>
