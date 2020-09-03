<?php

session_start();
require_once 'util.php';
require_once 'pdo.php';

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['delete']) ) {
    $_SESSION['delete'] = true;
    header('Location: delete.php?profile_id=' . $_REQUEST["profile_id"]);
    return;
}

if (isset($_REQUEST['profile_id']))
{
    $profile_id = htmlentities($_REQUEST['profile_id']);

    if (isset($_SESSION['delete']))
    {
        $stmt = $pdo->prepare("
            DELETE FROM profile
            WHERE profile_id = :profile_id
        ");

        $stmt->execute([
            ':profile_id' => $profile_id,
        ]);

        $stmt = $pdo->prepare("
            DELETE FROM position
            WHERE profile_id = :profile_id
        ");

        $stmt->execute([
            ':profile_id' => $profile_id,
        ]);

        $_SESSION['success'] = 'Record deleted';

        unset($_SESSION['delete']);

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
        <title>Akula Taraka Mani Ravi Teja's</title>
      <?php  require_once 'head.php'; ?>
        <style type="text/css">
            form {margin-top: 20px;}
        </style>
    </head>
    <body>
        <div class="container">

            <h1>Deleteing Profile</h1>

            <div class="row">
                <div class="col-sm-2">
                    First Name:
                </div>
                <div class="col-sm-3">
                    <?php echo $profile->first_name; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    Last Name:
                </div>
                <div class="col-sm-3">
                    <?php echo $profile->last_name; ?>
                </div>
            </div>

            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-4">
                        <input type="hidden" name="profile_id" value="<?php echo $profile->profile_id; ?>">
                        <input class="btn btn-primary" type="submit" name="delete" value="Delete">
                        <input class="btn btn-default" type="submit" name="cancel" value="Cancel">
                    </div>
                </div>
            </form>

            <script type="text/javascript">
                function confirmDelete()
                {
                    var delProfile = confirm('Are you sure you want to delete this profile?');

                    if (delProfile)
                    {
                        return true;
                    }

                    return false;
                }
            </script>

        </div>
    </body>
</html>
