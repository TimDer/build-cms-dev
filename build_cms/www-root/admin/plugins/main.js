$('#no_space_allowed').on('keypress', function(e) {
    if ( e.which == 32 ){
        alert('Spaces are not allowed in this field');
        return false;
    }
    else if ( String.fromCharCode(e.keyCode) === "/" || String.fromCharCode(e.keyCode) === "\\" ) {
        alert('Slashes are not allowed in this field');
        return false;
    }
});