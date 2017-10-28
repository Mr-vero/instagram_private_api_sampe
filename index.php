<?php 
	set_time_limit(0);
	date_default_timezone_set('UTC');
	require 'vendor/autoload.php';
 ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Instagram Uploader</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="author" href="humans.txt">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    </head>
    <body>
        
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Insta Destkop</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<!-- <ul class="nav navbar-nav">
						<li class="active"><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
					</ul>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Link</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</li>
					</ul> -->
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Upload to Instagram</h3>
						</div>
						<div class="panel-body">
							<form action="" method="POST" role="form" enctype="">
								<legend>Fill this form</legend>
							
								<div class="form-group">
									<label for="">username</label>
									<input type="text" class="form-control" id="" name="username" placeholder="your username">
								</div>
								<div class="form-group">
									<label for="">password</label>
									<input type="password" class="form-control" id="" name="password" placeholder="your password">
								</div>
								<div class="form-group">
									<label for="">picture</label>
									<input type="file" name="picture" class="picture form-control">
								</div>
								<div class="form-group">
									<label for="">caption</label>
									<textarea name="caption" id="caption" cols="30" rows="10" class="form-control"></textarea>
								</div>
							
								
								<button type="submit" name="upload" class="btn btn-primary">Upload</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

        <script src="js/main.js"></script>
    </body>
</html>

<?php 
	if (isset($_POST['upload'])) {
		// get all the variables 



		/////// CONFIG ///////
		$username = htmlentities($_POST['username']);
		$password = htmlentities($_POST['password']);
		$debug = false;
		$truncatedDebug = false;
		//////////////////////

		/////// MEDIA ////////
		$photoFilename = 'picture/'.$_POST['picture'];
		$captionText = htmlentities($_POST['caption']);
		//////////////////////

		$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

		try {
		    $ig->login($username, $password);
		} catch (\Exception $e) {
		    echo 'Something went wrong: '.$e->getMessage()."\n";
		    exit(0);
		}

		try {
		    // The most basic upload command, if you're sure that your photo file is
		    // valid on Instagram (that it fits all requirements), is the following:
		    // $ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);

		    // However, if you want to guarantee that the file is valid (correct format,
		    // width, height and aspect ratio), then you can run it through our
		    // automatic media resizer class. It is pretty fast, and only does any work
		    // when the input image file is invalid, so you may want to always use it.
		    // You have nothing to worry about, since the class uses temporary files if
		    // the input needs processing, and it never overwrites your original file.
		    // Also note that it has lots of options, so read its class documentation!
		    $resizer = new \InstagramAPI\MediaAutoResizer($photoFilename);
		    $ig->timeline->uploadPhoto($resizer->getFile(), ['caption' => $captionText]);
		    echo '<center><b>Success uploading picture</b></center>';
		    
		} catch (\Exception $e) {
		    echo 'Something went wrong: '.$e->getMessage()."\n";
		}
	}
 ?>