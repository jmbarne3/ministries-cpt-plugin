<?php
/**
 * Command functions for displaying ministries
 */
if ( ! class_exists( 'JMB_Ministry_Common' ) ) {
    class JMB_Ministry_Common {
        /**
         * Displays an array of ministries
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The array of ministry posts
         * @param string $layout The layout to use
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_ministries( $posts, $layout='default', $args=array() ) {
            $before = JMB_Ministry_Common::display_ministries_default_before( $posts, $args );

            if ( has_filter( `display_ministries_{$layout}_before` ) ) {
                $before = apply_filters( `display_ministries_{$layout}_before`, $before, $posts, $args );
            }

            $content = JMB_Ministry_Common::display_ministries_default( $posts, $args );

            if ( has_filter( `display_ministries_{$layout}` ) ) {
                $content = apply_filters( `display_ministries_{$layout}`, $content, $posts, $args );
            }

            $after = JMB_Ministry_Common::display_ministries_default_after( $posts, $args );

            if ( has_filter( `display_ministries_{$layout}_after` ) ) {
                $after = apply_filters( `display_ministries_{$layout}_after`, $after, $posts, $args );
            }

            return $before . $content . $after;
        }

        /**
         * Handles the default opening element for the ministries list
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The list of ministry posts
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_ministries_default_before( $posts, $args ) {
            ob_start();
        ?>
            <div class="row">
        <?php
            return ob_get_clean();
        }

        /**
         * Handles the default list of ministries markup
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The list of ministry posts
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_ministries_default( $posts, $args ) {
            ob_start();
            foreach( $posts as $post ) :
        ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <?php if ( $post->ministry_thumbnail ) : ?>
                        <img class="card-img-top mb-2" src="<?php echo $post->ministry_thumbnail; ?>">
                        <?php endif; ?>
                        <h2 class="card-title"><?php echo $post->post_title; ?></h2>
                        <p class="card-text"><?php echo $post->ministry_short_desc; ?></p>
                    </div>
                    <div class="card-footer p-2">
                        <a class="btn btn-complimentary btn-block" href="<?php echo get_permalink( $post->ID ); ?>">Learn More</a>
                    </div>
                </div>
            </div>
        <?php
            endforeach;
            return ob_get_clean();
        }

        /**
         * Handles the default closing element for the ministries list
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The list of ministry posts
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_ministries_default_after( $posts, $args ) {
            ob_start();
        ?>
            </div>
        <?php
            return ob_get_clean();
        }
    }
}