<?php get_header(); ?>

<div class="stage" id="stage">

<div class="block block-inverse block-fill-height app-header"
     style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/img/startup-1.jpg);">

  <div class="container py-4 fixed-top app-navbar">
  <nav class="navbar navbar-transparent navbar-padded navbar-toggleable-sm">
    <button
      class="navbar-toggler navbar-toggler-right hidden-md-up"
      type="button"
      data-target="#stage"
      data-toggle="stage"
      data-distance="-250">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand mr-auto" href="">
      <strong style="background: #fff; padding: 12px; border-radius: 4px; color: #28669F;">go</strong>
    </a>

    <div class="hidden-sm-down text-uppercase">
      <ul class="navbar-nav">
        <li class="nav-item px-1 ">
          <a class="nav-link" href="#services">Services</a>
        </li>
        <li class="nav-item px-1 ">
          <a class="nav-link" href="#languages">Languages</a>
        </li>
        <li class="nav-item px-1 ">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
        <li class="nav-item px-1 ">
          <a class="nav-link" href="#requestAQuotation">Request a Quotation</a>
        </li>
      </ul>
    </div>
  </nav>
</div>


  <img class="app-graph"  src="<?php bloginfo('template_directory'); ?>/assets/img/startup-0.svg">

  <div class="block-xs-bottom pb-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-10 col-lg-6">
          <h1 class="block-titleData frequency">Translations for Shipping</h1>
          <button class="btn btn-primary btn-lg">Request Your Quote</button>
        </div>
      </div>     
    </div>
  </div>
</div>





<div class="block" id="industries">
  <div class="container text-xs-center">
    <div class="row">
      <div class="col">
        <h1 class="block-titleData frequency">Insdustries</h1>
      </div>
    </div> 
  <?php
    //Still experimenting. This gets last 10 posts and displays it on the industries section of page
    $lastposts = get_posts( array(
        'posts_per_page' => 10
    ) );
     
    if ( $lastposts ) {
        foreach ( $lastposts as $post ) :
            setup_postdata( $post ); ?>
            <div class="row">
              <div class="col-md-5">
                <h6 class="text-muted text-uppercase">Easy development</h6>
              </div>
              <div class="col-md-7">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_content(); ?>
              </div>
            </div>
        <?php
        endforeach; 
        wp_reset_postdata();
    }
  ?>
  </div>
</div>

<div class="block block-secondary app-iphone-block">
  <div class="container">
    <div class="row app-align-center">

      <div class="col-sm-5 hidden-sm-down">
        <img class="app-iphone" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-2.jpg" style="width: 100%;">
      </div>

      <div class="col-md-6 offset-md-1 col-sm-12 offset-sm-0">
        <h6 class="text-muted text-uppercase">Rich Information</h6>
        <h3>Make informed decisions with historical &amp; real time data.</h3>
        <p class="lead mb-4">We combine immediate real time events with rich historical data to help answer the toughest questions about retention, growth, and engagement.</p>
        <div class="row hidden-md-down">
          <div class="col-sm-6 mb-3">
            <h5>Data frequency</h5>
            <p>We poll for data on a millisecond basis. You can react to new information in seconds rather than days. <a href="#" class="text-primary">Learn more.</a></p>
          </div>
          <div class="col-sm-6">
            <h5>Reliability &amp; uptime</h5>
            <p>We process our data across a massively distributed network of reliable servers to ensure 99.99% uptime, always. <a href="#" class="text-primary">Learn more</a>.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="block block-inverse block-secondary app-code-block">
  <div class="container">
    <div class="row app-align-center">
      <div class="col-md-5 push-md-7">
        <pre class="app-code">
<span>1</span> <span>goAnalytics</span> “who are the latest 3 users?”
<span>2</span>
<span>3</span>  {
<span>4</span>    "Dave": {
<span>5</span>      "fullName": "Dave Gamache",
<span>6</span>      "twitterHandle": "@dhg",
<span>7</span>    }
<span>8</span>    "Mark": {
<span>9</span>      "fullName": "Mark Otto",
<span>10</span>      "twitterHandle": "@mdo",
<span>11</span>    }
<span>12</span>    "Jacob": {
<span>13</span>      "fullName": "Jacob Thornton",
<span>14</span>      "twitterHandle": "@fat",
<span>15</span>    }
<span>16</span>  }</pre>
      </div>

      <div class="col-md-6 pull-md-5">
        <h6 class="text-muted text-uppercase">Easy development</h6>
        <h3>Natural language queries make mining data easy for anyone.</h3>
        <p class="lead mb-4 text-muted">Rather than force everyone at your company to learn incredibly difficult terminal commands, we allow anyone to query the data with natural language to return data.</p>
        <button class="btn btn-secondary btn-lg btn-borderless">
          Read our docs
        </button>
      </div>
    </div>
  </div>
</div>

