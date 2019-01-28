<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use Inc\Api\SettingsApi;
use Inc\Base\Basecontroller;
use Inc\Api\Callbacks\TestimonialCallbacks;



class TestimonialController extends BaseController
{

    public $settings;

    public $testimonial_callbacks;

    public $subpages = array();



    public function register()
    {


        if( ! $this->activated( 'testimonial_manager' ) ) return;


        $this->settings = new SettingsApi();

        $this->testimonial_callbacks = new TestimonialCallbacks();



        // Initiate Custom Testimonial Post Type
        add_action( 'init', array( $this, 'testimonialCPT' ) );

        // Adding Meta Boxes and Saving Meta Data
        add_action( 'add_meta_boxes', array( $this, 'addMetaBoxes' ) );
        add_action( 'save_post', array( $this, 'saveAuthorMetaBox' ) );

        //  Dealing with Columns those output the Meta Data
        add_action( 'manage_testimonial_posts_columns', array( $this, 'setCustomColumns' ) );
        add_action( 'manage_testimonial_posts_custom_column', array( $this, 'setCustomColumnData' ), 10, 2 );

        //  Enable Sortable Columns
        add_filter( 'manage_edit-testimonial_sortable_columns', array( $this, 'setCustomColumnSortable' ) );



        $this->setShortCodePage();

        //  Shortcode Hookers
        add_shortcode( 'testimonial-form', array( $this, 'testimonialForm' ) );
        add_shortcode( 'testimonial-slideshow', array( $this, 'testimonialSlideshow' ) );

        //  Ajax Submissions
        add_action( 'wp_ajax_submit_testimonial', array( $this, 'submitTestimonial' ) );
        add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submitTestimonial' ) );

    }

    public function submitTestimonial()
    {

        if( ! DOING_AJAX || ! check_ajax_referer( 'testimonial-nonce', 'nonce' ) ) {
            return $this->returnJSON( 'error' );
       }


        //  saitize the data
        $name = sanitize_text_field( $_POST[ 'name' ] );
        $email = sanitize_email( $_POST[ 'email' ] );
        $message = sanitize_textarea_field( $_POST[ 'message' ] );

        
        // store the data into the testimonial CPT
        $data  = array(
            'name'       => $name,
            'email'      => $email,
            'approved'   => 0,
            'featured'   => 0
        );

        $args = array(
            'post_title'        => 'Testimonial from ' . $name,
            'post_content'      => $message,
            'post_author'       => 1,
            'post_status'       => 'publish',
            'post_type'         => 'testimonial',
            'meta_input'        => array(
                '_niloy_testimonial_key'        => $data
            )
        );


        // send response
        $postID = wp_insert_post( $args );

        if( $postID ) {
            return $this->returnJSON( 'success' );
        }


        return $this->returnJSON( 'error' ); 

    }

    public function returnJSON( $status )
    {
        $return = array(
            'status'    => $status
        );

        wp_send_json( $return );


        wp_die();
    }



    // Form ShortCode
    public function testimonialForm()
    {

        ob_start();

        echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/form.min.css\" text=\"text/css\" media=\"all\" />";
        require_once( "$this->plugin_path/templates/contact-form.php" );
        echo "<script src=\"$this->plugin_url/assets/form.min.js\"></script>";

        return ob_get_clean();

    }

    //  Slide Shortcode
    public function testimonialSlideshow()
    {

        ob_start();

        echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/slider.min.css\" text=\"text/css\" media=\"all\" />";
        require_once( "$this->plugin_path/templates/slider.php" );
        echo "<script src=\"$this->plugin_url/assets/slider.min.js\"></script>";

        return ob_get_clean();

    }

    // Adding SubPage named Shortcode
    public function setShortCodePage()
    {

        $this->subpages = array(
            array(
                'parent_slug'   => 'edit.php?post_type=testimonial',
                'page_title'    => 'Shortcodes',
                'menu_title'    => 'Shortcodes',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_testimonial_shortcode',
                'page_callback' => array( $this->testimonial_callbacks, 'shortcodePage' )
             )

        );

        $this->settings->addSubPages( $this->subpages )->register();

    }



    public function testimonialCPT()
    {

        register_post_type( 'testimonial', array(
            'labels'                => array(
                'name'                  => 'Testimonials',
                'singular_name'         => 'Testimonial',
                'plural_name'           => 'Testimonials',
                'menu_name'             => 'Testimonials'
            ),
            'public'                => true,
            'has_archive'           => false,
            'menu_icon'             => 'dashicons-testimonial',
            'supports'              => array( 'title', 'editor' ),
            'exclude_from_search'   => true,
            'publicly_queryable'    => false
        ) );

    }

