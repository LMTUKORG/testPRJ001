<?php
	// Test Code + Info from Windows

	// Primary Inputs
	
	
		// Domain
		
			$domain = preg_split("/:/",$_GET["domain"]); // Allow for Port :8080
			if(preg_match("/^([a-zA-Z0-9\.]+)$/",$domain[0])){ $cleanDomain = $domain[0]; } else { $error404 = true; }
	
	
		// Application
	
			if(preg_match("/^([a-zA-Z]+)$/",$_GET["application"])){ $cleanApplication = $_GET["application"]; } else { $error404 = true; }
	
	
		// (if) Profile
	
			if(isset($_GET["profile"]) && preg_match("/^([a-zA-Z]+)$/",$_GET["profile"])){ $cleanProfile = $_GET["profile"]; } else { $cleanProfile = null; }
			
			
		// Request Type

			if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || $cleanApplication == "api") { 
				$requestType = "code";
			} else {
				$requestType = "view";
			}
			
			
		// Module
		
			if(preg_match("/^([a-zA-Z0-9\-\_]+)$/",$_GET["module"])){

				$actualModule = $_GET["module"]; 
				$cleanModule = $_GET["module"]; 

				if($requestType == "code") { 
					$actualModule = "_".$actualModule; 
				}
	
			} else { $error404 = true; }


	// 404 Error Handler

		if(isset($error404)){
			header('HTTP/1.0 404 Not Found');
		  	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
		}
	
	
	// Error Handler

		function handleError($requestType,$type,$jSon)
		{
			// Decode Error Data

				$errorData = json_decode($jSon,true);
				$code = $errorData["code"];

			// (if) code / view

				if($requestType == "code"){ // (if) Code

					switch($type){
	
						case "closed":
							$jSon = '{"status":"SYSTEM_CLOSED","code":"'.$errorData["code"].'"}';
							break;
		
						case "access":
							$jSon = '{"status":"ACCESS_DENIED","code":"'.$errorData["code"].'"}';
							break;
		
						case "system":
						case "validation":
							$jSon = '{"status":"SYSTEM_ERROR","code":"'.$errorData["code"].'"}';
							break;
					}

					print $jSon;

				} else if($requestType == "view") {

					switch($type){ // (if) View
	
						case "closed":
							$icon = "Warning_Green";
							$message = "This service is currently closed for maintenance";
							break;
		
						case "access":
							$icon = "Warning_Amber";
							$message = "Access has been denied, please contact technical support";
							break;
		
						case "system": 
						case "validation": 
							$icon = "Warning_Red";
							$message = "An unspecified error has occurred, please contact technical support";
							break;
					}

					$code = $errorData["code"];
					include("error.php");
				}
		
			exit;
		}	 


	// Set System Status
	
		$status = "open";
	
	
	// Check Status & Includes
	
		if($status == "open")
		{
			
			// Include Key
		
				$includeKey = '5461933264597561';
		
		
			// Include PHP Core
		
				if(file_exists("_php.php")){ include("_php.php"); } else { handleError($requestType,"system",'{"code":"LD001"}'); }
		
		
			// Start System
		
				if(file_exists("system.php")){ include("system.php"); } else { handleError($requestType,"system",'{"code":"LD002"}'); }
				
		}
		else if($status == 'closed')
		{
			handleError($requestType,"closed",'{"code":"LD003"}');
		}

?>
