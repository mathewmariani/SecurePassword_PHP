<?php
/**
 * Simple, unobtrusive, and secure login and registration PHP.
 *
 * Future Plans:
 * - More Comments
 * - Better Security
 * - Single email registration
 * - Sessions
 *
 * @author Mathew 'matty' Mariani
 */

// include the configs
require_once("config/database.php");

// include the user class
require_once("classes/user.php");

if (isset($_POST['register']) || isset($_POST['validate'])) {
    $user = new user();
}
?>

<!-- register form -->
<form method="post" action="index.php">
    <!-- the user name input field uses a HTML5 pattern check -->
    <label for="login_input_username">Email</label>
    <input type="email" name="email" required />

    <label for="login_input_password_new">Password</label>
    <input type="password" name="password" required />

    <input type="submit"  name="register" value="Register" />
    <input type="submit"  name="validate" value="Validate" />
</form>