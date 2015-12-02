$(document).ready(function(){
    showOptions();
    
    $('#mail_transport').change(showOptions);
});

function showOptions() {
    var selectedTransport = $('#mail_transport').val();
    
    $('#MainForms .options').hide();
    $('#MainForms .options-' + selectedTransport).show();
}