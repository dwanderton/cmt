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
                <a href="#requestAQuote">
                  <button class="btn btn-primary btn-lg">Request Your Quote</button>
                </a>
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
        <div class="col-sm-12">
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
                    <div class="col-md-4">
                      <img src="<?php echo get_the_post_thumbnail_url($service) ?>">
                      <h2>
                        <a href="<?php the_permalink(); ?>"><?php print_r($service->post_title) ?>
                        </a>
                      </h2>
                    <div class="row">
                    <?php 
                      $service_languages = wp_get_post_terms( $service->ID, 'language' );
                      foreach ( $service_languages as $service_language ): ?>
                      <div class="col-xs-4">
                        <img src="<?php echo get_term_meta($service_language->term_id, 'image', true)?>">
                      </div>
                    <?php endforeach; ?>
                    </div>
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
      <div class="row">
        <?php
          //function gets all posts from the language taxonomy
          $languages = get_terms([
            'taxonomy' => 'language',
            'hide_empty' => false,
          ]);
           
          if ( $languages ) {
              //For each loop to go through each post from the $languages variable
              foreach ( $languages as $language ) :?>
                  <div class="col-md-4 mt-5 mb-1">
                    <p><?php 
                      // print_r($language->description);
                      $t_id = $language->term_id;
                      $language_image = get_term_meta($t_id, 'image', true);
                    ?>
                    <img src="<?php echo $language_image?>" style="max-width: 80%; max-height: 100px; clear:both; border: 2px solid rgba(0, 0, 0, 0.19);">
                    </p>
                    <h4><?php print_r($language->name); ?></h4>
                  </div>
              <?php
              endforeach;
          }
        ?>
      </div>
    </div>
  </div>
  <div class="block" id="about_quote">
    <div class="container text-center">
      <div class="row">
        <div class="col-md-6">
          <h1 class="block-titleData frequency">About</h1>
          <?php
            //query to get latest post that is categorised as "about"
            $the_query = new WP_Query(array(
                'posts_per_page' => 1,
                'cat' => get_cat_ID('about')
            ));
          ?>
          <ul class="list-unstyled list-spaced">
            <li class="mb-2"><h6 class="text-uppercase"><?php //print_r($the_query->post_title);?></h6></li>
            <li class="text-muted">
              <?php
                if ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  the_content();
                }
              ?>
            </li>
          </ul>
        </div>
        <div class="col-md-6">
          <a name="requestAQuote"></a>
          <h1 class="block-titleData frequency">Quote</h1>
        </div>
      </div>  
    </div>
  </div>
<?php get_footer(); ?>