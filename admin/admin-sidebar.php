<?php

$sql1 = "SELECT COUNT(`ID`) FROM authors";
$sql2 = "SELECT COUNT(`ID`) FROM books";
$sql3 = "SELECT COUNT(`ID`) FROM category";
$sql4 = "SELECT COUNT(`ID`) FROM messages WHERE `status` = 0";

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);

while($row = mysqli_fetch_assoc($result1)) {
	$author_count = $row['COUNT(`ID`)'];
}
while($row = mysqli_fetch_assoc($result2)) {
	$book_count = $row['COUNT(`ID`)'];
}
while($row = mysqli_fetch_assoc($result3)) {
	$category_count = $row['COUNT(`ID`)'];
}
while($row = mysqli_fetch_assoc($result4)) {
	$awaiting_messages = $row['COUNT(`ID`)'];
}
?>
<ul class="widget widget-menu unstyled">
	<li class="active">
		<a href="index.php">
			<i class="menu-icon icon-home"></i>
			Dashboard
		</a>
	</li>
	<li>
		<a href="message.php">
			<i class="menu-icon icon-inbox"></i>
			Messages
			<b class="label green pull-right"><?php echo $awaiting_messages; ?></b>
		</a>
	</li>
	<li>
		<a href="authors.php">
			<i class="menu-icon icon-user"></i>
			Authors
			<b class="label green pull-right"><?php echo $author_count; ?></b>
		</a>
	</li>
	<li>
		<a href="books.php">
			<i class="menu-icon icon-book"></i>
			Books
			<b class="label green pull-right"><?php echo $book_count; ?></b>
		</a>
	</li>
	<li>
		<a href="categories.php">
			<i class="menu-icon icon-tasks"></i>
			Categories
			<b class="label orange pull-right"><?php echo $category_count; ?></b>
		</a>
	</li>
</ul>
<!--/.widget-nav-->


<ul class="widget widget-menu unstyled">
	<li>
		<a class="collapsed" data-toggle="collapse" href="#togglePages">
			<i class="menu-icon icon-cog"></i>
			<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
			More Pages
		</a>
		<ul id="togglePages" class="collapse unstyled">
			<li>
				<a href="admin-profile.php">
					<i class="icon-inbox"></i>
					Profile
				</a>
			</li>
			<li>
				<a href="other-user-listing.php">
					<i class="icon-inbox"></i>
					All Users
				</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="logout.php">
			<i class="menu-icon icon-signout"></i>
			Logout
		</a>
	</li>
</ul>