
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Zap Zap Math | Account Activation</title>
		<style>
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;} 
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
		</style>
	</head>

	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="padding: 0px; margin: 0px;">
		<center>
			<table align="center" border="0px" cellpadding="0" cellspacing="0" width="100%" style="background-color: #448ccb; font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;">
				<tbody>
					<tr width="100%">
						<!--START-outer-table-holding-cell-->
						<td valign="top" align="left" style="background-color:#448ccb; font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;">
							<!-- START-inner-table-content -->
							<table cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="background-color:#FFFFFF; border: none; padding-bottom:10px; margin: 50px auto 0px auto; width: 600px">
								<tbody>
									<tr width="100%">
										<td valign="top" align="left" bgcolor="#FFFFFF" style="background-color: #FFFFFF; text-align:center">
											<img width="600" src="https://www.zapzapmath.com/assets/img/edm/zapzap-banner.png" title="Zap Zap" style="vertical-align:top" class="zapzap-banner">
										</td>
									</tr>
									<tr width="100%">
										<td bgcolor="#FFFFFF" style="background-color: #FFFFFF; padding: 30px;">
											<h1 style="font-family:Century Gothic; font-size:40px; font-weight:100; line-height:45px; margin:0; color:#8F8F8F">
												Welcome {{$name}},
											</h1>
										</td>
									</tr>

									<tr width="100%">
										<td bgcolor="#FFFFFF" style="background-color: #FFFFFF; padding: 30px;">
											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">You've just signed your little mathling up for the most exciting math adventure this side of the Universe!</p><br/>

											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">To help you prepare for the trip ahead, here are a few vital things to remember:<br />
											Your login is: {{$username}}<br/>
											Login Portal: {{$zapzapmath_portal}}<br/><br/>
											</p>

											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">To activate your account, please click on the link below:<br/>
											{{$activation_link}}<br/><br/></p>

											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">Further instructions will be transmitted to your inbox as the mission progresses. However, if you have any questions about this journey, please feel free to get in touch ( {{$email_support}} )<br/><br/></p>

											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">We look forward to adventuring with you!<br/><br/></p>

											<p style="font-family:'Open Sans',Calibri,Arial,Helvetica,sans-serif; font:15px/1.25em; margin:0; color:#8F8F8F">
												The Zap Zap Math Team<br/>
												https://www.zapzapmath.com <br/>
												{{$social_media_links}}<br/>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
							<!-- END-inner-table-content -->
						</td>
						<!--END-outer-table-holding-cell-->
					</tr>
				</tbody>
			</table>
		</center>
	</body>
</html>