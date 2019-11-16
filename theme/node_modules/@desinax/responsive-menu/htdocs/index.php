<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
.header {
    float: left;
}

main {
    min-height: 60em;
}
</style>



<body>

    <div style="height: 100px; background-color: #ddd;">
        <span class="header"><b style="font-size: 2em;">SiteTitle</b></span>


        <!-- menu wrapper for standard navigation bar -->
        <div class="rm-navbar1 rm-navbar">
            <?php
            $id = "";
            $class = "rm-default rm-desktop";
            include __DIR__ . "/menu.php";
            ?>
        </div>



        <!-- menu wrapper for mobile small menu -->
        <div class="rm-navbar2 rm-navbar rm-max rm-swipe-right">

            <!-- memu click button -->
            <div class="rm-small-wrapper">
                <ul class="rm-small">
                    <li><a id="rm-menu-button" class="rm-button" href="#">
                        <i class="fa fa-bars rm-button-face-1"></i>
                        <i class="fa fa-times rm-button-face-2"></i>
                    </a></li>
                </ul>
            </div>

            <?php
            $id = "rm-menu";
            $class = "rm-default rm-mobile";
            include __DIR__ . "/menu.php";
            ?>

        </div>

    </div> <!-- header -->
    
    <main>
        <p><?= isset($_GET["page"]) ? htmlentities($_GET["page"]) : "home" ?></p>
    </main>

    <script src="js/responsive-menu.min.js"></script>

</body>
</html>
