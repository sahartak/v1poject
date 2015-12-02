<div class="display_none">
	<div id="dialog_form" class="dialog_content" title="Trade Request">
		<div class="block">
			<div class="section">
				<div class="alert dismissible alert_black">
					<strong><i class="fa fa-asterisk"></i> Please leave your note and alternate contact method here.</strong>
				</div>
			</div>

			<form id="trade_request_form" action="history.php" method="post">
				<fieldset class="label_side">
					<label>Request Details <span>Comments about your request</span></label>
					<div class="clearfix">
						<textarea name="details" class="autogrow"></textarea>
					</div>
				</fieldset>

				<fieldset class="label_side top">
					<label>Alternate Phone <span>Optional alternate phone number</span></label>
					<div>
						<input name="alternate_phone" type="text" />
					</div>
				</fieldset>

				<div class="button_bar clearfix">
					<button type="submit" class="dark green submit_button" onclick="document.getElementById('trade_request_form').submit();">
						<i class="ui-icon ui-icon-check"></i>
						<span>Submit</span>
					</button>
					<button class="dark red close_dialog">
						<i class="ui-icon ui-icon-closethick"></i>
						<span>Cancel</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>