<?php
/**
 * Defines the People custom post type
 */
if ( ! class_exists( 'JMB_Ministry_PostType' ) ) {
    class JMB_Ministry_PostType {
        public static
            $text_domain = 'jmb_ministry',
            $labels = array(
                'singular' => 'Ministry',
                'plural'   => 'Ministries',
                'slug'     => 'ministry'
            );

        /**
         * Registers the People custom type
         * @author Jim Barnes
         * @since 1.0.0
         */
        public static function register_posttype() {
            $labels = apply_filters( 'jmb_ministry_labels', self::$labels );
            register_post_type( 'ministry', self::args( $labels ) );
        }

        /**
         * Returns the labels array for post type registration
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $labels The array of base labels
         * @return array
         */
        public static function labels( $labels ) {
            $singular = $labels['singular'];
            $plural   = $labels['plural'];

            return apply_filters( 'jmb_ministry_label_args', array(
                'name'                  => _x( $plural, 'Post Type General Name', self::$text_domain ),
				'singular_name'         => _x( $singular, 'Post Type Singular Name', self::$text_domain ),
				'menu_name'             => __( $plural, self::$text_domain ),
				'name_admin_bar'        => __( $singular, self::$text_domain ),
				'archives'              => __( $singular . ' Archives', self::$text_domain ),
				'parent_item_colon'     => __( 'Parent ' . $singular . ':', self::$text_domain ),
				'all_items'             => __( 'All ' . $plural, self::$text_domain ),
				'add_new_item'          => __( 'Add New ' . $singular, self::$text_domain ),
				'add_new'               => __( 'Add New', self::$text_domain ),
				'new_item'              => __( 'New ' . $singular, self::$text_domain ),
				'edit_item'             => __( 'Edit ' . $singular, self::$text_domain ),
				'update_item'           => __( 'Update ' . $singular, self::$text_domain ),
				'view_item'             => __( 'View ' . $singular, self::$text_domain ),
				'search_items'          => __( 'Search ' . $plural, self::$text_domain ),
				'not_found'             => __( 'Not found', self::$text_domain ),
				'not_found_in_trash'    => __( 'Not found in Trash', self::$text_domain ),
				'featured_image'        => __( 'Featured Image', self::$text_domain ),
				'set_featured_image'    => __( 'Set featured image', self::$text_domain ),
				'remove_featured_image' => __( 'Remove featured image', self::$text_domain ),
				'use_featured_image'    => __( 'Use as featured image', self::$text_domain ),
				'insert_into_item'      => __( 'Insert into ' . $singular, self::$text_domain ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $singular, self::$text_domain ),
				'items_list'            => __( $plural . ' list', self::$text_domain ),
				'items_list_navigation' => __( $plural . ' list navigation', self::$text_domain ),
				'filter_items_list'     => __( 'Filter ' . $singular . ' list', self::$text_domain ),
            ) );
        }

        /**
         * Returns the args array for post type registration
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $labels The array of base labels
         * @return array
         */
        public static function args( $labels ) {
            $singular = $labels['singular'];
            $plural   = $labels['plural'];
            $slug     = $labels['slug'];

            $args = array(
				'label'                 => __( $singular, self::$text_domain ),
				'description'           => __( 'Used for defining sministries.', self::$text_domain ),
				'labels'                => self::labels( $labels ),
				'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
				'taxonomies'            => self::taxonomies(),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-admin-site',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'rewrite'               => array(
                    'slug'       => $slug,
                    'with_front' => false
                )
            );

            $args = apply_filters( 'jmb_ministry_post_type_args', $args );

			return $args;
        }

        /**
         * Defines which taxonomies are avilable to the post type
         * @author Jim Barnes
         * @since 1.0.0
         * @return array
         */
        public static function taxonomies() {
            $taxonomies = array(
                'categories'
            );

            $taxonomies = apply_filters( 'jmb_ministry_taxonomies', $taxonomies );

            return $taxonomies;
        }

        /**
         * Loads the ACF fields in
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $paths The paths to look for the ACF JSON file
         * @return array
         */
        public static function add_fields() {
            if ( function_exists( 'acf_add_local_field_group' ) ) {
                acf_add_local_field_group( array(
                    'title'  => 'Ministry Fields',
                    'fields' => array(
                        array(
                            'key'           => 'field_jmb_ministry_thumbnail',
                            'label'         => 'Ministry Thumbnail',
                            'name'          => 'ministry_thumbnail',
                            'type'          => 'image',
                            'instructions'  => 'The image that appears when ministries are listed in a grid.',
                            'required'      => 0,
                            'return_format' => 'id',
                            'preview_size'  => 'medium',
                            'library'       => 'all',
                        ),
                        array(
                            'key'           => 'field_jmb_ministry_short_desc',
                            'label'         => 'Short Description',
                            'name'          => 'ministry_short_desc',
                            'type'          => 'textarea',
                            'instructions'  => 'The short description that is displayed when listing ministries.',
                            'required'      => 0
                        ),
                        array(
                            'key'           => 'field_jmb_ministry_meeting_times',
                            'label'         => 'Meeting Times',
                            'name'          => 'ministry_meeting_times',
                            'type'          => 'wysiwyg',
                            'instructions'  => 'A description of regular meeting times can be placed here.',
                            'required'      => 0,
                            'tabs'          => 'all',
                            'toolbar'       => 'full',
                            'media_upload'  => 0,
                            'delay'         => 0,
                        ),
                        array(
                            'key'           => 'field_jmb_ministry_special_event_category',
                            'label'         => 'Special Event Category',
                            'name'          => 'ministry_special_event_category',
                            'type'          => 'taxonomy',
                            'instructions'  => 'Choose the special event category for this ministry.',
                            'required'      => 0,
                            'taxonomy'      => 'event-categories',
                            'field_type'    => 'select',
                            'allow_null'    => 0,
                            'add_term'      => 1,
                            'return_format' => 'id',
                            'multiple'      => 0,
                        ),
                        array(
                            'key'           => 'field_jmb_ministry_leader',
                            'label'         => 'Leader',
                            'name'          => 'ministry_leader',
                            'type'          => 'post_object',
                            'instructions'  => 'Choose the leader of this ministry.',
                            'required'      => 0,
                            'post_type'     => array(
                                0 => 'person',
                            ),
                            'allow_null'    => 1,
                            'multiple'      => 0,
                            'return_format' => 'id',
                            'ui'            => 1,
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param'    => 'post_type',
                                'operator' => '==',
                                'value'    => 'ministry',
                            ),
                        ),
                    )
                ));
            }
        }

        /**
         * The function that adds additional meta data to the post object
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The array of posts
         * @return array
         */
        public static function add_meta_data( $posts ) {
            foreach( $posts as $post ) {
                $ministry_thumbnail_id  = get_post_meta( $post->ID, 'ministry_thumbnail', true );
                $post->ministry_short_desc    = get_post_meta( $post->ID, 'ministry_short_desc', true );
                $post->ministry_meeting_times = get_post_meta( $post->ID, 'ministry_meeting_times', true );
                $post->ministry_special_event = get_post_meta( $post->ID, 'ministry_special_event_category', true );
                $post->ministry_leader        = get_post_meta( $post->ID, 'ministry_leader', true );

                if ( $ministry_thumbnail_id ) {
                    $image_array = wp_get_attachment_image_src( $ministry_thumbnail_id, 'medium' );
                    $post->ministry_thumbnail = isset( $image_array[0] ) ? $image_array[0] : null;
                } else {
                    $post->ministry_thumbnail = null;
                }
            }

            return $posts;
        }
    }
}