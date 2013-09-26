<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Eduligne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Eduligne School Interface">
    <meta name="author" content="ninz">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/signin.css">
   
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method='post' action='/login/auth'>
        <h2 class="form-signin-heading">Eduligne :: Login</h2>
        <input type="text" class="form-control" name='username' placeholder="Username" autofocus>
        <input type="password" class="form-control" name='password' placeholder="Password">
        <input type="text" class="form-control" name='school_code' placeholder="School Code">
        <br/>
        <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
      	<div style='text-align:center;'>
      		<a href='#'>Forgot Password</a> | <a href='/user/register'>New User</a>
      	</div>
        <br/>

      	<?php
			if(isset($response->message)){
		?>
			<span style='color:#E33D3D;'>
				<?php
					echo '***'.$response->message;
				?>
			</span>
		<?php } ?>
      </form>
    </div> <!-- /container -->
<?php
	$this->load->view('includes/footer');
?>