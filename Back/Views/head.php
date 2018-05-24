<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $arr['title'];?></title>

  <style>
  html{background-color:#E3E3E3; font-size:14px; color:#000; font-family:'微软雅黑'}
  a,a:hover{ text-decoration:none;}
  pre{font-family:'微软雅黑'}
  .box{padding:20px; background-color:#fff; margin:50px 100px; border-radius:5px;}
  .box a{padding-right:15px;}
  #about_hide{display:none}
  .layer_text{background-color:#fff; padding:20px;}
  .layer_text p{margin-bottom: 10px; text-indent: 2em; line-height: 23px;}
  .button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
  .photos-demo img{width:200px;}
  </style>
  
  <script src="pubilc/jquery-3.3.1.min.js"></script>
  <script src="layer/layer.js"></script>
</head>
<body>
