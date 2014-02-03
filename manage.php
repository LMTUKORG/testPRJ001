<?php

	include("_php.php");
		
	$mysql = new core_Library\core_Database();
	$core_TextData = new core_Library\core_TextData();
	$string = new core_Library\core_String();
	$system_Config = $core_TextData->jSon("domains/system.config");

?>

<script type="text/javascript" src="Core/JavaScript/jQuery/jQuery.js"></script>

<script>

	$(document).ready(function(){
	
		$("#go").live('click',function(){
			
			var application = "";
			var product = "";
			
			var list = "";
			var listCount = 0;
			
			if($(".application")){
			$(".application").each(function(){
				
				application = $(this).attr("application_Name");
				if($(this).is(':checked')){ list += "appl="+$(this).attr("application_ID")+"|"; listCount++; }
				
					if($("."+application+"_product")){
					$($("."+application+"_product")).each(function(){ 
						
						product = $(this).attr("product_Name");
						if($(this).is(':checked')){ list += "prod="+$(this).attr("product_ID")+"|"; listCount++; }
							
							if($("."+application+"_"+product+"_page")){
							$($("."+application+"_"+product+"_page")).each(function(){
								
								if($(this).is(':checked')){ list += "page="+$(this).attr("page_ID")+"|"; listCount++; }
								
							}); 
							}
					});
					}
			});
			}
			
			list = list.substring(0, list.length - 1);
			$("#rightsCount").val(listCount);
			$("#rights").val(list);
			
			$("#createForm").submit();

		});
	
	});
	
</script>

<?php if(!isset($_POST["action"])){ ?>

CREATE ACCOUNT:<br/><br/>
<form action="manage.php" method="post" id="createForm">
<input type="hidden" name="action" value="create" />
Organisation: <input type="text" name="organisation" /><br />
Domain: <input type="text" name="domain" /><br /><br />

Users Name: <input type="text" name="name" /><br />
Username: <input type="text" name="username" /><br />
Password: <input type="text" name="password" />
<input type="hidden" name="rightsCount" id="rightsCount" />
<input type="hidden" name="rights" id="rights" />
</form><br /><br />

RIGHTS:
<table style="border:1px solid #ccc;">
	<tr valign="top">
		<td style="padding:7px; width:150px;"><input type="checkbox" value="1" class="application" application_Name="controlpanel" application_ID="1" /> Control Panel</td>
		<td>
				<table>
					<tr valign="top">
						<td style="padding:5px; width:125px;"><input type="checkbox" value="1" class="controlpanel_product" product_Name="bookings" product_ID="1" /> Bookings</td>
						<td style="padding:5px; width:125px;">
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="1" /> Dashboard<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="2" /> Diary<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="3" /> Members<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="4" /> Activities<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="5" /> Rooms<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="6" /> Reports<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="8" /> Sign Up<br>
							<input type="checkbox" value="1" class="controlpanel_bookings_page" page_ID="9" /> Sign Out<br>
						</td>
					</tr>
				</table>
				
				<table style="border-top:1px dashed #ddd; padding-top:5px; margin-top:5px;">
					<tr valign="top">
						<td style="padding:5px; width:125px;"><input type="checkbox" value="1" class="controlpanel_product" product_Name="website" product_ID="2" /> Website</td>
						<td style="padding:5px; width:125px;">
							<input type="checkbox" value="1" class="controlpanel_website_page" page_ID="9" /> Pages<br>
							<input type="checkbox" value="1" class="controlpanel_website_page" page_ID="10" /> Reports<br>
						</td>
					</tr>
				</table>
		</td>
	</tr>
</table>

<table style="border:1px solid #ccc; border-top:0px;">
	<tr valign="top">
		<td style="padding:7px; width:150px;"><input type="checkbox" value="1" class="application" application_Name="website" application_ID="2" /> Website</td>
		<td>
				<table>
					<tr valign="top">
						<td style="padding:5px; width:125px;"><input type="hidden" value="1" class="website_product" product_Name="0" product_ID="0" /></td>
						<td style="padding:5px; width:125px;">
							<input type="checkbox" value="1" class="website_0_page" page_ID="10" /> Home<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="11" /> Activities<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="12" /> Rooms<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="13" /> Account<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="14" /> Activity<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="15" /> Room<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="16" /> Sign Up<br>
							<input type="checkbox" value="1" class="website_0_page" page_ID="17" /> Sign In<br>
						</td>
					</tr>
				</table>
		</td>
	</tr>
</table>

<table style="border:1px solid #ccc; border-top:0px;">
	<tr valign="top">
		<td style="padding:7px; width:150px;"><input type="checkbox" value="1" class="application" application_Name="api" application_ID="3" /> API</td>
		<td>
				<table>
					<tr valign="top">
						<td style="padding:7px; width:258px;"><input type="checkbox" value="1" class="api_product" product_Name="bookings" product_ID="3" /> Bookings</td>
					</tr>
				</table>
		</td>
	</tr>
</table>

<div id="go" style="margin-top:20px; height:40px; background-color:#eee; width:150px; border:1px solid #ccc; line-height:40px; text-align:center; cursor:poiner;">CREATE</div>

<?php } ?>



<?php

	if(isset($_POST["action"]) && $_POST["action"] == "create"){
		$_POST["profile"] = "1";
		
		$checkDomain = $mysql->Command("select","SELECT * FROM system_Domains WHERE domain_Name = '".$_POST["domain"]."'");
				
			if($checkDomain["numrows"] == 0){
				
				$hashedUsername = sha1($system_Config["keys"]["hashKey1"].$_POST["username"].$system_Config["keys"]["hashKey2"]);
				$hashedPassword = sha1($system_Config["keys"]["hashKey1"].$_POST["password"].$system_Config["keys"]["hashKey2"]);
				
				print $_POST["organisation"]."<br/>";
				print $_POST["domain"]."<br/>";
				print $hashedUsername."<br/>";
				print $hashedPassword."<br/>";
				print $_POST["name"]."<br/>";
				print $_POST["profile"]."<br/>";
				print $_POST["rightsCount"]."<br/>";
				print $_POST["rights"]."<br/>";
				
				// Create Account
				$addAccount = $mysql->Command("select","CALL account_Create('".$_POST["organisation"]."','".$_POST["domain"]."','".$hashedUsername."','".$hashedPassword."','".$_POST["name"]."','".$_POST["profile"]."','".$_POST["rightsCount"]."','".$_POST["rights"]."')");
				
				if($addAccount["numrows"] > 0){ print "Account Created"; 
				
					// Config jSon	
					$config = '{
						"system":{"status":"open"},
						
						"database":{"server":"'.$system_Config["database"]["server"].'","name":"'.$system_Config["database"]["name"].'","username":"'.$system_Config["database"]["username"].'","password":"'.$system_Config["database"]["password"].'"},
						
						"keys":{"hashKey1":"'.$system_Config["keys"]["hashKey1"].'","hashKey2":"'.$system_Config["keys"]["hashKey2"].'"},
						
						"errors":{"logErrors":1,"errorDisplayLevel":1}
					}';
						
					// Create Dir	& Config File													
					$domainDir = preg_replace("/\./","",$_POST["domain"]);
					if(mkdir("domains/".$domainDir."/",0777,true)){
						$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/domains/".$domainDir."/system.config","wb");
						fwrite($fp,$config);
						fclose($fp);
					}
											
					
				} else { print 'ERROR! Creating Account'; }
			
			} else { print 'ERROR! Domain Exists'; }
	
		}
		
?>