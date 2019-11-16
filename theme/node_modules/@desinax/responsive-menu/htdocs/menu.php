<!-- main menu -->
<ul id="<?= $id ?>" class="<?= $class ?>">

    <!-- menu item -->
    <li><a href="index.php?page=home" title="Some title 1">Home</a></li>

    <!-- menu item with submenu -->
    <li class="rm-submenu" >
        <a class="rm-submenu-button" href="#" title="Display submenu"></a>
        <a href="#" title="Some title 2">Test with submenu</a>

        <!-- sub item -->
        <ul>
            <!-- menu item -->
            <li><a href="index.php?page=item-1" title="Some item 1">Item 1</a></li>

            <!-- menu item with submenu -->
            <li class="rm-submenu" >
                <a class="rm-submenu-button" href="#" title="Display submenu"></a>
                <a href="#" title="Some title 2">Test with nested submenu</a>

                <!-- sub item -->
                <ul class="rm-submenu-level-1">
                    <!-- menu item -->
                    <li><a href="index.php?page=item-11" title="Some item 11">Item 11</a></li>

                    <!-- menu item -->
                    <li><a href="index.php?page=item-12" title="Some item 12">Item 12</a></li>

                    <!-- menu item -->
                    <li><a href="index.php?page=item-13" title="Some item 13">Item 13</a></li>
                </ul>
            </li>

            <!-- menu item -->
            <li><a href="index.php?page=item-2" title="Some item 2">Item 2</a></li>
        </ul>

    </li>

    <!-- menu item -->
    <li><a href="index.php?page=about" title="About">About</a></li>
</ul>
