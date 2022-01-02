<?php
/**
 * @package JAndrewsPlugin
 */

namespace Inc\pages;

use \Inc\API\SettingsApi;
use \Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

 class Admin extends BaseController {

    public $settings;

    public $callbacks;

    public $pages = array();

    public $subpages = array();
    
    public function register() {

        $this -> settings = new SettingsApi();

        $this -> callbacks = new AdminCallbacks();

        $this -> setPages();

        $this -> setSubpages();

        $this -> setSettings();

        $this -> setSections();

        $this -> setFields();

        $this -> settings -> addPages( $this -> pages ) -> withSubPage( 'Dashboard' ) -> addSubPages( $this -> subpages ) -> register();

    }

    public function setPages() {

        $this -> pages = array(
            array(
                'page_title'    =>  'JAndrews Plugin', 
                'menu_title'    =>  'JAndrews',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'jandrews_plugin',
                'callback'      =>  array( $this -> callbacks, 'adminDashboard' ),
                'icon_url'      =>  'dashicons-buddicons-replies',
                'position'      =>  200
            )   
        );
    }

    public function setSubpages() {

        $this -> subpages = array(
            array(
                'parent_slug'   =>  'jandrews_plugin',
                'page_title'    =>  'Custom Post Types Manager', 
                'menu_title'    =>  'CPT Manager',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'jandrews_cpt',
                'callback'      =>  array( $this -> callbacks, 'adminCPT' ),
            ),
            array(
                'parent_slug'   =>  'jandrews_plugin',
                'page_title'    =>  'Custom Taxonomies', 
                'menu_title'    =>  'Taxonomies',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'jandrews_taxonomies',
                'callback'      =>  array( $this -> callbacks, 'adminTaxonomy' ),
            ),                
            array(
                'parent_slug'   =>  'jandrews_plugin',
                'page_title'    =>  'Custom Widgets', 
                'menu_title'    =>  'Widgets',
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'jandrews_widgets',
                'callback'      =>  array( $this -> callbacks, 'adminWidget' ),
            )       
        );
    }

    public function setSettings() {

        $args = array(
            array(
                'option_group'  =>  'jandrews_options_group',
                'option_name'   =>  'text_example',
                'callback'      =>  array( $this -> callbacks, 'jandrewsOptionsGroup')
            ),
            array(
                'option_group'  =>  'jandrews_options_group',
                'option_name'   =>  'first_name'
            )

        );

        $this -> settings -> setSettings( $args );
    }

    public function setSections() {

        $args = array(
            array(
                'id'            =>  'jandrews_admin_index',
                'title'         =>  'Settings',
                'callback'      =>  array( $this -> callbacks, 'jandrewsAdminSection'),
                'page'          =>  'jandrews_plugin'
            )
        );

        $this -> settings -> setSections( $args );

    }

    public function setFields() {

        $args = array(
            array(
                'id'        =>  'text_example',
                'title'     =>  'Text Example',
                'callback'  =>  array( $this -> callbacks, 'jandrewsTextExample'),
                'page'      =>  'jandrews_plugin',
                'section'   =>  'jandrews_admin_index',
                'args'      =>  array(
                    'label_for' =>  'text_example',
                    'class'     =>  'example-class'
                )
                ),
            array(
                'id'        =>  'first_name',
                'title'     =>  'First Name',
                'callback'  =>  array( $this -> callbacks, 'jandrewsFirstName'),
                'page'      =>  'jandrews_plugin',
                'section'   =>  'jandrews_admin_index',
                'args'      =>  array(
                    'label_for' =>  'first_name',
                    'class'     =>  'example-class'
                )
            )
        );

        $this -> settings -> setFields( $args );
        
    }
 }