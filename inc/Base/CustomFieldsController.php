<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use \Inc\Api\SettingsApi;
use \Inc\Base\Basecontroller;
use \Inc\Api\Callbacks\CfCallbacks;
use \Inc\Api\Callbacks\AdminCallbacks;


class CustomFieldsController extends BaseController
{

    public $settings;

    public $callbacks;

    public $cf_callbacks;

    public $subpages = array();

    // public $custom_post_types = array();


    public function register()
    {

        if( ! $this->activated( 'cf_manager' ) ) return;


        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->cf_callbacks = new CfCallbacks();

        $this->setSubpages();

        $this->metaBoxes = array();


        $this->setSettings();
        $this->setSections();
        $this->setFields();


        $this->settings->addSubPages( $this->subpages )->register();


        $this->showPosts();

        if( ! empty( $this->metaBoxes ) ) {

            add_action( 'add_meta_boxes', array( $this, 'addMultipleMetaBoxes' ) );

        }

    }


    public function setSubpages()
    {

        $this->subpages = array(
            array(
                'parent_slug'   => 'niloy_plugin',
                'page_title'    => 'Niloy Plugin CPT',
                'menu_title'    => 'CF Manager',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_custom_fields',
                'page_callback' => array( $this->callbacks, 'adminCfManager' )
             )

        );

    }

    /** */
    public function setSettings()
    {

        $args = array(
            array(
				'option_group'      => 'niloy_plugin_cf_settings',
				'option_name'       => 'niloy_plugin_cf',
                'callback'          => array( $this->cf_callbacks, 'cfSanitize' )
            )
        );


        $this->settings->setSettings( $args );

    }

    
    public function setSections()
    {

        $args = array(
            array(
                'id'                => 'admin_cf_section',
                'title'             => 'Custom Post Type Manager',
                'callback'          => array( $this->cf_callbacks, 'cfSectionManager' ),
                'page'              => 'niloy_custom_fields'
            )
        );

        $this->settings->setSections( $args );

    }

        
    public function setFields()
    {

        $args = array(

            array(
                'id'                => 'custom_fields',
                'title'             => 'Custom Fields ID',
                'callback'          => array( $this->cf_callbacks, 'textField' ),
                'page'              => 'niloy_custom_fields',
                'section'           => 'admin_cf_section',
                'args'              => array(
                    'option_name'       => 'niloy_plugin_cf',
                    'label_for'         => 'custom_fields',
                    'placeholder'       => 'eg. sq.ft/price'
                )
            ),
            array(
                'id'                => 'field_name',
                'title'             => 'Field Name',
                'callback'          => array( $this->cf_callbacks, 'textField' ),
                'page'              => 'niloy_custom_fields',
                'section'           => 'admin_cf_section',
                'args'              => array(
                    'option_name'       => 'niloy_plugin_cf',
                    'label_for'         => 'field_name',
                    'placeholder'       => 'eg. Sq.ft/Price'
                )
            ),
            array(
                'id'                => 'related_posts',
                'title'             => 'Related Post',
                'callback'          => array( $this->cf_callbacks, 'dropDownField' ),
                'page'              => 'niloy_custom_fields',
                'section'           => 'admin_cf_section',
                'args'              => array(
                    'option_name'       => 'niloy_plugin_cf',
                    'label_for'         => 'related_posts'
                )
            )

        );

        $this->settings->setFields( $args );

    }

    public function showPosts()
    {

        $options = get_option( 'niloy_plugin_cf' ) ?: array();

        // var_dump($options);

        $this->metaBoxes = array(
            'custom_fields'     => $options[ 'custom_fields' ],
            'field_name'        => $options[ 'field_name' ],
            'related_posts'     => $options[ 'related_posts' ]
        );

    }


    /**
     *  Meta Box Init Functions
     * ====================================
     */

    public function addMultipleMetaBoxes()
    {

        $options = get_option( 'niloy_plugin_cf' ) ?: array();

        add_meta_box( 'field_options', 'Field Options', array( $this, 'renderMultipleMetaBoxes'), $options['related_posts'], 'normal', 'default' );

    }

    public function renderMultipleMetaBoxes( $post )
    {

        wp_nonce_field( 'niloy_auto_metabox_generator', 'niloy_auto_metabox_generator_nonce' );

        $options = get_option( 'niloy_plugin_cf' ) ?: array();

        $data = get_post_meta( $post->ID, '_' . $options[ 'custom_fields' ] . '_metabox_generator_key', true );

        ?>

        <p>
            <label for="niloy_auto_meta_box_field"><?php echo $options['field_name'] ?>: </label>
            <input class="widefat" type="text" name="niloy_auto_meta_box_field" id="niloy_auto_meta_box_field" value="<?php echo esc_attr( $data ) ?>" size="30" />
        </p>

        <?php

    }


}