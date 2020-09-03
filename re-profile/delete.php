<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
	die("ACCESS DENIED");
}

try
{
    $pdo = new PDO("mysql:host=localhost;dbname=misc", "root", "root");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}

if (isset($_REQUEST['profile_id']))
{
    $profile_id = htmlentities($_REQUEST['profile_id']);

    if (isset($_POST['delete']))
    {
        $stmt = $pdo->prepare("
            DELETE FROM profile
            WHERE profile_id = :profile_id
        ");

        $stmt->execute([
            ':profile_id' => $profile_id,
        ]);

        $_SESSION['status'] = 'Record deleted';
        $_SESSION['color'] = 'green';

        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM profile
        WHERE profile_id = :profile_id
    ");

    $stmt->execute([
        ':profile_id' => $profile_id,
    ]);

    $profile = $stmt->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Akula Taraka Mani Ravi Teja profiles</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">

            <p>
                Confirm: Deleting <?php echo $profile->make; ?>
            </p>

            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <input class="btn btn-primary" type="submit" name="delete" value="Delete">
                        <a class="btn btn-default" href="index.php">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
