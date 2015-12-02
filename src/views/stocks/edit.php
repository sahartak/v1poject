<script type="text/javascript" src="js/forms/stocksEdit.js"></script>

<div class="mainHolder">
    <div class="hintHolder ui-state-default">
        <strong>Editing stock values</strong>
    </div>
    
    <div class="left">        
        <fieldset class="mainFormHolder">
            <legend>Stock</legend>
            
            <div class="formsLeft">Stock:</div>
            <div class="formsRight">
                <?php echo create_select('stock', $stocks, array('empty' => 'Choose stock', 'class' => 'text-input')); ?>
            </div>
        </fieldset>
        
        <div id="details">
        </div>
    </div>
    
    <div id="create" class="left" style="display: none;">
        <fieldset class="mainFormHolder">
            <legend>Add new</legend>
            
            <div class="formsLeft">Date:</div>
            <div class="formsRight">
                <input type="text" name="date" id="create-date" class="text-input" />
            </div>
            
            <br />
            
            <div class="formsLeft">Value:</div>
            <div class="formsRight">
                <input type="text" name="value" id="create-value" class="text-input" />
            </div>
            
            <button id="createNew" class="ui-state-default submitBtn">Save</button>
        </fieldset>
    </div>
</div>

<script type="text/template" id="details_tpl">
    <fieldset class="mainFormHolder">
        <legend>Details (double click to edit)</legend>

        <table class="stockDetailsTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <%= content %>
            </tbody>
        </table>
    </fieldset>
</script>

<script type="text/template" id="detail_tpl">
    <tr data-id="<%= details_id %>">
        <td data-type="date"><%= date %></td>
        <td data-type="value"><%= value %></td>
    </tr>
</script>