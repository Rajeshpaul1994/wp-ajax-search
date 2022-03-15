add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){?>
<ul>
<?php
    $the_query = new WP_Query( array( 'posts_per_page' => 5, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'post' ) );
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
			<li>
            <a href="<?php echo esc_url( the_permalink() ); ?>"><?php the_title();?></a>
			</li>
        <?php endwhile;
		wp_reset_postdata();  
	else: 
		echo '<h3>No Results Found</h3>';
    endif;

    die(); ?>
</ul>
	<?php
}
// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
function fetchResults(){
	var keyword = jQuery('#srch').val();
	if(keyword == ""){
		jQuery('#srch').html("no posts");
	} else {
		jQuery.ajax({
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			type: 'post',
			data: { action: 'data_fetch', keyword: keyword  },
			success: function(data) {
				jQuery('#dataf').html( data );
				
			}
		});
	}
    

}
</script>

<?php
}
