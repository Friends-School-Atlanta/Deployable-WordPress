<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2>Genesis Scrolling Notifications</h2>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Your Options</span></h3>
						<div class="inside">
							<form name="gsn_options_form" method="post" action="">
	
								<input type="hidden" name="gsn_form_submitted" value="Y">

								<table class="form-table">
									<tr>
										<td>
											<strong><label for="gsn_show_home">Homepage?</label></strong><br>
											<input name="gsn_show_home" type="checkbox" id="gsn_show_home" value="1" <?php checked( $gsn_show_home, 1 ); ?> />
											<small>If this is checked then the notifications will only display on the homepage.</small>
										</td>
									</tr>

									<tr>
										<td>
											<strong><label for="wpz_bg_color">Notification Bar Background Color?</label></strong><br>
											<input name="gsn_bg_color" id="gsn-bg-color" value="<?php echo $gsn_bg_color; ?>" />
										</td>
									</tr>
								</table>
								<p>
									<input class="button-primary" type="submit" name="gsn_submit" value="Save" /> 
								</p>
							</form>
						
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				
				<div class="meta-box-sortables">
					
					<div class="postbox">
					
						<h3><span>Sidebar Content Header</span></h3>
						<div class="inside">
							Content space
						</div> <!-- .inside -->
						
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
	
</div> <!-- .wrap -->