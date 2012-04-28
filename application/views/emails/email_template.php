<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?=$subject?></title>
		<style type="text/css">
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
			
			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
			body, #backgroundTable{
				background-color: rgb(245,245,245);
			}
			#templateContainer{
				border:0;
				box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.25);
				-webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.25);
				-moz-box-shadow: 1px 0px 5px 0px rgba(0,0,0,0.25);
				border-radius: 3px;
			}
			h1, .h1{
				color: rgb(255,255,255)
				display:block;
				font-family:Arial;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}
			h2, .h2{
				color:#404040;
				display:block;
				font-family:Arial;
				font-size:18px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}
			h3, .h3{
				color:#606060;
				display:block;
				font-family:Arial;
				font-size:16px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}
			h4, .h4{
				color:#808080;
				display:block;
				font-family:Arial;
				font-size:14px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}
			
			#templatePreheader{
				background-color: rgb(245,245,245);
			}
			.preheaderContent div{
				color:#707070;
				font-family:Arial;
				font-size:10px;
				line-height:100%;
				text-align:left;
			}
			.preheaderContent div a:link, .preheaderContent div a:visited, /* Yahoo! Mail Override */ .preheaderContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			#social div{
				text-align:right;
			}

			#templateHeader{
				z-index: 55;
				height: 45px;
				background-color: rgb(70,70,70);
				background-image: -moz-linear-gradient(top, rgb(70,70,70), rgb(60,60,60));
				background-image: -webkit-linear-gradient(top, rgb(70,70,70), rgb(60,60,60));
				border-bottom: 1px solid rgb(55,55,55);
				box-shadow: 0px 1px 0px 0px rgb(50,50,50), 0 2px 0 0 rgba(0,0,0,0.1), 0 3px 0 0 rgba(0,0,0,0.05);
				-webkit-box-shadow: 0px 1px 0px 0px rgb(50,50,50), 0 2px 0 0 rgba(0,0,0,0.1), 0 3px 0 0 rgba(0,0,0,0.05);
				-moz-box-shadow: 0px 1px 0px 0px rgb(50,50,50), 0 2px 0 0 rgba(0,0,0,0.1), 0 3px 0 0 rgba(0,0,0,0.05);
				border-radius: 3px 3px 0 0;
			}
			.headerContent{
				color: rgb(255,255,255);
				text-shadow: rgba(0,0,0,0.74) 0px 1px 1px;
				font-family:Arial;
				font-size: 10px;
				font-weight:bold;
				line-height:100%;
				padding: 5px;
				text-align:right;
				vertical-align:middle;
			}
			.headerContent h1{
				height: 20px;
				text-align:right;
				overflow: hidden;
			}
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				color: rgb(255,255,255);
				font-weight:normal;
				text-decoration:underline;
			}
			
			#headerImage{
				height:auto;
				max-width:600px !important;
			}
			#templateContainer, .bodyContent{
				background-color:#FDFDFD;
			}
			.bodyContent div{
				color:#505050;
				font-family:Arial;
				font-size:14px;
				line-height:150%;
				text-align:justify;
			}
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			
			.bodyContent img{
				display:inline;
				height:auto;
			}
			#templateSidebar{
				background-color:#FDFDFD;
			}
			.sidebarContent{
				border-left:1px solid #DDDDDD;
			}
			.sidebarContent div{
				color:#505050;
				font-family:Arial;
				font-size:10px;
				line-height:150%;
				text-align:left;
			}
			.sidebarContent div a:link, .sidebarContent div a:visited, /* Yahoo! Mail Override */ .sidebarContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			
			.sidebarContent img{
				display:inline;
				height:auto;
			}
			#templateFooter{
				background-color:#FAFAFA;
				border-top:3px solid #909090;
			}
			.footerContent div{
				color:#707070;
				font-family:Arial;
				font-size:11px;
				line-height:125%;
				text-align:left;
			}
			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			
			.footerContent img{
				display:inline;
			}
			#social{
				background-color:#FFFFFF;
				border:0;
			}
			#social div{
				text-align:left;
			}
			#utility{
				background-color:#FAFAFA;
				border-top:0;
			}
			#utility div{
				text-align:left;
			}
			
			#monkeyRewards img{
				max-width:170px !important;
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent">            
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    	<tr>
                                        	<td valign="top">
                                            	<div class="std_preheader_content">
                                                	 <?=$teaser?>
                                                </div>
                                            </td>
											<td valign="top" width="170">
                                            	<div class="std_preheader_links">
                                                	<?$teser_two?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- devider -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" height="45" id="templateHeader">
                                        <tr>
                                        	<td class="headerContent">
                                            	<img src="http://www:8888/formandsystem_future/media/layout/formandsystem_logo.png" style="max-width:180px;" id="headerImage campaign-icon" />
                                            </td>
                                            <td class="headerContent" width="100%" style="padding-left:10px; padding-right:20px;">
                                            	<div id="Header_content">
                                                    <h1><?=$title?></h1>
                                            	</div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                        	<td valign="top" class="bodyContent">

                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding-right:0;">
                                                            <div class="std_content00">
                                                            	<h2 class="h2"><?=$subheadline?></h2>
                                                                <?=$content?>
															</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Content \\ -->

                                            </td>
                                        	<!-- // Begin Sidebar \\  -->
                                        	<!-- <td valign="top" width="180" id="templateSidebar">
                                            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                	<tr>
                                                    	<td valign="top"> -->
                                                        
                                                            <!-- // Begin Module: Standard Content \\ -->
                                                            <!-- <table border="0" cellpadding="20" cellspacing="0" width="100%" class="sidebarContent">
                                                                <tr>
                                                                    <td valign="top" style="padding-right:10px;">
                                                                        <div class="std_content01">
                                                                            <strong>Basic content module</strong>
                                                                            <br />
                                                                            Far far away, behind the word mountains.
                                                                            <br />
                                                                            <br />
                                                                            <strong>Far from the countries</strong>
                                                                            <br />
                                                                            Vokalia and Consonantia, there live the blind texts.
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table> -->
                                                            <!-- // End Module: Standard Content \\ -->
                                                        
                                                        <!-- </td>
                                                    </tr>
                                                </table>
                                            </td> -->
		                                 <!-- // End Sidebar \\ -->
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                            
                                                <!-- // Begin Module: Standard Footer \\ -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="social">
                                                            <div class="std_social">
                                                                &nbsp;<a href="*https://twitter.com/formsystem">follow Form&System on Twitter</a> | <a href="https://www.facebook.com/formandsystem">follow Form&System on Facebook</a></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" width="350">
                                                            <div class="std_footer">
																<em>Copyright &copy; <?=date(Y)?> Form&System, All rights reserved.</em>
																<br />
                                                            </div>
                                                        </td>
                                                        <td valign="top" width="190" id="monkeyRewards">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Footer \\ -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>