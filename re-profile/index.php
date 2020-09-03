<?php

session_start();
if(!isset($_SESSION['name'])){
$logged_in=false;
}
else{
$logged_in = $_SESSION['logged_in'];
}
$profiles = [];

if (isset($_SESSION['name']) )
{
	$status = false;

	if ( isset($_SESSION['status']) )
	{
		$status = htmlentities($_SESSION['status']);
		$status_color = htmlentities($_SESSION['color']);

		unset($_SESSION['status']);
		unset($_SESSION['color']);
	}

	try
	{
	    $pdo = new PDO("mysql:host=localhost;dbname=misc", "root", "root");
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $all_profiles = $pdo->query("SELECT * FROM profile");

		while ( $row = $all_profiles->fetch(PDO::FETCH_OBJ) )
		{
		    $profiles[] = $row;
		}
	}
	catch(PDOException $e)
	{
	    echo "Connection failed: " . $e->getMessage();
	    die();
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Akula Taraka Mani Ravi Teja's Resume Registry</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<h1>Akula Taraka Mani Ravi Teja's Resume Registry</h1>

			<?php if (!$logged_in) : ?>
				<p>
					<a href="login.php">Please log in</a>
				</p>
      <?php else: ?>
        <p>
					<a href="logout.php">logout</a>
				</p>
      <?php endif; ?>
				<?php
	                if ( $status !== false )
	                {
	                    // Look closely at the use of single and double quotes
	                    echo(
	                        '<p style="color: ' .$status_color. ';">'.
	                            $status.
	                        "</p>\n"
	                    );
	                }
	            ?>
				<?php if (empty($profiles)) : ?>
					<p>No rows found</p>
				<?php else : ?>
					<div class="row">
						<div class="col-md-8">
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Headline</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($profiles as $profile) : ?>
				                        <tr>
				                        	<td>
				                        		<a href="view.php?profile_id=<?php echo $profile->profile_id; ?>">
				                        			<?php echo $profile->first_name . ' ' . $profile->last_name; ?>
				                        		</a>
				                        	</td>
											<td><?php echo $profile->headline ?></td>
											<td>
												<a href="edit.php?profile_id=<?php echo $profile->profile_id; ?>">
													Edit
												</a> /
												<a href="delete.php?profile_id=<?php echo $profile->profile_id; ?>">
													Delete
												</a>
											</td>
				                        </tr>
				                    <?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				<?php endif; ?>
        <?php if($logged_in): ?>

				<p>
					<a href="add.php">Add New Entry</a>
				</p>

        
          	<?php endif; ?>
		</div>
	</body>
</html>
