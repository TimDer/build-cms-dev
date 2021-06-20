<div class="header_text">
    <h1>Menus</h1>
</div>

<div class="main_container">
    <div class="tab_links">
        <div class="tab" tab_toggle="#edit_menu">
            Edit menu
        </div>
        <div class="tab" tab_toggle="#manage_menu">
            Manage menus
        </div>
    </div>

    <div class="tab_container">
        <div class="edit_container menu_container active" id="edit_menu">
            <?php controller::getView("/edit.php", __DIR__); ?>
        </div>
        <div class="manage_container menu_container" id="manage_menu">
            <?php controller::getView("/add.php", __DIR__); ?>
        </div>
    </div>
</div>