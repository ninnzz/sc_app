<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Eduligne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Eduligne School Interface">
    <meta name="author" content="ninz">


    <title>Eduligne :: Portal</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">

    <script type="text/javascript" src="/js/jquery.min.js"></script>
      

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  <script type='text/javascript'>
    var current_service = null;
    var current_domain = null;
    var current_activity = null;
  </script>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand dropdown-toggle" href="#" data-toggle="dropdown">Eduligne :: Budget</a>
      <ul class="dropdown-menu">
        <li><a href="#">Budget</a></li>
        <li><a href="#">Stages</a></li>
        <li><a href="#">Notes & C.C.F.</a></li>
        <li><a href="#">Communication</a></li>
      </ul>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Table Board</a></li>
        <li><a href="#about">Qoutation</a></li>
        <li><a href="#contact">Control</a></li>
        <li><a href="#contact">Contracts</a></li>
        <li><a href="#contact">Demands</a></li>
        <li><a href="#contact">Products</a></li>
        <li><a href="#contact">Provider</a></li>
        <li><a href="#contact">Stocks</a></li>
        <li><a href="#contact">Sales</a></li>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->uname;?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li class="divider"></li>
            <li><a href="/logout">Logout</a></li>
          </ul>
        </li>
        <li><a href="#"><img src="http://icons.iconarchive.com/icons/aha-soft/people/256/user-group-icon.png" width=20 /></a></li>
      </ul>
    </div><!--/.navbar-collapse -->
  </div>
</div>
    