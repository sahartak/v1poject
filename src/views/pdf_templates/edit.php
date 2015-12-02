<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default">
        <b>Editing PDF Template - <?php echo $template['name']; ?></b>
    </div>
    
    <form method="POST" id="MainForms" action="">

        <fieldset class="mainFormHolder left" style="width:800px;">
            <legend>Content</legend>
            
            <div class="formsLeft">Theme:</div>
	        <div class="formsRight">
				<select name="template[pdf_external_id]" id="PdfTemplate" class="text-input"><?php echo $selectTemplateHtml; ?></select>
			</div>
            <br />
            <div class="formsLeft">HTML Content:</div>
            <div class="formsRight">
            	<br />
            	<textarea id="pdf_content_html" class="widearea tallarea mceEditor"><?php echo htmlentities(array_get($template, 'content')); ?></textarea>
        	</div>
        	<br />
			<div class="formsLeft">Plain Text Content:</div>
			<div class="formsRight">
				<br />
            	<textarea name="template[content]" id="pdf_content_plain" class="widearea tallarea"><?php echo htmlentities(array_get($template, 'content')); ?></textarea>
        	</div>
        </fieldset>
        <fieldset class="mainFormHolder left" style="width: 300px;">
        	<legend>Variables</legend>
        	
			<?php if(count($templateVariables) == 0){ ?>
        		<p>Variables are not defined for this template type.</p>
        	<?php }else{ ?>
        	<ul class='variable_list'>
        		<?php foreach($templateVariables as $var){ ?>
        			<li>{<?php echo $var; ?>}</li>
        		<?php }?>
        	</ul>
        	<?php } ?>
        </fieldset>
        <br class="clear" />
        
        <input type="hidden" name="id" value="<?php echo array_get($template, 'id'); ?>" />
        
        <input type="hidden" name="_form_submit" value="1" />
        <input type="submit" name="_submit" value="<?php echo getLang('sform_savebtn'); ?>" class="submitBtn ui-state-default" />
        <input type="button" name="_cancel" value="<?php echo getLang('sform_backbtn'); ?>" class="submitBtn ui-state-default" onclick="location='pdf_templates.php';" />
    </form>
</div>
<script type="text/javascript">
var pdfDefaultHtml;
var pdfDefaultText;
var xhr;

$(document).ready(function(){
    $("#PdfTemplate").change(function(){
        if(xhr){
			xhr.abort();
        }
        showTemplate();
    });
});

function showTemplate(){
	var externalId = $("#PdfTemplate").val();
	if(externalId == ""){
		tinyMCE.get("pdf_content_html").setContent(pdfDefaultHtml, {format : "raw"});
		$("#pdf_content_plain").html(pdfDefaultText);
		return;
	}
	tinyMCE.get("pdf_content_html").setContent("loading...", {format : "raw"});
	$("#pdf_content_plain").html("loading...");

	xhr = $.ajax({
		type:"post",
		url: "ajax_theme.php",
		dataType: "json",
		data: {action: "GetTemplateById" ,templateId : externalId },
		success: function(data) {
            tinyMCE.get("pdf_content_html").setContent(data.html, {format : "raw"});
      		$("#pdf_content_plain").html(data.text);
       	}
	});
}

tinyMCE.init({
	mode : "textareas",
   	theme : "advanced",
  	editor_selector : "mceEditor",
   	readonly : true,
   	visual: false,
   	setup : function(ed) {
        ed.onInit.add(function(ed) {
        	pdfDefaultHtml = tinyMCE.get("pdf_content_html").getContent();
           	pdfDefaultText = $("#pdf_content_plain").html();
        	showTemplate();
        });
     }
});
</script>