<?php
session_start();
require_once 'util.php';
require_once 'pdo.php';
		$all_profiles = $pdo->query("SELECT * FROM profile");

	while ( $row = $all_profiles->fetch(PDO::FETCH_OBJ) )
	{
			$profiles[] = $row;
	}
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>Akula Taraka Mani Ravi Teja's Resume Registry</title>
		<?php  require_once 'head.php'; ?>
	</head>

	<body>
		<div class="container">
			<h1>Akula Taraka Mani Ravi Teja's Resume Registry</h1>
  <?php  flashmessage();
	?>
			<?php if(isset($_SESSION['user_id'])) : ?>
				<p>
					<a href="logout.php">logout</a>
				</p>
      <?php else: ?>
        <p>
					<a href="login.php">Please log in</a>
				</p>
      <?php endif; ?>

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
        <?php if(isset($_SESSION['user_id'])): ?>
				<p>
					<a href="add.php">Add New Entry</a>
				</p>
          	<?php endif; ?>

		</div>
	</body>
</html>
