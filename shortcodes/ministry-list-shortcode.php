<?php
/**
 * Handles registering the `ministries` shortcode
 */
if ( ! class_exists( 'JMB_Ministry_List_Shortcode' ) ) {
    class JMB_Ministry_List_Shortcode {
        /**
         * Registers the `ministries` shortcode.
         * @author Jim Barnes
         * @since 1.0.0
         */
        public static function register_shortcode() {
            add_shortcode( 'ministries', array( 'JMB_Ministry_List_Shortcode', 'callback' ) );
        }

        /**
         * The callback used by the `ministries` shortcode.
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $atts The array of shortcode attributes
         * @param string $content The inner content
         * @return string
         */
        public static function callback( $atts, $content='' ) {
            $atts = shortcode_atts( array(
                'categories' => null,
                'layout'     => 'default'
            ), $atts );

            $layout = $atts['layout'];

            unset( $atts['layout'] );

            $args = array(
                'post_type'      => 'ministry',
                'posts_per_page' => -1,
            );

            if ( $atts['categories'] ) {
                $args['category_name'] = $atts['categories'];
            }

            $query = new WP_Query( $args );

            $posts = $query->posts;

            return JMB_Ministry_Common::display_ministries( $posts, $layout, $atts );
        }
    }
}