<?php
// show potential errors / feedback (from registration object)
if (isset($_POST['register'])) {
    $user = new user();
} elseif(isset($_POST['validate'])) {
    $user = new user();
}
?>

<!-- register form -->
<form method="post" action="./base_view.php">
    <!-- the user name input field uses a HTML5 pattern check -->
    <label for="login_input_username">Email</label>
    <input type="email" name="email" required />

    <label for="login_input_password_new">Password</label>
    <input type="password" name="password" required />

    <input type="submit"  name="register" value="Register" />
    <input type="submit"  name="validate" value="Validate" />
</form>