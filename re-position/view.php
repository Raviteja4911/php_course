<?php

session_start();


require_once 'pdo.php';

if (isset($_REQUEST['profile_id']))
{
    $profile_id = htmlentities($_REQUEST['profile_id']);

    $stmt = $pdo->prepare("
        SELECT * FROM profile
        WHERE profile_id = :profile_id
    ");

    $stmt->execute([
        ':profile_id' => $profile_id,
    ]);

    $profile = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt = $pdo->prepare("
        SELECT * FROM position
        WHERE profile_id = :profile_id
    ");

    $stmt->execute([
        ':profile_id' => $profile_id,
    ]);
    while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )
  	{
  			$positions[] = $row;
  	}
 $positionLen = count($positions);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Akula Taraka Mani Ravi Teja Autos</title>
        <?php require_once 'head.php' ?>

        <style type="text/css">
            .row {padding: 5px 0;}
        </style>
    </head>
    <body>
        <div class="container">

            <h1>Profile information</h1>

            <div class="row">
                <div class="col-sm-2">First Name:</div>
                <div class="col-sm-4">
                    <?php echo $profile->first_name; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Last Name:</div>
                <div class="col-sm-4">
                    <?php echo $profile->last_name; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Email:</div>
                <div class="col-sm-4">
                    <?php echo $profile->email; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Headline:</div>
                <div class="col-sm-4">
                    <?php echo $profile->headline; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Last Name:</div>
                <div class="col-sm-8">
                    <?php echo $profile->summary; ?>
                </div>
            </div>

            <?php if($positionLen > 0) : ?>
                <div class="row">
                    <div class="col-sm-2">Positions:</div>
                    <div class="col-sm-8">
                        <ul>
                            <?php for($i=1; $i<=$positionLen; $i++) : ?>
                                <li><?php echo $positions[$i-1]->year; ?>: <?php echo $positions[$i-1]->description; ?></li>

                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <p><a href="index.php">Done</a></p>

        </div>
    </body>
</html>
