<?php
/*
Plugin Name: Pushup Your Broswer
Plugin URI: http://www.sealedbox.cn/

Description: A subtle upgrade link is shown when people visit your website using an outdated browser. 

You can see more information at : http://www.sealedbox.cn/

***************************************************

Version: 1.0
Author: jigen.he
Author URI: http://www.sealedbox.cn/


*/


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!class_exists('Pushup')) {


    class Pushup {
            var $version = "1.0";

            /**
             * constructor
             * 
             * @author Administrator (2009-2-7)
             */
            function Pushup(){


                    $this->define_constant();

                    register_activation_hook( dirname(__FILE__) . '/pushup.php', array(&$this, 'activate') );
                    register_deactivation_hook( dirname(__FILE__) . '/pushup.php', array(&$this, 'deactivate') );   

                    // Start this plugin once all other plugins are fully loaded
                    add_action( 'plugins_loaded', array(&$this, 'start_plugin') );
            }

            /**
             * Start this plugin
             * 
             * @author Administrator (2009-2-7)
             */
            function start_plugin(){
                // load js script and css style sheet
                $this->load_styles();
                $this->load_script();
            }

            function load_styles() {
                     wp_enqueue_style( 'pushupcss', PUSHUP_URLPATH .'css/pushup.css' );
            }

            function load_script(){
                    wp_enqueue_script('pushupjs', PUSHUP_URLPATH .'js/pushup.js.php');
           }


            function define_constant() {

                // define URL
                define('PUSHUP_FOLDER', plugin_basename( dirname(__FILE__)) );
                
                define('PUSHUP_ABSPATH', str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) . '/' ));
                define('PUSHUP_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
        
                // get value for safe mode
                if ( (gettype( ini_get('safe_mode') ) == 'string') ) {
                    // if sever did in in a other way
                    if ( ini_get('safe_mode') == 'off' ) define('SAFE_MODE', FALSE);
                    else define( 'SAFE_MODE', ini_get('safe_mode') );
                } else
                define( 'SAFE_MODE', ini_get('safe_mode') );
                
            }

            /**
             * do something when plugins activate
             * 
             * @author Administrator (2009-2-7)
             */
            function activate() {
                    // do something
                    add_option('pushup_version',$this->version);
            }

            
            /**
             * do something when plugins deactivate
             * 
             * @author Administrator (2009-2-7)
             */
            function deactivate() {
                    delete_option('pushup_version');
                    // do deactivate
            }

            

            

    }
    // Let's start the plugin
    global $pushup;
    $pushup = new Pushup();
}
?>