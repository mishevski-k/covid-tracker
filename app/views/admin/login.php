<?php require APPROOT . "/views/includes/head.php"; ?>
<div class="container">
    <div class="login-container">
        <form action="<?php echo URLROOT . "/admin/login" ?>" method="POST">
            <h1>Admin Login</h1>
            <div class="form-item">
                <label for="name" class="form-label">Username:</label>
                <input type="text" class="form-input" name="name" id="name" placeholder="Username . . . ">
                <?php if(!empty($data)) echo "<p class=form-error>{$data['adminError']}</p>" ?>
            </div>
            <div class="form-item">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-input" name="password" id="password" placeholder="Password . . .">
            </div>
            <div class="form-item">
                <input type="submit" value="Login" class="form-submit">
            </div>
            <a href="<?php echo URLROOT ?>">Back <i class="gg-chevron-left-o"></i></a>
        </form>
    </div>
</div>