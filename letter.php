<?

$html = 'PRIVET OGSHA! NOVEW PRED:<br/><br/>
<table width="70%">
	<tr>
		<td width="100px">
			<a href=""><img src="http://hotels-sale.ru/fotos/pre_22-uk_privlekatelynyi_i_izasnyi_bar_s_domom_v_londone__raspolozennyi_na_kembervelroud_(mezdu_berdzes_i_kenington_parkami)._.jpg" alt="" /></a>
		</td>
		<td valign="top">
			&nbsp;&nbsp;&nbsp;<a href="" style="color: #369">PRIVET asd qwfae gasd g</a>
			<p style="font-style: italic">
				&nbsp;&nbsp;&nbsp;price: <strong>600</strong>
			</p>
		</td>
	</tr>
	<td colspan="2">
		<br/>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. <a href="" style="color: #369">moremore...</a>
	</td>
		</table><br/>';
		
	$headers = "Content-type: text/html; charset=windows-1251\r\n";
	$headers .= "From: Hotels-sale.ru <news@hotels-sale.com>";
		
mail('no-thx@mail.ru', 'Hotels-sale новости', $html, $headers);

?>