<div class="mainHolder">
    <div class="hintHolder ui-state-default">
        <b>Editing PDF Settings</b>
    </div>
    
    <form method="POST" id="MainForms" action="" enctype="multipart/form-data">
    	<fieldset class="mainFormHolder wide">
            <legend>Sendwithus Settings</legend>
            
            <div class="formsLeft">API Key:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[pdf_sendwithus_key]" id="pdf_sendwithus_key" value="<?php echo htmlentities(array_get($settings, 'pdf_sendwithus_key')); ?>" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">Tags:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[pdf_sendwithus_tags]" id="pdf_sendwithus_tags" value="<?php echo htmlentities(array_get($settings, 'pdf_sendwithus_tags')); ?>" autocomplete="off" />
            </div>
        </fieldset>
		
        <fieldset class="mainFormHolder wide">
            <legend>PDF Header</legend>
            
            <textarea name="options[pdf_header]" id="pdf_header" class="widearea"><?php echo htmlentities(array_get($settings, 'pdf_header')); ?></textarea>
        </fieldset>
        
        <fieldset class="mainFormHolder wide">
            <legend>PDF Footer</legend>
            
            <textarea name="options[pdf_footer]" id="pdf_footer" class="widearea"><?php echo htmlentities(array_get($settings, 'pdf_footer')); ?></textarea>
        </fieldset>
        
        <fieldset class="mainFormHolder wide">
            <legend>Logo</legend>
            
            <div class="formsLeft">Logo image:</div>
            <div class="formsRight">
                <input class="text-input" type="file" name="options[pdf_logo]" id="pdf_logo" />
            </div>
            
            <br />
            
            <?php if (array_get($settings, 'pdf_logo') !== null): ?>
                <img src="<?php echo $uploadUrl . $settings['pdf_logo']; ?>" alt="" style="max-width: 200px; max-height: 200px;" />
            <?php endif; ?>
        </fieldset>
        
        <input type="hidden" name="_form_submit" value="1" />
        <input type="submit" name="_submit" value="<?php echo getLang('sform_savebtn'); ?>" class="submitBtn ui-state-default" />
        <input type="button" name="_cancel" value="<?php echo getLang('sform_backbtn'); ?>" class="submitBtn ui-state-default" onclick="location='settings_pdf.php';" />
    </form>
</div>