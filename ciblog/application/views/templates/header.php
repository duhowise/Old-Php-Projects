<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ci Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/style.css">
    <script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="navbar navbar-inverse">
   <div class="container">
       <div class="navbar-header">
           <a class="navbar-brand" href="<?=base_url();?>">Ci Blog</a>
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
           </ul>
       </div>
   </div>
</div>

<div class="container">

