<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>grecus</title>
        <?php include 'php/db.php'; ?>
    </head>
    <body>
    <?php
if (isset($_SESSION['user_id'])) { 
    include './php/navbar.php'; 
} else { 
    include './php/secondeNav.php'; 
}
?>


        <main>
          
        </main>
       <?php include 'php/footer.php'; ?>
    </body>
</html>