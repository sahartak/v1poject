<?php $refresh = isset($refresh) ? $refresh : false; ?>

<div class="display_none">
	<div id="manage-watchlist" class="dialog_content wide" title="Manage Watch List">
		<div class="block lines">
            <div class="columns clearfix no_lines">
                <form id="add_stock_form" action="stocks.php" method="post">
                    <div class="col_60">
                        <fieldset class="label_top">
                            <label>Add a Stock</label>
                            <div class="clearfix">
                                <input id="stock-name" name="stock" type="text" autocomplete="off" class="stock-autocomplete" />
                                <input id="stock-exch" name="exch" type="hidden" class="stock-exch" />
                            </div>
                        </fieldset>
                    </div>

                    <div class="col_40 no_border_right">
                        <fieldset class="label_top empty_label right">
                            <div class="clearfix">
                                <button type="submit" class="add-watch has_text dark green submit_button">
                                    <i class="ui-icon ui-icon-check"></i>
                                    <span>Add</span>
                                </button>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="block lines">
            <div class="columns clearfix">
                <div class="col_100">
                    <table id="stock-list" class="static">
                        <thead>
                            <tr>
                                <th>Stocks in Watchlist</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stocks as $id => $name): ?>
                                <tr>
                                    <td><strong><?php echo $name; ?></strong></td>
                                    <td class="text-center">
                                        <button class="delete-watch icon_only div_icon" data-id="<?php echo $id; ?>"><div class="ui-icon ui-icon-trash"></div></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="button_bar clearfix">
            <button id="close-manage" class="dark red close_dialog send_right <?php echo $refresh ? 'refresh' : ''; ?>">
                <i class="ui-icon ui-icon-closethick"></i>
                <span>Close</span>
            </button>
        </div>
	</div>
</div>

<script id="stock-row" type="text/html">
    <tr>
        <td><%= name %></td>
        <td class="text-center">
            <button class="delete-watch icon_only div_icon" data-id="<%= id %>"><div class="ui-icon ui-icon-trash"></div></button>
        </td>
    </tr>
</script>

<script type="text/javascript" src="js/stock.autocomplete.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var list  = $('#stock-list');
        
        $('.add-watch').click(function(e){
            e.preventDefault();
            
            var stock = $('#stock-name');
            var exch = $('#stock-exch');
            
            if (stock.val() !== '' && exch.val() !== '') {
                ajaxCallPost('addStockwatch', {stock: stock.val(), exch: exch.val()}, function(r){
                    if (r.success) {
                        var template = $('#stock-row').html();
                        list.find('tbody').append(_.template(template, r));
                        
                        $('table.static tr').removeClass("even");
                        $('table.static tr:even').addClass("even");
                        
                        stock.val('');
                    }
                });
            }
        });
        
        list.on('click', '.delete-watch', function(e){
            e.preventDefault();
            
            var that = $(this);
            
            ajaxCallPost('removeStockwatch', {id: that.data('id')}, function(r){
                if (r.success) {
                    that.parent().parent().remove();
                    
                    $('table.static tr').removeClass("even");
                    $('table.static tr:even').addClass("even");
                }
            });
        });
    });
</script>