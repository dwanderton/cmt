<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo get_bloginfo( 'description' ); ?>"/>
    <meta name="keywords" content="translation,industry,industrial,engineering,construction,Italian,French,Spanish,English,Interpreting,teaching,subtitles,dubbing,experienced,technical,book and ebook translation">
    <meta name="author" content="CM Translations">

    <title><?php echo wp_title('|', true, 'right') ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,400italic|Work+Sans:300,400,500,600' rel='stylesheet' type='text/css'>
    <link href="<?php bloginfo('template_directory'); ?>/assets/css/toolkit-startup.css" rel="stylesheet">
    <link href="<?php bloginfo('template_directory'); ?>/assets/css/application-startup.css" rel="stylesheet">  

    <style>
      /* note: this is a hack for ios iframe for bootstrap themes shopify page */
      /* this chunk of css is not part of the toolkit :) */
      /* …curses ios, etc… */
      @media (max-width: 768px) and (-webkit-min-device-pixel-ratio: 2) {
        body {
          width: 1px;
          min-width: 100%;
          *width: 100%;
        }
        #stage {
          height: 1px;
          overflow: auto;
          min-height: 100vh;
          -webkit-overflow-scrolling: touch;
        }
      }
    </style>
    <?php wp_head(); ?>
  </head>


<body>
  
<div class="stage-shelf stage-shelf-right hidden" id="sidebar">
  <ul class="nav nav-bordered nav-stacked flex-column">
    <li class="nav-header">On this page:</li>
    <li class="nav-item">
      <a class="nav-link" href="#services" data-target=".stage" data-toggle="stage">Services</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#languages" data-target=".stage" data-toggle="stage">Languages</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#contact" data-target=".stage" data-toggle="stage">Contact</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#requestAQuotation" data-target=".stage" data-toggle="stage">Request a Quotation</a>
    </li>
  </ul>
</div>

<div class="stage" id="stage">

