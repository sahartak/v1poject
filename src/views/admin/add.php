<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/admins.js"></script>

<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b><?php echo (($admin_id > 0) ? 'Editing' : 'Creating New'); ?> Administrator</b></div> 
    
    <form name="addNewAdmin" method="POST" id="MainForms" action="">
        <fieldset class="mainFormHolder">
            <legend>User information</legend>
            <div class="formsLeft">REF #:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="ref" id="ref" value="<?php echo array_get($data, 'ref'); ?>" />
            </div>
            <br />
            <div class="formsLeft">Username:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="username" id="username" value="<?php echo array_get($data, 'username'); ?>" />
            </div>
            <br />
            <div class="formsLeft">Password:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="password" id="password" value="<?php echo array_get($data, 'password'); ?>" />
            </div>
            <br />
            <div class="formsLeft">Names:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="name" id="names" value="<?php echo array_get($data, 'name'); ?>" />
            </div>
            <br />
            <div class="formsLeft">Email:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="email" id="email" value="<?php echo array_get($data, 'email'); ?>" />
            </div>
            <br />
            <div class="formsLeft">Status:</div>
            <div class="formsRight">
                <?php echo create_select('status', array(0 => 'Not active', 1 => 'Active'), array('default' => array_get($data, 'status'), 'class' => 'text-input')) ?>
            </div>
            <br />
            <div class="formsLeft">Type:</div>
            <div class="formsRight">
                <?php echo create_select('type', array('owner' => 'Owner', 'editor' => 'Editor'), array('default' => array_get($data, 'type'), 'class' => 'text-input')) ?>
            </div>
            <br />
            <div class="formsLeft">Contacts:</div>
            <div class="formsRight">
                <textarea class="text-area" name="contacts" id="contacts"><?php echo array_get($data, 'contacts'); ?></textarea>
            </div>
            <br />
            <div class="formsLeft">Notes:</div>
            <div class="formsRight">
                <textarea class="text-area" name="notes" id="notes"><?php echo array_get($data, 'notes'); ?></textarea>
            </div>
            <input type="hidden" name="_form_submit" value="1" />
            <input type="submit" name="_submit" value="<?php echo getLang('sform_savebtn'); ?>" class="submitBtn ui-state-default" />
            
            <?php if ($admin_id > 0): ?>
                <input type="hidden" name="adid" value="<?php echo $admin_id; ?>">
                <input type="button" name="_delete" value="<?php echo getLang('sform_delbtn'); ?>" class="submitBtn ui-state-default" onclick="if(confirm('Are you sure you want to delete this administrator?')) location='?action=delete&aid=<?php echo array_get($data, 'id'); ?>';" />
                <input type="button" name="_logs" value="<?php echo getLang('sform_logsbtn'); ?>" class="submitBtn ui-state-default" onclick="location='?action=logs&aid=<?php echo array_get($data, 'id'); ?>';" />
            <?php endif; ?>
            <input type="button" name="_cancel" value="<?php echo getLang('sform_backbtn'); ?>" class="submitBtn ui-state-default" onclick="location='users_admins.php';" />
        </fieldset>
    </form>
</div>