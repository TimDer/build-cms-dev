<div class="edit_header">
    <h1>Edit pages</h1>
</div>

<div class="container">

    <form class="search-bar" id="search-bar">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Edit / Delete</th>
                <th class="table-data">Date (American format)</th>
            </tr>
        </thead>
        <tbody>
            <?php echo edit_page::get_pages_table(); ?>
        </tbody>
    </table>

</div>