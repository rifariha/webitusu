<?php
// [cg_content_box_style1]
function cg_content_box_style1($atts, $content=null, $code) {

  extract(shortcode_atts(array(
    'content_box_img'  => '',
    'content_box_url' => '#',
    'first_text_field'  => 'The first field',
    'second_text_field' => 'The second field',
    'content_box_description' => 'This is the description'
  ), $atts));

  $real_content_box_img = '';

  if ( $content_box_img ) {
    $content_box_img_source = wp_get_attachment_image_src($content_box_img, '');
    $real_content_box_img = $content_box_img_source[0];
  }

  ob_start();
  ?> 

<div class="cg-overlay-feature">

<a href="<?php echo esc_url( $content_box_url ); ?>"><img src="<?php echo esc_url( $real_content_box_img ); ?>" alt="" /></a>

<div class="cg-copy">
<a href="<?php echo esc_url( $content_box_url ); ?>"><span class="subtitle"><strong><?php echo $first_text_field; ?></strong></span>

<span class="title"><?php echo $second_text_field; ?></span>
<span class="text"><?php echo $content_box_description; ?></span></a>

</div><!--/cg-copy -->

</div><!--/cg-overlay-feature -->  

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

add_shortcode('cg_content_box_style1', 'cg_content_box_style1');


function cg_content_box_style2($atts, $content=null, $code) {

  extract(shortcode_atts(array(
    'content_box_img'  => '',
    'content_box_url' => '#',
    'first_text_field'  => 'The first field',
    'second_text_field' => 'The second field',
    'content_box_description' => 'This is the description'
  ), $atts));

  $real_content_box_img = '';

  if ( $content_box_img ) {
    $content_box_img_source = wp_get_attachment_image_src($content_box_img, '');
    $real_content_box_img = $content_box_img_source[0];
  }

  ob_start();
  ?> 


<div class="cg-overlay-slideup">

<div class="cg-gradient"></div>

<a href="<?php echo esc_url( $content_box_url ); ?>"><img src="<?php echo esc_url( $real_content_box_img ); ?>" alt="" /></a>

<div class="cg-copy"><a href="<?php echo esc_url( $content_box_url ); ?>">
<span class="title"><?php echo $first_text_field; ?></span>
<span class="price"><?php echo $second_text_field; ?></span>
<span class="text"><span class="hr-rule"></span><?php echo $content_box_description; ?></span></a>
</div><!--/cg-copy -->
</div><!--/cg-overlay-slideup -->

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

add_shortcode('cg_content_box_style2', 'cg_content_box_style2');
