<?php
$user=array(
	'USER_LOGIN'=>'1', #Ваш логин (электронная почта)
	'USER_HASH'=>'1' #Хэш для доступа к API (смотрите в профиле пользователя)
);
$subdomain='1';
$link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_POST,true);curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($user));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);curl_close($curl);




/*----------поиск----------------------*/


$serach="0";
$last_leads=array();
if (isset($phone) and $phone!=''){
		$phone2=$phone;
		
		if ($phone2[0]==8){$phone2[0]="7";}
		$phone2=str_replace("+7", "7",$phone2);
		$phone2=str_replace("(", "",$phone);
		$phone2=str_replace(")", "",$phone2);
		$phone2=str_replace("+", "",$phone2);
		$phone2=str_replace(" ", "",$phone2);
		$phone2=str_replace("-", "",$phone2);

	
		$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/companies/list?query='.$phone2.'&limit_rows=1';
		$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);curl_close($curl);
		$asd=(json_decode($out));

		if ($asd){
		$custom_fields=($asd->response->contacts[0]->custom_fields);
		
		for ($xxx=0;$xxx<count($custom_fields);$xxx++){
			$custom_fields_id=($custom_fields[$xxx]->id);
			if ($custom_fields_id==428081){
				$phone_amo=($custom_fields[$xxx]->values[0]->value);

				$phone_amo=str_replace("+7", "7",$phone_amo);
				$phone_amo=str_replace("(", "",$phone_amo);
				$phone_amo=str_replace(")", "",$phone_amo);
				$phone_amo=str_replace("+", "",$phone_amo);
				$phone_amo=str_replace(" ", "",$phone_amo);
				$phone_amo=str_replace("-", "",$phone_amo);	
				if ($phone2==$phone_amo){
					$asd=(json_decode($out));
					$id_contacts=($asd->response->contacts[0]->id);
					$leads_phone=$asd->response->contacts[0]->linked_leads_id;
					if (count($leads_phone)>0){
						$last_leads=$leads_phone[count($leads_phone)-1];
					}
					$linked_leads_id=$leads_phone;
					$serach=1;
				}
			}
		}
		}
}

/*
echo $last_leads;
echo $serach;
die();
*/
if ($serach==1){
	
	//$last_leads;
	
		/*--------задача-------------------------*/
	
		$segodnya=strtotime(date('d.m.Y H:i').' +15 min');
		$task= array(
			'element_id'=>$last_leads, 
			'element_type'=>2,
			'task_type'=>1,
			'text'=>'Связаться с клиентом - повторная заявка',
			'responsible_user_id'=>$responsible_user_id,
			'complete_till'=>$segodnya
		);

		$set['request']['tasks']['add'][]=$task;
		$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/tasks/set';$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($set));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
	
		/*-----------------------------------*/
		
		
		
		
} else {















$ip=$_SERVER['REMOTE_ADDR'];
$geo = json_decode(file_get_contents('http://api.sypexgeo.net/json/'.$ip), true);
$city=$geo['city']['name_ru'];
$region=$geo['region']['name_ru'];
$strana=$geo['country']['name_ru'];


$summ=0;
$responsible_user_id=742032;
$sdelka=array(
    'name'=>'Заявка с сайта',
    'status_id'=>140,
    'price'=>$summ,
	'responsible_user_id'=>$responsible_user_id,
	'tags'=>$region
);

$sdelka['custom_fields'][]=array('id'=>449457,'values'=>array(array('value'=>"881813")));
$sdelka['custom_fields'][]=array('id'=>655733,'values'=>array(array('value'=>"1268313")));

if ($tema){$sdelka['custom_fields'][]=array('id'=>544291,'values'=>array(array('value'=>$tema)));}

$expectMarks = array('utm_source','utm_medium','utm_campaign','utm_term','utm_content');$utms=array();foreach($expectMarks as $utm){if(isset($_COOKIE[$utm])){${$utm}=$_COOKIE[$utm];}}
if ($utm_source){$sdelka['custom_fields'][]=array('id'=>544281,'values'=>array(array('value'=>$utm_source)));}
if ($utm_medium){$sdelka['custom_fields'][]=array('id'=>544283,'values'=>array(array('value'=>$utm_medium)));}
if ($utm_campaign){$sdelka['custom_fields'][]=array('id'=>544285,'values'=>array(array('value'=>$utm_campaign)));}
if ($utm_content){$sdelka['custom_fields'][]=array('id'=>544287,'values'=>array(array('value'=>$utm_content)));}
if ($utm_term){$sdelka['custom_fields'][]=array('id'=>544289,'values'=>array(array('value'=>$utm_term)));}

if ($brand){$sdelka['custom_fields'][]=array('id'=>544265,'values'=>array(array('value'=>$brand)));}
if ($vkus){$sdelka['custom_fields'][]=array('id'=>544267,'values'=>array(array('value'=>$vkus)));}
if ($obem){$sdelka['custom_fields'][]=array('id'=>544269,'values'=>array(array('value'=>$obem)));}

if ($region){$sdelka['custom_fields'][]=array('id'=>691435,'values'=>array(array('value'=>$region)));}
if ($city){$sdelka['custom_fields'][]=array('id'=>691321,'values'=>array(array('value'=>$city)));}
if ($strana){$sdelka['custom_fields'][]=array('id'=>691459,'values'=>array(array('value'=>$strana)));}


$leads['request']['leads']['add'][]=$sdelka;
$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/set';
$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($leads));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

if ($code==200){
	$Response=json_decode($out,true);
	$Response=$Response['response']['leads']['add'];
	$idsdelka=$Response[0]['id'];
	

	if ($name==""){$name="Название не указано";}	
		$contact=array(
		  'name'=>$name,
		  'leads_id'=>array($idsdelka),
		  'responsible_user_id'=>$responsible_user_id
		);

		if ($phone){$contact['custom_fields'][]=array('id'=>428081,'values'=>array(array('value'=>$phone,'enum'=>'MOB')));}
		if ($email){$contact['custom_fields'][]=array('id'=>428083,'values'=>array(array('value'=>$email,'enum'=>'WORK')));}

		if ($region){$contact['custom_fields'][]=array('id'=>544387,'values'=>array(array('value'=>$region)));}
		if ($sfera){$contact['custom_fields'][]=array('id'=>544279,'values'=>array(array('value'=>$sfera)));}
		
		$set['add'][]=$contact;

		
		$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/contacts/set';
		$link='https://'.$subdomain.'.amocrm.ru/api/v2/companies';
		$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($set));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		$out=curl_exec($curl);
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

	
	
	
	
	
	if ($comments){
		$notes['request']['notes']['add']=array(
		array(
			'element_id'=>$idsdelka,
			'element_type'=>2,
			'note_type'=>4,
			'text'=>$comments,
			'responsible_user_id'=>$responsible_user_id,
		));
		$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/notes/set';
		$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($notes));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out4=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);curl_close($curl);
	}
	
}


}


?>
