<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css" />
	<title><?=$this->title?></title>
</head>
<body>
<nav class="menu">
	<ul>
		<?php foreach ($this->getMenu() as $text => $link) {
					echo "<li><a href=\"$link\">$text</a></li>";
				}
		?>
	</ul>
</nav>
<h3 class="feedback"><?=$this->feedback?></h3>	
	<h1><?=$this->title?></h1>
		<?=$this->content?>
<!-- <div class="pageHead">
			<ul>
				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">The Sun</figcaption>
						<?php echo "<a href='#'>"?><img id="sun" src="images/index1.jpeg" alt="sun"></a>
					</figure>
				</li>

				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">Mercury</figcaption>
						<?php echo "<a href='#'>"?><img id="mercury" src="images/index2.jpeg" alt="mercury"></a>
					</figure>
				</li>

				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">Venus</figcaption>
						<?php echo "<a href='#'>"?><img id="venus" src="images/index3.jpeg" alt="Venus"></a>
					</figure>
				</li>
				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">Venus</figcaption>
						<?php echo "<a href='#'>"?><img id="venus" src="images/index3.jpeg" alt="Venus"></a>
					</figure>
				</li>
				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">Venus</figcaption>
						<?php echo "<a href='#'>"?><img id="venus" src="images/index3.jpeg" alt="Venus"></a>
					</figure>
				</li>
				<li>
					<figure class = "rotatingcomputers">
						<figcaption class="computer_captions">Venus</figcaption>
						<?php echo "<a href='#'>"?><img id="venus" src="images/index3.jpeg" alt="Venus"></a>
					</figure>
				</li>
			</ul>
</div> -->

</body>
</html>