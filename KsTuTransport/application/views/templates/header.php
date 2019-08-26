<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KsTu Transport<?=' - '.$title?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/solar/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/style.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="navbar navbar-inverse">
   <div class="container">
       <div class="navbar-header">
           <a class="navbar-brand" href="<?=base_url();?>">KsTU Transport</a>
       </div>
       <div id="navbar">
           <ul class="nav navbar-nav">
               <li class="active"><a href="<?=base_url();?>">Home</a></li>
               <li><a href="<?=base_url();?>about">About</a></li>
               <li><a href="<?=base_url();?>posts">Blog</a></li>
               <li><a href="<?=base_url();?>categories">Categories</a></li>
           </ul>
           <ul class="nav navbar-nav navbar-right">
               <li><a href="<?=base_url();?>posts/create">New Post</a></li>
               <li><a href="<?=base_url();?>categories/create">New category</a></li>
               <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#mymodal"  role="button" aria-haspopup="true" aria-expanded="false">login <span class="caret"></span></a>

               </li>
           </ul>
       </div>
   </div>
</div>

<div class="container">

