<?php
/**
 * Plugin Name: Members Multisite User Roles Sync
 * Description: This is a simple Multisite add-on for Justin Tadlock's <a href="https://wordpress.org/plugins/members/">Members plugin</a>, which synchronizes user (multiple) roles on all network sites.
 *
 * Author: jeffreyvr
 * Author URI: https://profiles.wordpress.org/jeffreyvr/
 *
 * Version: 0.0.1
 * License: GPLv2 or later
 */
 if ( ! defined( 'ABSPATH' ) )
 {
 	exit; // Exit if accessed directly.
 }

 if ( ! class_exists( 'Members_Mu_User_Roles_Sync' ) && is_multisite() ) :

 class Members_Mu_User_Roles_Sync
 {
   /**
    * Construct
    */
   public function __construct()
   {
     // check if members plugin is active
     if ( function_exists('members_plugin') )
     {
       add_action( 'profile_update', array( $this, 'profile_update'), 10, 1 );
     }
   }

   /**
    * Add role
    * @param int    $user_id
    * @param array  $roles
    * @param boolean $all_sites
    * @return void
    */
   public function add_role( $user_id, $roles = array(), $all_sites = FALSE )
   {
     /*
      * sanitize $roles with 'members_sanitize_role' function in members plugin
      * @link https://github.com/justintadlock/members/blob/69f8c6007d3f6e3017ab4d8c8dc7f96845a88bff/inc/functions-roles.php#L250
      */
     $roles = array_map( 'members_sanitize_role', $roles );

     // current blog id
     $current_blog_id = get_current_blog_id();

     // get list of blogs user is member of
     $blogs = get_blogs_of_user( $user_id );

     if ( $all_sites === FALSE )
     {
       // remove current site from list
       unset( $blogs[$current_blog_id] );
     }

     // loop through blogs
     foreach ( $blogs as $blog ) {
       // switch to blog
       switch_to_blog( $blog->userblog_id );

       // get user info
       $site_user = get_user_by( 'id', $user_id );

       // remove roles
       $site_user->remove_role( '' );

       // loop through roles
       foreach ( $roles as $role ) {
         // add role
         $site_user->add_role( $role );
       }
   }

   // switch back to orgininal blog
   switch_to_blog( $current_blog_id ); 
 }

 /**
  * Profile update
  * @param  int $user_id
  * @return void
  */
 public function profile_update( $user_id )
 {
   if ( isset( $_POST['members_user_roles'] ) ) // data should not be empty
   {
     if ( is_array( $_POST['members_user_roles'] ) ) // data should be an array
     {
       /*
        * now that we know the posted data is an array we can execute the 'add_role' function
        * the data will be sanitized in the 'add_role' function
        */
        $this->add_role( $user_id, $_POST['members_user_roles'], false );
     }
   }
 }
}

new Members_Mu_User_Roles_Sync();

endif;
