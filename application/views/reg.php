<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Eduligne :: Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Eduligne School Interface">
    <meta name="author" content="ninz">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/reg.css">
   
    <script type='text/javascript'>
      function checkFields(){
        err = document.getElementById('err');   
        uname = document.getElementById('uname').value;   
        pss = document.getElementById('password').value;   
        pssc = document.getElementById('passwordc').value;   
        sc_code = document.getElementById('school_code').value;   
        role = document.getElementById('role').value;   
        if(uname != ""){
          if(pss != "" && pssc == pss){
            if(sc_code != ""){
              return true;
            } else{
              err.innerHTML = "**Invalid school code";
              return false;
            }
          } else{
            err.innerHTML = "**Password must match";
            return false;
          }
        } else{
          err.innerHTML = "**Invalid username";
          return false;
        }
      }
    </script>
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action='/user/register' method='post' onsubmit="return checkFields();">
        <h2 class="form-signin-heading">Registration</h2>
        <label> Username:</label>
          <input type="text" name='uname' id='uname' class="form-control" autofocus>
        <br/>
        <label> Password:</label>
          <input type="password" name='password' id='password' class="form-control">
        <br/>
        <label> Confirm Password:</label>
          <input type="password" name='passwordc' id='passwordc' class="form-control">
        
        <br/>
        <label> School Code:</label>
          <input type="text" name='school_code' id='school_code' class="form-control">
        
        <br/>
        <label> Role:</label>
          <select class='form-control' name='role' id='role'>
            <option value='director'>Director</option>
            <option value='cheif_of_work'>Cheif of Work</option>
            <option value='steward'>Steward</option>
            <option value='accounting_manager'>Accounting Manager</option>
          </select>
        <br/>
        <br/>
        <input class="btn btn-lg btn-success btn-block" type="submit"  value='Register User'/>
        <br/>
        <div style='text-align:center;'>
          <a href='/'>Back</a>
        </div>
        <input type="hidden" name='reg' value='1' class="form-control" />
       <span style='color:#E33D3D;' id='err'>

        <?php
      if(isset($response->message)){
        ?>
				<?php
					echo '***'.$response->message;
				?>
    <?php } ?>
			</span>
      </form>
    </div> <!-- /container -->
<?php
	$this->load->view('includes/footer');
?>