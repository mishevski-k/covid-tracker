<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <div class="main-container">
        <?php require APPROOT . "/views/pages/worldwide-banner.php" ?>
        <div class="dashboard-container">
            <div class="actions">
                <div class="action create-action">
                    <form action="<?php echo URLROOT ?>/countries/create/countries" method="POST">
                        <input type="submit" value="Create Countries table">
                    </form>
                </div>
                <div class="action create-action">
                    <form action="<?php echo URLROOT ?>/countries/create/cases" method="POST">
                        <input type="submit" value="Create Cases table">
                    </form>
                </div>
                <div class="action create-action">
                    <form action="<?php echo URLROOT ?>/countries/create/global" method="POST">
                        <input type="submit" value="Create Global cases table">
                    </form>
                </div>
                <div class="action import-action">
                    <form action="<?php echo URLROOT ?>/countries/import/countries" method="POST">
                        <input type="submit" value="Import countries">
                    </form>
                </div>
                <div class="action import-action">
                    <form action="<?php echo URLROOT ?>/countries/import/data" method="POST">
                        <input type="submit" value="Import data">
                    </form>
                </div>
            </div>
            <div class="statistics-container">
                <h1>Current Available tables</h1>
                <div class="tables">
                    <?php  foreach($data['tables'] as $table ): ?>
                        <div class="table">
                            <h1>Table Name: <span><?php echo $table['name'] ?></span></h1>
                            <h1>Table rows: <span><?php echo $table['rowCount'] ?></span></h1>
                            <form action="<?php echo URLROOT . "/countries/delete/" . $table['name'] ?>" method="POST" class="delete"><input type="submit" value="Delete Table"></form>
                        </div>    
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php require APPROOT . "/views/pages/info-display.php" ?>
    </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
</div>

<?php
            
    if($data['message'] != ""){
        echo "<script>alert('$data[message]');</script>";
    }
            
?>