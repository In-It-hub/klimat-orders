
    <!--***** MENU *****-->
<nav class="navbar box-shadow-y" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold has-text-black" href="">KLIMAT +</a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
    </div>
<?php 
    $crud = new CRUD();
    $menu = $crud->read('menu');
?>
    <div id="navbarBasicExample" class="navbar-menu has-background-white">
        <div class="navbar-start">
            <?php 
                foreach ($menu['entries'] as $entry) {
                    if(in_array($_SESSION['group'], $entry['access'])){
                        echo "<a class='navbar-item";
                        if($entry['link'] == $action){
                            echo " active";
                        }
                                echo "' href='/".$entry['link']."'>";
                        echo $entry['icon'] . $entry['name'] ."</a>";
                    }
                }
            ?>
        </div>

       <!-- <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                <a class="button is-primary">
                    <strong>Sign up</strong>
                </a>
                <a class="button is-light">
                    Log in
                </a>
                </div>
            </div>
        </div>-->
    </div>
</nav>
    <!--***** END MENU *****-->