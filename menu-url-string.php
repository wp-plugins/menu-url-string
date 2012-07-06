<?php
/*
Plugin Name: Url Conditionnal Category List
Plugin URI: http://www.pixel-conception.com/menu_url_plugin_wordpress.html
Version: 1.0
Description: This Widget Plugin enables a list or dropdown of categories based if the url contain a certain string
Author: Rousseau Antoine
Author URI: http://www.pixel-conception.com/
*/
class url_conditionnal_category_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function url_conditionnal_category_Widget(){
		$widget_ops = array('classname' => 'url_conditionnal_category_Widget custom-formatting', 'description' => 'This plugin enables a menu depend if a string is found in url.');
		$this->WP_Widget('url_conditionnal_category_Widget', 'url_conditionnal_category_Widget', $widget_ops);
	}// e
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
			$keyword = apply_filters('widget_keyword', $instance['keyword'] );
	if (stripos($_SERVER['REQUEST_URI'],$keyword) !== false) {$category_id = $instance['category_id'];}
	
		$show_as_dropdown = isset( $instance['show_as_dropdown'] ) ? $instance['show_as_dropdown'] : false;
		$show_post_counts = isset( $instance['show_post_counts'] ) ? $instance['show_post_counts'] : false;
		$show_hierarchy = isset( $instance['show_hierarchy'] ) ? $instance['show_hierarchy'] : false;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
		    echo $before_title . $title . $after_title;

		/* If a category was selected, display it. */
		if ( $category_id ) :
		    if ( $show_as_dropdown ) : ?>
			<ul>
<?php			    wp_dropdown_categories( "orderby=name&hierarchical={$show_hierarchy}&show_count={$show_post_counts}&use_desc_for_title=0&child_of=".$category_id ); ?>
			</ul>
<?php		    else : ?>
			<ul>
<?php			    wp_list_categories( "title_li=&orderby=name&hierarchical={$show_hierarchy}&show_count={$show_post_counts}&use_desc_for_title=0&child_of=".$category_id ); ?>
			</ul>
<?php		    endif;
		endif;

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
$instance['keyword'] = strip_tags( $new_instance['keyword'] );
		/* No need to strip tags for categories. */
		$instance['category_id'] = $new_instance['category_id'];
		$instance['show_as_dropdown'] = $new_instance['show_as_dropdown'];
		$instance['show_post_counts'] = $new_instance['show_post_counts'];
		$instance['show_hierarchy'] = $new_instance['show_hierarchy'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
		 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Categories', 'keyword' => '','category_id' => '', 'show_as_dropdown' => false, 'show_post_counts' => false, 'show_hierarchy' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

			<p>
			<label for="<?php echo $this->get_field_id( 'keyword' ); ?>"><?php esc_html_e('URL string'); ?></label>
			<input id="<?php echo $this->get_field_id( 'keyword' ); ?>" type="text" name="<?php echo $this->get_field_name( 'keyword' ); ?>" value="<?php echo $instance['keyword']; ?>" class="widefat" />
		</p>
		<!-- Show Categories -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php esc_html_e('Category to be displayed:'); ?></label>
			<?php wp_dropdown_categories('show_option_all=Select Category&hierarchical=1&orderby=name&selected='.$instance['category_id'].'&name='.$this->get_field_name( 'category_id' ).'&class=widefat'); ?>

		</p>


		<p>
			<!-- Show as dropdown checkbox -->
			<label for="<?php echo $this->get_field_id( 'show_as_dropdown' ); ?>">
			    <input class="checkbox" type="checkbox" <?php checked( $instance['show_as_dropdown'], true ); ?> id="<?php echo $this->get_field_id( 'show_as_dropdown' ); ?>" name="<?php echo $this->get_field_name( 'show_as_dropdown' ); ?>" value="1" <?php checked('1', $instance['show_as_dropdown']); ?> />
			    <?php esc_html_e('Show as dropdown'); ?>
			</label><br />

			<!-- Show post counts checkbox -->
			<label for="<?php echo $this->get_field_id( 'show_post_counts' ); ?>">
			    <input class="checkbox" type="checkbox" <?php checked( $instance['show_post_counts'], true ); ?> id="<?php echo $this->get_field_id( 'show_post_counts' ); ?>" name="<?php echo $this->get_field_name( 'show_post_counts' ); ?>" value="1" <?php checked('1', $instance['show_post_counts']); ?> />
			    <?php esc_html_e('Show post counts'); ?>
			</label><br />

			<!-- Show hierarchy checkbox -->
			<label for="<?php echo $this->get_field_id( 'show_hierarchy' ); ?>">
			    <input class="checkbox" type="checkbox" <?php checked( $instance['show_hierarchy'], true ); ?> id="<?php echo $this->get_field_id( 'show_hierarchy' ); ?>" name="<?php echo $this->get_field_name( 'show_hierarchy' ); ?>" value="1" <?php checked('1', $instance['show_hierarchy']); ?> />
			    <?php esc_html_e('Show hierarchy'); ?>
			</label>
		</p>
		
<?php
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("url_conditionnal_category_Widget");') );