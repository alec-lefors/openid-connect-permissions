<?php
/**
 * WordPress OpenID Connect Permissions
 *
 * Set user role and allow access from OpenID user claims.
 *
 * @category WordPress_Plugin
 * @package  openid-connect-permissions
 * @author   Alec LeFors <alec@lefors.me>
 * @license  GPLv3 <https://www.gnu.org/licenses/gpl-3.0.en.html>
 * @link     https://github.com/alec-lefors/openid-connect-permissions
 *
 * @wordpress-plugin
 * Plugin Name:  WordPress OpenID Connect Permissions
 * Plugin URI:   https://github.com/alec-lefors/openid-connect-permissions
 * Description:  Set user role and allow access from OpenID user claims.
 * Version:      1.0.0
 * Author:       Alec LeFors
 * License:      GPLv3 <https://www.gnu.org/licenses/gpl-3.0.en.html>
 * Requires PHP: 8.2
 */


defined('WPINC') || die;
require_once __DIR__ . '/vendor/autoload.php';

add_filter('openid-connect-generic-user-login-test', function($result, $userClaim) {
    if($userClaim['access_wordpress'] ?? false) {
        return $result;
    }

    return false;
}, 10, 2);

add_action('openid-connect-generic-update-user-using-current-claim', function($user, $userClaim) {
    if($role = $userClaim['wp_user_role'] ?? false) {
        $user->set_role($role);
    }
}, 10, 2);