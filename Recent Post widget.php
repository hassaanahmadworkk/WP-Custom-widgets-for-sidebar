<?php
// Register the Recent Posts with Thumbnail widget
function custom_recent_posts_with_thumbnail() {
    register_widget('Custom_Recent_Posts_Widget');
}
add_action('widgets_init', 'custom_recent_posts_with_thumbnail');

// Define the Custom Recent Posts Widget
class Custom_Recent_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'custom_recent_posts_widget', // Base ID
            'Recent Posts with Thumbnail', // Name
            array('description' => __('Displays recent posts with thumbnails, titles, and dates.', 'text_domain')) // Args
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // Query for recent posts
        $recent_posts = new WP_Query(array(
            'posts_per_page' => 5, // Number of posts to show
            'post_status' => 'publish',
            'ignore_sticky_posts' => true
        ));

        if ($recent_posts->have_posts()) {
            echo '<ul class="custom-recent-posts">';
            while ($recent_posts->have_posts()) {
                $recent_posts->the_post();
                ?>
                <li class="recent-post-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="recent-post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail'); // Display the thumbnail image ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="recent-post-content">
                        <a class="recent-post-title" href="<?php the_permalink(); ?>">
                            <?php echo wp_trim_words(get_the_title(), 3, ''); // Display only 3 words of the title ?>
                        </a>
                        <a class="recent-post-date"><?php echo get_the_date(); // Display the post date ?></a>
                    </div>
                </li>
                <?php
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>No recent posts available.</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Recent Posts', 'text_domain');
        }
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