    //  Adding Meta Boxes
    public function addMetaBoxes()
    {
        //  Author Name
        add_meta_box( 'testimonial_options', 'Testimonial Options', array( $this, 'renderMetaBox' ), 'testimonial', 'side', 'default' );

    }

    //  Rendering Meta Boxes
    public function renderMetaBox( $post )
    {

        wp_nonce_field( 'niloy_testimonial', 'niloy_testimonial_nonce' );

        $data = get_post_meta( $post->ID, '_niloy_testimonial_key', true );

        $name = isset( $data[ 'name' ] ) ? $data[ 'name' ] : '';
        $email = isset( $data[ 'email' ] ) ? $data[ 'email' ] : '';
        $approved = isset( $data[ 'approved' ] ) ? $data[ 'approved' ] : false;
        $featured = isset( $data[ 'featured' ] ) ? $data[ 'featured' ] : false;

        ?>

        <p>
            <label for="niloy_testimonial_author">Testimonial Author: </label>
            <input class="widefat" type="text" name="niloy_testimonial_author" id="niloy_testimonial_author" value="<?php echo esc_attr( $name ) ?>" size="30" />
        </p>
        <p>
            <label for="niloy_testimonial_author_email">Testimonial Author Email: </label>
            <input class="widefat" type="email" name="niloy_testimonial_author_email" id="niloy_testimonial_author_email" value="<?php echo esc_attr( $email ) ?>" size="30" />
        </p>
        <div class="meta-container">
        
            <label class="meta-label w-50 inline" for="niloy_testimonial_approved">Approved</label>
            <div class="text-right w-50 inline">

                <div class="ui-toggle inline">
                    <input type="checkbox" id="niloy_testimonial_approved" name="niloy_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
                    <label for="niloy_testimonial_approved"><div></div></label>
                </div>

            </div>
            <label class="meta-label w-50 inline" for="niloy_testimonial_featured">Featured</label>
            <div class="text-right w-50 inline">

                <div class="ui-toggle inline">
                    <input type="checkbox" id="niloy_testimonial_featured" name="niloy_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
                    <label for="niloy_testimonial_featured"><div></div></label>
                </div>
                
            </div>

        </div>
    <?php

    }


    /**
     *  SAVING META DATA
     */
    public function saveAuthorMetaBox( $post_id )
    {

        if( ! isset( $_POST[ 'niloy_testimonial_nonce' ] ) ) return $post_id;

        $nonce = $_POST[ 'niloy_testimonial_nonce' ];

        if( ! wp_verify_nonce( $nonce, 'niloy_testimonial' ) ) return $post_id;

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

        if( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;


        $data  = array(
            'name'          => sanitize_text_field( $_POST[ 'niloy_testimonial_author' ] ),
            'email'         => sanitize_email( $_POST[ 'niloy_testimonial_author_email' ] ),
            'approved'      => isset( $_POST[ 'niloy_testimonial_approved' ] ) ? 1 : 0,
            'featured'      => isset( $_POST[ 'niloy_testimonial_featured' ] ) ? 1 : 0
        );

        update_post_meta( $post_id, '_niloy_testimonial_key', $data );
 
    }


    public function setCustomColumns( $columns )
    {

        $title = $columns[ 'title' ];
        $date = $columns[ 'date' ];

        unset( $columns[ 'title' ], $columns[ 'date' ] );

        $columns[ 'name' ]  = 'Author Name';
        $columns[ 'title' ]  = $title;
        $columns[ 'approved' ]  = 'Approved';
        $columns[ 'featured' ]  = 'Featured';
        $columns[ 'date' ]  = $date;

        return $columns;

    }


    public function setCustomColumnData( $column, $post_id )
    {

        $data = get_post_meta( $post_id, '_niloy_testimonial_key', true );

        $name = isset( $data[ 'name' ] ) ? $data[ 'name' ] : '';
        $email = isset( $data[ 'email' ] ) ? $data[ 'email' ] : '';
        $approved = isset( $data[ 'approved' ] ) && $data[ 'approved' ] === 1 ? '<span class="dashicons dashicons-thumbs-up"></span>' : '<span class="dashicons dashicons-thumbs-down"></span>';
        $featured = isset( $data[ 'featured' ] ) && $data[ 'featured' ] === 1 ? '<span class="dashicons dashicons-thumbs-up"></span>' : '<span class="dashicons dashicons-thumbs-down"></span>';

        switch( $column ) {

            case 'name':
                echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
                break;

            case 'approved':
                echo $approved;
                break;

            case 'featured':
                echo $featured;
                break;

        }

    }


    public function setCustomColumnSortable( $columns )
    {

        $columns[ 'name' ] = 'name';
        $columns[ 'approved' ] = 'approved';
        $columns[ 'featured' ] = 'featured';

        return $columns;

    }


}
