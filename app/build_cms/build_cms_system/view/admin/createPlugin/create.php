<div class="plugins_header">
    <h1>Create a new plugin</h1>
</div>


<div class="plugins_main_container">
    <form action="/admin_submit/plugins/create" method="post" class="td-ajax form_container">
        <p>Plugin name:</p>
        <input type="text" name="plugin_name" required>
        <p>Plugin directory name:</p>
        <input type="text" name="directory_name" id="no_space_allowed" required>
        <p>Plugin description:</p>
        <input type="text" name="description" required>

        <input type="submit" value="Add plugin">
    </form>
    
</div>