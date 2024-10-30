<?php
/*
Plugin Name: IzzyHelp Handy Helpdesk
Plugin URI: http://www.izzyhelp.com/
Description: Handy Help Bar, instant FAQ and Submit-a-Ticket System
Version: 1.0
Author: IzzyHelp.com
Author URI: http://www.izzyhelp.com/
*/
	
	if(!is_admin()){
		// we're not in admin area,
		// add IzzyHelp code to the bottom of page
		add_action('wp_print_scripts', 'IzzyHelp_filter_footer');
	}
	
	
	
	// add IzzyHelp menu in admin
	add_action('admin_menu', 'IzzyHelp_config_page');

	
	function IzzyHelp_filter_footer() {
		
		$IzzyHelp_HelpdeskID = get_option('IzzyHelpHelpdeskID');
		$IzzyHelp_HelpdeskUID = get_option('IzzyHelpHelpdeskUID');
		$IzzyHelp_HelpdeskCode = get_option('IzzyHelpHelpdeskCode');
		$IzzyHelp_hosted = get_option('IzzyHelpToolbarHosted');
		$IzzyHelp_enabled = get_option('IzzyHelpToolbarEN');
		
		if($IzzyHelp_enabled){
			
			// user has enabled the plugin.
			if($IzzyHelp_hosted==1 && $IzzyHelp_HelpdeskID != ''){
				// hosted in IzzyHelp's cloud...
				$displayIzzyHelp="<script type=\"text/javascript\">(function(){
						function izzyHelpAsync_load(){
							var s = document.createElement('script');
							s.type = 'text/javascript';
							s.async = true;
							s.src = 'http://help.start.$IzzyHelp_HelpdeskUID.izzyhelp.com/?id=$IzzyHelp_HelpdeskID';
							var x = document.getElementsByTagName('script')[0];
							x.parentNode.insertBefore(s, x);
						}
						if (window.attachEvent)
						window.attachEvent('onload', izzyHelpAsync_load);
						else
						window.addEventListener('load', izzyHelpAsync_load, false);
					})();
					</script>";
			} elseif ($IzzyHelp_hosted==2 && $IzzyHelp_HelpdeskCode != ''){
				
				$displayIzzyHelp=$IzzyHelp_HelpdeskCode;
				
			}
			
			
			echo $displayIzzyHelp;
			
		}
			
			
			
	
	}

	function IzzyHelp_config_page(){
		add_submenu_page('themes.php', __('IzzyHelp Support Center'), __('IzzyHelp Support Center'), 'manage_options', 'IzzyHelp-key-config', 'IzzyHelp_config');
	}

	function IzzyHelp_config(){
		
		$IzzyHelp_HelpdeskID = get_option('IzzyHelpHelpdeskID');
		$IzzyHelp_HelpdeskUID = get_option('IzzyHelpHelpdeskUID');
		$IzzyHelp_HelpdeskCode = get_option('IzzyHelpHelpdeskCode');
		$IzzyHelp_hosted = get_option('IzzyHelpToolbarHosted');
		$IzzyHelp_enabled = get_option('IzzyHelpToolbarEN');
	
		if ( isset($_POST['submit']) ) {
			if (isset($_POST['HelpdeskID']))
			{
				$IzzyHelp_HelpdeskID = $_POST['HelpdeskID'];
				$IzzyHelp_HelpdeskUID = $_POST['HelpdeskUID'];
				$IzzyHelp_HelpdeskCode = stripslashes($_POST['HelpdeskCode']);

				if ($_POST['IzzyHelp_hosted'] == '1')
					$IzzyHelp_hosted=1;
				else
					$IzzyHelp_hosted=2;
					
				
				if ($_POST['IzzyHelp_enabled'] == 'on')
				{
					$IzzyHelp_enabled = 1;
				}
				else
				{
					$IzzyHelp_enabled = 0;
				}
			}
			else
			{
				$IzzyHelp_HelpdeskID = '';
				$IzzyHelp_HelpdeskUID = '';
				$IzzyHelp_HelpdeskCode = '';
				$IzzyHelpToolbarHosted = 0;
				$IzzyHelp_enabled = 0;
			}
			
			update_option('IzzyHelpHelpdeskID', $IzzyHelp_HelpdeskID);
			update_option('IzzyHelpHelpdeskUID', $IzzyHelp_HelpdeskUID);
			update_option('IzzyHelpHelpdeskCode', $IzzyHelp_HelpdeskCode);
			update_option('IzzyHelpToolbarEN', $IzzyHelp_enabled);
			update_option('IzzyHelpToolbarHosted', $IzzyHelp_hosted);
			
			echo "<div id=\"updatemessage\" class=\"updated fade\"><p>IzzyHelp Configuration Saved.</p></div>\n";
			echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
		}
		?>
        <style>
		
		.inside td {padding:5px;}
		.izzyTip { padding:10px; color:#F30; background: #FFC; border:1px solid #FC0; width:200px; font-size:10px;}
		</style>
        
		<div class="wrap">
			<h2>IzzyHelp Support Center for WordPress &raquo; Configuration</h2>
			<div class="postbox-container">
				<div class="metabox-holder">	
					<div class="meta-box-sortables">
						<form action="" method="post" id="IzzyHelp-conf">
						<div id="IzzyHelp_settings" class="postbox">
							<div class="handlediv" title="Click to toggle"><br /></div>
							<h3 class="hndle"><span>IzzyHelp Settings</span></h3>
							<div class="inside">
                            <table>
									
									<tr>
									  <th valign="top" scrope="row">&nbsp;</th>
									  <td valign="top">&nbsp;</td>
									  <td valign="top">&nbsp;</td>
							  </tr>
									<tr><th valign="top" scrope="row" width="180"><label for="HelpdeskType">Your IzzyHelp is:</label></th>
									  <td valign="top"><input type="radio" value="1" id="IzzyHelp_hosted1" name="IzzyHelp_hosted" <?php if($IzzyHelp_hosted==1||!$IzzyHelp_hosted) echo ' checked="checked"'; ?> /></td>
									<td valign="top"><label for="IzzyHelp_hosted1">Hosted on IzzyHelp.com servers</label></td></tr>
									<tr>
									  <th valign="top" scrope="row">&nbsp;</th>
									  <td valign="top"><input type="radio" value="2" id="IzzyHelp_hosted2" name="IzzyHelp_hosted" <?php if($IzzyHelp_hosted==2) echo ' checked="checked"'; ?> /></td>
									  <td valign="top"><label for="IzzyHelp_hosted2">Hosted on my own server</label></td>
								  </tr>
									<tr>
									  <th valign="top" scrope="row">&nbsp;</th>
									  <td valign="top">&nbsp;</td>
									  <td valign="top">&nbsp;</td>
								  </tr>
								</table>
                                <script type="text/javascript">
								function checkHostedOption(){
									
									if(jQuery("#IzzyHelp_hosted1").attr("checked")==true){
										jQuery("#hostedInCloud").show();
										jQuery("#hostedOnServer").hide();
										
									} else {
										jQuery("#hostedInCloud").hide();
										jQuery("#hostedOnServer").show();
									}
									
								}
								jQuery(function(){checkHostedOption();})
								
								jQuery("#IzzyHelp_hosted1,#IzzyHelp_hosted2").change(function(){
									
									checkHostedOption();
									
								})
								
								</script>
								<table id="hostedInCloud">
                                    
                                    
                                    
                                    
									<tr><th valign="top" scrope="row" width="180"><label for="HelpdeskID">IzzyHelp Helpdesk ID:</label></th>
									<td valign="top"><input id="HelpdeskID" name="HelpdeskID" type="text" size="20" maxlength="40" value="<?php echo $IzzyHelp_HelpdeskID; ?>"/></td>
									<td rowspan="2" valign="top"><div class="izzyTip">Please login to your IzzyHelp dashboard, and go to Installation tab, you'll find both Helpdesk ID and User ID there.</div></td>
									</tr>
                                    <tr><th valign="top" scrope="row"><label for="HelpdeskUID">IzzyHelp User ID:</label></th>
									<td valign="top"><input id="HelpdeskUID" name="HelpdeskUID" type="text" size="20" maxlength="40" value="<?php echo $IzzyHelp_HelpdeskUID; ?>"/></td>
									</tr>
								</table>
                                
                                
                                <table id="hostedOnServer">
									
									<tr><th valign="top" scrope="row" width="180"><label for="HelpdeskCode">IzzyHelp Installation Code:</label></th>
								  <td valign="top"><textarea id="HelpdeskCode" name="HelpdeskCode"><?php echo $IzzyHelp_HelpdeskCode; ?></textarea></td>
								  <td valign="top"><div class="izzyTip">Please login to your IzzyHelp dashboard, and go to Installation tab, you'll find installation code there, copy it to clipboard (Ctrl+C) and paste here (Ctrl+V)</div></td>
								  </tr>
							  </table>
                              
                              <table>
                                    <tr>
                                    <th valign="top" scrope="row" width="180">&nbsp;</th>
									<td valign="top">
                                    
                                        <table><tr>
                                        <td><input type="checkbox" id="IzzyHelp_enabled" name="IzzyHelp_enabled" <?php if($IzzyHelp_enabled) echo ' checked="checked"'; ?> /></td><td><label for="IzzyHelp_enabled">Yes, Show  IzzyHelp Toolbar on my website</label></td>
                                        </tr></table>
                                    
                                    </td></tr>
                                    <tr>
                                      <th valign="top" scrope="row">&nbsp;</th>
                                      <td valign="top">						<div class="submit"><input type="submit" class="button-primary" name="submit" value="Save Changes" /></div>
</td>
                                    </tr>
							  </table>
                              
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
} 
?>