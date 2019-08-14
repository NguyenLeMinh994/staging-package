<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>TAporta - B2B Travel Network - Leading Portal in Indochina - Hotel Search</title>
		<style type="text/css">
			/* /\/\/\/\/\/\/\/\/ RESET STYLES /\/\/\/\/\/\/\/\/ */
				html,body{
					margin:0;padding:0;background:#EAEDF1;font-family:Helvetica, Arial, sans-serif;color:#505050;font-size:14px;
				}
				h1,h2,h3,h4,h5,h6,p{
					margin:0;padding:0;
				}
				h1{font-size:20px;font-family:Helvetica, Arial, sans-serif;color:#505050;}
				ul{margin-top:0px;padding-left:12px;margin-bottom:0px;}
				img{
					border:0 none;height:auto;line-height:100%;outline:none;text-decoration:none;
				}
				a img{
					border:0 none;
				}
				.imageFix{
					display:block;
				}
				table, td{
					border-collapse:collapse;
				}
				#bodyTable{
					height:100% !important;margin:0;padding:0;width:100% !important;
				}
				#emailContainer{
					background:#FFFFFF;
				}
				.footer{background:#333333;}
				.copyright{color:#ffffff;font-size:11px;font-family:Helvetica, Arial, sans-serif;}
				.leftColumnContent span{font-weight:bold;font-family:Helvetica, Arial, sans-serif;}
			/* /\/\/\/\/\/\/\/\/ RESET STYLES /\/\/\/\/\/\/\/\/ */
			
			@media only screen and (max-width: 480px){
				#emailContainer,
				#templateColumns{
					width:100% !important;
				}
				.templateColumnContainer{
					display:block !important;
					width:100% !important;
				}
				.columnImage{
					height:auto !important;
					max-width:480px !important;
					width:100% !important;
				}
				.leftColumnContent{
					font-size:16px !important;
					line-height:125% !important;
				}
				.leftColumnContent span{font-weight:bold;font-family:Helvetica, Arial, sans-serif;}
				.rightColumnContent{
					font-size:16px !important;
					line-height:125% !important;
				}
				#header_links{
					max-width:600px !important; width:100% !important;
				}
				.header_link_item{
					background-color:#EAEDF1 !important; padding:5px 0 !important; text-align:center !important;
				}
				.header_link_item a{
					color:#606060 !important; display:block !important; text-decoration:none !important;
				}
				.header_link_item a:hover{
					color:#606060 !important; display:block !important; text-decoration:underline !important;
				}
				.deartext,
				.bodytex,
				.hreflink{
					font-size:16px !important;font-family:Helvetica, Arial, sans-serif;color:#505050;
				}
			}
		</style>
	</head>
	<body>
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
			<tr>
				<td align="center" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="600" id="emailContainer">
						<tr>
							<td align="center" valign="top">
								<!-- This is where my content goes. -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateColumns">
									<tr>
										<td align="right" valign="top" width="100%" class="templateColumnContainer">
											<table border="0" cellpadding="10" cellspacing="0" id="header_links">
												<tr>
													<td valign="top" class="header_link_item">
														<a style="color:#333;font-family:Helvetica, Arial, sans-serif;font-size:12px;" href="https://taporta.com/info/portfolio" target="_blank">Our products & services</a>
													</td>
													<td valign="top" class="header_link_item">|</td>
													<td valign="top" class="header_link_item">
														<a style="color:#333;font-family:Helvetica, Arial, sans-serif;font-size:12px;" href="https://taporta.com/info/contactus" target="_blank">Contact us</a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="left" valign="top" width="100%" class="templateColumnContainer">
											<table border="0" cellpadding="10" cellspacing="0" width="100%">
												<tr>
													<td class="leftColumnContent">
														<img src={{asset('/asset/package/media/img/logo/taporta-logo.png')}} width="250" style="max-width:250px;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!-- End Header -->
									<tr>
										<td align="center" valign="top" width="50%" class="templateColumnContainer">
											<table border="0" cellpadding="10" cellspacing="0" width="100%">
												<tr>
													<td>
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td valign="top" class="leftColumnContent">
																	<p class="deartext" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050;font-weight:bold;">Dear {{$userInfo->first_name}} {{$userInfo->last_name}},</p>
																</td>
															</tr>
															<tr><td>&nbsp;</td></tr>
															<tr>
																<td valign="top" class="leftColumnContent">
																	<p class="deartext" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050;">You have requested to reset your password because you have forgotten your password. If you did not request this, please ignore it. This link will expire in 24 hours.</p>
																</td>
															</tr>
															<tr><td>&nbsp;</td></tr>
															<tr>
																<td valign="top" class="leftColumnContent">
																<p class="deartext" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050;">To reset your password, simply click on the link below:<br> <a href="{{URL::to('/')}}/password/reset/{{$token}}?email={{urlencode($userInfo->email)}}" class="hreflink" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050; text-decoration:underline;">https://packages.taporta.com/authentication/resetpass/</a></p>
																</td>
															</tr>
															<tr><td>&nbsp;</td></tr>
															<tr>
																<td valign="top" class="leftColumnContent">
																	<p class="deartext" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050;">Please retain this e-mail for your reference. For technical information/ enquiries, please email our IT helpdesk at <a href="mailto:helpdesk@taporta.com" class="hreflink" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050; text-decoration:underline;">helpdesk@taporta.com</a></p>
																</td>
															</tr>
															<tr><td>&nbsp;</td></tr>
															<tr>
																<td valign="top" class="leftColumnContent">
																	<p class="deartext" style="font-family:Helvetica, Arial, sans-serif; font-size:14px;color:#505050;">Sincerely,<br>TAporta</p>
																</td>
															</tr>
															<tr><td>&nbsp;</td></tr>
															<tr><td>&nbsp;</td></tr>
															<tr><td>&nbsp;</td></tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="left" valign="top" width="100%" class="templateColumnContainer">
											<table style="background:#333333;font-family:Helvetica, Arial, sans-serif;font-size:11px;" class="footer" border="0" cellpadding="10" cellspacing="0" width="100%">
												<tr>
													<td class="leftColumnContent">
														<h4 style="font-family:Helvetica, Arial, sans-serif; font-size:11px;color:#fff;">Cambodia</h4>
														<img src="https://taporta.com/promotion/images/icons/map_marker_icon.png" style="height:10px;" alt="address"> <a style="text-decoration:none;color:#fff;font-family:Helvetica, Arial, sans-serif; font-size:11px;">M7, De Castle Building. 
														No 83, Street 315 Sangkat Boeung Kak I, Khan Toul Kork, Phnom Penh.</a><br>
														<img src="https://taporta.com/promotion/images/icons/email_icon.png" style="height:10px;" alt="Email"> <a style="color:#fff;text-decoration:none;font-family:Helvetica, Arial, sans-serif; font-size:11px;" href="mailto:enquiries@taporta.com">enquiries@taporta.com</a>&nbsp;
														<img src="https://taporta.com/promotion/images/icons/worldwide_icon.png" style="height:10px;" alt="website"> <a style="color:#fff;text-decoration:none;font-family:Helvetica, Arial, sans-serif; font-size:11px;" href="https://www.taporta.com/">https://www.taporta.com/</a>
													</td>
												</tr>
												<tr>
													<td class="leftColumnContent">
														<p style="color:#ffffff;font-size:11px;font-family:Helvetica, Arial, sans-serif;" class="copyright">Copyrights © 2014-2019 TAporta.com. All Rights Reserved.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!-- End Footer -->
								</table>
								<!-- End This is where my content goes. -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>