<div class="block block-inverse app-high-praise"
     style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/img/startup-3.jpg);">
    <div class="container">
      <div class="row app-align-center py-3">
        <div class="col-sm-5 push-sm-7 py-5">
          <h6 class="text-muted text-uppercase mb-2"><P></P>raise</h6>
          <h3 class="mb-4">“Go Analytics is amazing. Decisions that used to take weeks, now only takes minutes and is available to everyone on my team.”</h3>
          <p class="mb-4 text-muted">Cindy Smith, founder of Cool Startup</p>
        </div>
      </div>
  </div>
</div>

<div class="block app-ribbon py-5">
  <div class="container text-xs-center">
    <img src="<?php bloginfo('template_directory'); ?>/assets/img/startup-4.svg">
    <img src="<?php bloginfo('template_directory'); ?>/assets/img/startup-5.svg">
    <img src="<?php bloginfo('template_directory'); ?>/assets/img/startup-6.svg">
    <img src="<?php bloginfo('template_directory'); ?>/assets/img/startup-7.svg">
    <img src="<?php bloginfo('template_directory'); ?>/assets/img/startup-8.svg">
  </div>
</div>

<div class="block block-secondary app-block-marketing-grid">
  <div class="container text-xs-center">

      
      <div class="col-xs-10 offset-xs-1 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
        <h6 class="text-muted text-uppercase mb-2">Inside the machine</h6>
        <h3  class="mb-4">It’s not hard to see how we make your life easier every day.</h3>
      </div>
    </div>

    <div class="row app-marketing-grid">
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-9.svg">
        <p><strong>24/7 support.</strong> We’re always here for you no matter what time of day.</p>
      </div>
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-10.svg">
        <p><strong>E-commerce.</strong> We automatically handle all sales analytics.</p>
      </div>
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-11.svg">
        <p><strong>Turnaround.</strong> Our data analysis is distributed, so it processes in seconds.</p>
      </div>
    </div>

    <div class="row app-marketing-grid">
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-12.svg">
        <p><strong>Rich calculations.</strong> Limitless ways to splice and dice your data.</p>
      </div>
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-13.svg">
        <p><strong>Mobile apps.</strong> iOS and Android apps available for monitoring.</p>
      </div>
      <div class="col-md-4 px-4 mb-5">
        <img class="mb-1" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-14.svg">
        <p><strong>Secure connections.</strong> Every single request is routed through HTTPS.</p>
      </div>
    </div>
  </div>
</div>

<div class="block app-price-plans">
  <div class="container text-center">

    <div class="row mb-5">
      <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h6 class="text-muted text-uppercase mb-2">Business Talk</h6>
        <h3>No plans. We just bump your plan whenever you need it.</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 px-4 pb-2 mb-5">
        <div class="px-2 mb-2">
          <h6 class="text-muted text-uppercase mb-4">Personal</h6>
          <img class="mb-4" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-15.svg">
          <p class="pb-2">Plenty of processing power for any personal projects, big or small.</p>
        </div>

        <ul class="list-unstyled list-bordered text-xs-left my-4">
          <li class="py-4"><strong>10k</strong> monthly requests</li>
          <li class="py-4"><strong>9am-5pm</strong> technical supprt</li>
          <li class="py-4"><strong>Public</strong> API access</li>
        </ul>

        <button class="btn btn-lg btn-primary btn-block">
          Start <span class="hidden-lg-down">a personal account</span>
        </button>
      </div>

      <div class="col-md-4 px-4 pb-2 mb-5">
        <div class="px-2">
          <h6 class="text-muted text-uppercase mb-4">Business</h6>
          <img class="mb-4" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-16.svg">
          <p class="pb-2">The perfect sized plan for small businesses to get started.</p>
        </div>

        <ul class="list-unstyled list-bordered text-xs-left my-4">
          <li class="py-4"><strong>100k</strong> monthly requests</li>
          <li class="py-4"><strong>24/7</strong> technical supprt</li>
          <li class="py-4"><strong>Public</strong> API access</li>
        </ul>

        <button class="btn btn-lg btn-primary btn-block">
          Start <span class="hidden-lg-down">a business account</span>
        </button>
      </div>

      <div class="col-md-4 px-4 pb-1 mb-5">
        <div class="px-2">
          <h6 class="text-muted text-uppercase mb-4">Corporate</h6>
          <img class="mb-4" src="<?php bloginfo('template_directory'); ?>/assets/img/startup-17.svg">
          <p class="pb-2">An unlimited plan that will scale infinitely to any size project.</p>
        </div>

        <ul class="list-unstyled list-bordered text-xs-left my-4">
          <li class="py-4"><strong>Unlimited</strong> monthly requests</li>
          <li class="py-4"><strong>24/7</strong> technical supprt</li>
          <li class="py-4"><strong>Public &amp; Private</strong> API access</li>
        </ul>

        <button class="btn btn-lg btn-primary btn-block">
          Start <span class="hidden-lg-down">a corporate account</span>
        </button>
      </div>
    </div>

  </div>
</div>
  
</div>


<?php get_footer(); ?>