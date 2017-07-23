<?php get_header(); ?>

  <div id="carousel-example-generic-2" class="carousel carousel-light slide " data-ride="carousel">
    <?php
      //function gets all posts from the industry custom post type
      $industries = get_posts( array(
          'post_type' => 'industry'
      ));

      if ( $industries ) {
        ?>
  <ol class="carousel-indicators">
    <?php
    $i = 0;
    foreach ( $industries as $key=>$industry ) : ?>
    <li data-target="#carousel-example-generic-2" data-slide-to="<?php echo $i ?>" <?php if($i==0){?> class="active"<?php }?>></li>
    <?php  
        $i += 1;
        endforeach; 
    ?>
  </ol>
  <div class="carousel-inner" role="listbox">
    <?php
          $i = 0;
          //For each loop to go through each post from the $industries variable
          foreach ( $industries as $key=>$industry ) :
              setup_postdata( $industry ); ?>
              <div class="carousel-item <?php if($i==0){echo 'active';}?>" style="background-image: url(<?php echo wp_get_attachment_image_url(get_post_meta($industry->ID,'industry_industry-slider-image_thumbnail_id', true),'large');?>); background-repeat: no-repeat; background-size:cover; min-height:600px;">
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
          <strong style="background: #fff; padding: 12px; border-radius: 4px; color: #28669F;">CM Translations</strong>
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
              <a class="nav-link" href="#requestAQuote">Request a Quote</a>
            </li>
          </ul>
        </div>
      </nav>
      </div>
      
      <div class="container py-4 fixed-bottom">
        <div class="block-xs pb-5">
          <div class="container">
            <div class="row">
              <div class="col-sm-10 col-lg-6">
                <h1 class="block-titleData frequency" style="color:white;">Translations for <?php echo $industry->post_title; ?></h1>
                <button class="btn btn-primary btn-lg">Request Your Quote</button>
              </div>
            </div>     
          </div>
        </div>
      </div>
    </div>
          <?php
          $i +=1;
          endforeach; 
          wp_reset_postdata();
      }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carousel-example-generic-2" role="button" data-slide="prev">
    <span class="icon icon-chevron-thin-left" aria-hidden="true" style="color:white;"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel-example-generic-2" role="button" data-slide="next">
    <span class="icon icon-chevron-thin-right" aria-hidden="true" style="color:white;"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

  <div class="block" id="industries">
    <div class="container text-xs-center">
      <div class="row">
        <div class="col">
          <h1 class="block-titleData frequency">Industries</h1>
        </div>
      </div> 
      <?php
        //function gets all posts from the industry custom post type
        $industries = get_posts( array(
            'post_type' => 'industry'
        ));
         
        if ( $industries ) {
            //For each loop to go through each post from the $industries variable
            foreach ( $industries as $key=>$industry ) :
                setup_postdata( $industry ); ?>
                <div class="row">
                  <?php 
                  echo generate_industries($industry, $key);
                  ?>
                </div>
            <?php
            endforeach; 
            wp_reset_postdata();
        }
      ?>
    </div>
  </div>



  <div class="block" id="services">
    <div class="container text-xs-center">
      <div class="row">
        <div class="col">
          <h1 class="block-titleData frequency">Services</h1>
        </div>
      </div>
      <div class="row">
        <?php
          //function gets all posts from the service custom post type
          $services = get_posts( array(
              'post_type' => 'service'
          ));
           
          if ( $services ) {
              //For each loop to go through each post from the $services variable
              foreach ( $services as $service ) :
                  setup_postdata( $service ); ?>
                  <div class="col">
                    <h6 class="text-muted text-uppercase">The image will go here</h6>
                    <h2><a href="<?php the_permalink(); ?>"><?php print_r($service->post_title) ?></a></h2>
                    <?php the_content(); ?>
                  </div>
              <?php
              endforeach; 
              wp_reset_postdata();
          }
        ?>
      </div>
    </div>
  </div>

  <div class="block" id="languages">
    <div class="container text-center">
      <div class="row">
        <div class="col">
          <h1 class="block-titleData frequency">Languages</h1>
        </div>
      </div>
      <div class="row ">
        <?php
          //function gets all posts from the language taxonomy
          $languages = get_terms([
            'taxonomy' => 'language',
            'hide_empty' => false,
          ]);
           
          if ( $languages ) {
              //For each loop to go through each post from the $languages variable
              foreach ( $languages as $language ) :?>
                  <div class="col">
                    <h6 class="text-muted text-uppercase">The image will go here</h6>
                    <h2><?php print_r($language->name); ?></h2>
                    <?php 
                      print_r($language->description);
                      $t_id = $language->term_id;
                      $term_meta = get_option( "weekend-series_$t_id" );
                      print_r($term_meta['image']); 
                    ?>
                  </div>
              <?php
              endforeach; 
          }
        ?>
      </div>
    </div>
  </div>
<?php get_footer(); ?>