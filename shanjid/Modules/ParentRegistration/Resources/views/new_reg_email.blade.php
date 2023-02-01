
@php
$generalSetting = App\SmGeneralSettings::where('id',1)->first();
$email_template = App\SmsTemplate::where('id',1)->first();
@endphp
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
		<link rel="stylesheet" href="{{url('Modules/ParentRegistration/Resources/assets/css/style.css')}}">
	</head>
<body>
<div>
    <table  border="0" cellspacing="0" cellpadding="0" bgcolor="#e4e5e7">
        <tbody>
			
			<!-- LOGO START -->
			<tr>
				<td align="center" >
					<table  bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="m_wd_full">
						<tbody>
							<tr>
								<td>
									<table  border="0" cellspacing="0" cellpadding="0">
										<tbody>
										    <tr> <td height="30"></td></tr>
											<tr>
												<td align="center" class="m_img_mc_fix">
													<a href="" target="_blank"> <img align="center" src="{{asset($generalSetting->logo)}}" alt=""  height="" border="0" ></a>
												</td>
											</tr>
											<tr><td height="30"> </td></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<table  border="0" cellspacing="0" cellpadding="0" class="m_wd_full">
						<tbody>
							<tr>
								<td>
									<table  border="0" cellspacing="0" cellpadding="0">
										<tbody>
										    <tr><td height="50"></td></tr>
											<tr>
												<td align="center" class="m_img_mc_fix"> 
												</td>
											</tr>
											<tr>
												<td align="center"  >
													Login Credentials
												</td>
											</tr>
											<tr><td height="50"></td></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- HEADING + ICON END -->
			
			<!-- HEADING + ICON START -->
			<tr>
				<td align="center" >
					<table   bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0"  class="m_wd_full">
						<tbody>
							<tr>
								<td>
									<table  border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<!-- Button START -->
											<tr>
												<td>
													<table align="center" cellspacing="0" cellpadding="0" border="0">
														<tr>
															<td >
																<table cellspacing="0" cellpadding="0" border="0" >
																	<tr>
																		<td>
																			<table cellspacing="0" cellpadding="0" border="0" >
																				<tr>
																					<td >
																						<a href="{{url('/login')}}"  target="_blank">Login </a>
																						
																					</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<!-- Button END -->
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- HEADING + ICON END -->
			
			<!-- ACCOUNT INFORMATION START -->
			<tr>
				<td align="center">
					<table  bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0"  class="m_wd_full">
						<tbody>
							<tr>
								<td>
									<table  border="0" cellspacing="0" cellpadding="0">
										<tbody>
										    <tr><td height="50">
												</td></tr>
											<tr>
												<td align="center">


													<?php 

													if($data['slug'] == 'student'){
														$body = $email_template->student_registration_message;
													}elseif($data['slug'] == 'parent'){
														$body = $email_template->guardian_registration_message;
													}
													 $chars = preg_split('/[\s,]+/', $body, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

													    foreach($chars as $item){
													        if(strstr($item[0],"[")){

													            $str= str_replace('[','',$item);
													            $str= str_replace(']','',$str); 
													            $str= str_replace('.','',$str); 

													            $custom_array[$item]= App\SmsTemplate::getValueByStringTestRegistration($data, $str);
													        } 
													         
													    }

														if(isset($custom_array)){
															foreach($custom_array as $key=>$value){
													        	$body= str_replace($key,$value,$body); 
													    	}
														}
													    




												//	$final_text ="Dear Rashed, , Thank you for your registration. your user name is jmrashed and password is 123456";




													?>

													{{$body}}


												</td>
											</tr>
											<tr><td height="30"></td></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- ACCOUNT INFORMATION END -->
			
			<!-- Footer -->
			<tr>
				<td align="center">
					<table  bgcolor="#f6f7f9" border="0" cellspacing="0" cellpadding="0" class="m_wd_full">
						<tbody>
							<tr>
								<td>
									<table  border="0" cellspacing="0" cellpadding="0">
										<tbody>
										    <tr><td height="25"></td></tr>
											<tr>
												<td align="center" >
													{{$email_template->email_footer_text}}
												</td>
											</tr>
											<tr><td height="25"></td></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- Footer END -->
        </tbody>
    </table>
</div>
</body>
</html>
