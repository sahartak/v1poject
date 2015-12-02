<div class="mainHolder">
    <div class="hintHolder ui-state-default">
        <b>Editing Front-end Settings</b>
    </div>
    
    <form method="POST" id="MainForms" action="">

        <fieldset class="mainFormHolder">
            <legend>Segment.io Settings</legend>
            
            <div class="formsLeft">API write key:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[segment_write_key]" id="segment_write_key" value="<?php echo array_get($settings, 'segment_write_key'); ?>" autocomplete="off" />
            </div>
        </fieldset>
        
        <input type="hidden" name="_form_submit" value="1" />
        <input type="submit" name="_submit" value="<?php echo getLang('sform_savebtn'); ?>" class="submitBtn ui-state-default" />
        <input type="button" name="_cancel" value="<?php echo getLang('sform_backbtn'); ?>" class="submitBtn ui-state-default" onclick="location='settings_other.php';" />
    </form>
</div>