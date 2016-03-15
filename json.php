<?php
// copy file content into a string var
$json_file = file_get_contents('posts.json');
// convert the string to a json object
$jfo = json_decode($json_file);
// read the title value
$title = $jfo->result->title;
// copy the posts array to a php var
$posts = $jfo->result->posts;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>How to parse JSON file with PHP</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="container">
<div class="header">
<img src="images/BeWebDeveloper.png" />
</div><!-- header -->
<h1 class="main_title"><?php echo $title; ?></h1>
<div class="content">
<ul class="ul_json clearfix">
<?php
foreach ($posts as $post) {
?>
<li>
<a href="<?php echo $post->link; ?>">
<h2><?php echo $post->title; ?></h2>
<img src="<?php echo $post->img; ?>">
</a>
</li>
<?php
} // end foreach
?>
</ul>
</div><!-- content -->
<div class="footer">
Powered by <a href="http://www.bewebdeveloper.com">bewebdeveloper.com</a>
</div><!-- footer -->
</div><!-- container -->
</body>
</html>