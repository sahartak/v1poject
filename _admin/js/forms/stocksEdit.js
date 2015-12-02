jQuery.expr[':'].focus = function( elem ) {
    return elem === document.activeElement && ( elem.type || elem.href );
};

$(document).ready(function(){
    var currentStock;
    var create = $('#create');
    
    $("#create-date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
    
    $('#stock').change(function(){
        currentStock = $(this).val();
        
        if (currentStock != undefined) {
            loadDetails(currentStock);
            create.show()
        }
        else {
            create.hide();
        }
    });
    
    $('#createNew').click(function(){
        var dateField = $('#create-date');
        var valueField = $('#create-value');
        
        var error = false;
        
        if ( ! /[0-9]{4}\-[0-9]{2}\-[0-9]{2}/.test(dateField.val())) {
            if (dateField.parent().find('.error').length == 0) {
                dateField.parent().append('<div class="error">Please enter a date in yyyy-mm-dd format.</div>');
            }
            
            error = true;
        }
        else {
            dateField.parent().find('.error').remove();
        }
        
        if ( ! /[0-9\.\,]+/.test(valueField.val())) {
            if (valueField.parent().find('.error').length == 0) {
                valueField.parent().append('<div class="error">Please enter a value.</div>');
            }
            
            error = true;
        }
        else {
            valueField.parent().find('.error').remove();
        }
        
        if (!error) {
            $.ajax({
                url : AJAX_URL + '?action=ajax_create',
                type : 'POST',
                dataType : 'json',
                data : {
                    stock: currentStock,
                    value: valueField.val(),
                    date: dateField.val()
                },
                success : function(r) {
                    if (r.result != false) {
                        $('#details tbody').prepend(_.template($('#detail_tpl').html(), r.detail));
                        
                        valueField.val('');
                        dateField.val('');
                    }
                }
            });
        }
    });
    
    $('#details td').live('dblclick', function(){
        if (!$(this).hasClass('in')) {
            $(this).addClass('in');
            
            var id = $(this).parent().attr('data-id');
            var type = $(this).attr('data-type');
            var data = $(this).html();

            $(this).html('<input class="edit edit-' + type + '" type="text" value="' + data + '" data-id="' + id + '" data-type="' + type + '" data-value="' + data + '" />');
            
            $('#details .edit-date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });
        }
    });
    
    $('body').click(function(e){
        if (
            !$(e.target).hasClass('edit') &&
            !$(e.target).hasClass('in') &&
            !$(e.target).hasClass('ui-datepicker-div') &&
            $(e.target).parents('.ui-datepicker-div').length == 0
        ) {
            editDetails();
        }
    });
    
    $('body').keyup(function(e){
        if (e.keyCode == 13) {
            editDetails();
        }
    });
});

function editDetails() {
    var edits = $('#details').find('input.edit');
            
    _.each(edits, function(item) {
        var itm = $(item);
        itm.attr('disabled', 'disabled');

        $.ajax({
            url: AJAX_URL + '?action=ajax_edit',
            type : 'POST',
            dataType : 'json',
            data : {
                id: itm.attr('data-id'),
                value: itm.val(),
                type: itm.attr('data-type')
            },
            success : function(r) {
                var td = itm.parent();

                if (r.result != false) {
                    itm.remove();
                    td.html(r.value).removeClass('in');
                }
                else {
                    var value = itm.attr('data-value');
                    itm.remove();
                    td.html(value).removeClass('in');
                }
            }
        });
    });
}

function loadDetails(stock) {
    var container = $('#details');
    container.html('');
    
    $.getJSON(AJAX_URL, {action: 'ajax_details', id: stock}, function(r){
        var string = '';
        var template = _.template($('#detail_tpl').html());
        
        _.each(r, function(item){
            string += template(item);
        });
        
        container.append(_.template($('#details_tpl').html(), {content: string}));
    });
}