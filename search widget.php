<?php
// Register the Custom Search Widget
function custom_search_widget() {
    register_widget('Custom_Search_Widget');
}
add_action('widgets_init', 'custom_search_widget');
// Define the Custom Search Widget
class Custom_Search_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'custom_search_widget', // Base ID
            'Custom Search', // Name
            array('description' => __('A custom search widget with a search icon.', 'text_domain')) // Args
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
       

        // Display the search form
        ?>
        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
            <label>
                <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search', 'placeholder', 'text_domain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </label>
            <button type="submit" class="search-submit" aria-label="Search">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <?php

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : __('Search', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
?>
