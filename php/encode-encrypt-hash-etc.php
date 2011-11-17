<?php
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_STRICT);
function array_make_first(&$array, $element)
{
    if (($ndx = array_search($element, $array)) !== false) {
        unset($array[$ndx]);
        array_unshift($array, $element);
    }
}

function optionYap($arr, $sel)
{
	foreach ($arr as $k => $v) {
		$s .= '<option value="'.$k.'"'.($sel == $k ? ' selected="selected" ' : '').'>'.$v.'</option>';
	}
	return $s;
}

$mcryptModuleErr = false;
if (!function_exists('mcrypt_module_open')) {
    $mcryptModuleErr = true;
} else {
    $mcryptAlgos = mcrypt_list_algorithms();
    sort($mcryptAlgos);
	$varsayilanMcryptAlgo = 'rijndael-256';
    //array_make_first($mcryptAlgos, 'rijndael-256');
    
    $mcryptModes = mcrypt_list_modes();
    sort($mcryptModes);
	$varsayilanMcryptMod = 'ecb';
    //array_make_first($mcryptModes, 'ecb'); 
}

$hashFuncErr = false;
if (!function_exists('hash_algos')) {
    $hashFuncErr = true;
} else {
    $hashAlgos = hash_algos();
    sort($hashAlgos);
	$varsayilanHashAlgo = 'sha512';
	//array_make_first($hashAlgos, 'sha512');
}

if (isset($_POST['sent']) && $_POST['sent'] != '') {
    if ($_POST['girdiYontemi'] == 'gyYazi') {
        $girdi = $_POST['girdiYazi'];
    } else {
        $girdi = file_get_contents($_FILES['girdiDosya']['tmp_name']);
    }

	if ($_POST['dosyaTipi'] == 'metin') {
		$encoding = strtolower(mb_detect_encoding($girdi, 'UTF-8, ISO-8859-9, ISO-8859-1, ASCII, ISO-8859-2, ISO-8859-3, ISO-8859-4, ISO-8859-5, ISO-8859-6, ISO-8859-7, ISO-8859-8, ISO-8859-10, ISO-8859-13, ISO-8859-14, ISO-8859-15, UCS-4, UCS-4BE, UCS-4LE, UCS-2, UCS-2BE, UCS-2LE, UTF-32, UTF-32BE, UTF-32LE, UTF-16, UTF-16BE, UTF-16LE, UTF-7, UTF7-IMAP, EUC-JP, SJIS, eucJP-win, SJIS-win, ISO-2022-JP, JIS, byte2be, byte2le, byte4be, byte4le, BASE64, HTML-ENTITIES, 7bit, 8bit, EUC-CN, CP936, HZ, EUC-TW, CP950, BIG-5, EUC-KR, UHC, ISO-2022-KR, Windows-1251, Windows-1252, CP866, KOI8-R', true));
		if ($encoding!= 'utf-8') {
			$girdi = mb_convert_encoding($girdi, 'UTF-8', $encoding);
		}
		
		if ($_POST['girdiFormati'] == 'b64') {
			$girdi = base64_decode($girdi);
		}
    }
	
    //$girdi = quoted_printable_decode($girdi);

    switch ($_POST['islem']) {
    	case 'iSifrele':
            $td = mcrypt_module_open($_POST['sifreleAlgo'], '', $_POST['sifreleMod'], '');
            $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
            mcrypt_generic_init($td, $_POST['sifreleSifre'], $iv);
            if ($_POST['islem'] == 'sifrele') {
                $fn = 'mcrypt_generic';
            } else {
                $fn = 'mdecrypt_generic';
            }
            $cikti = $fn($td, $girdi);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
        	break;
    	case 'iHash':
    		$cikti = hash($_POST['hashAlgo'], $girdi);
        	break;
    	case 'iEncDec':
    	    $enc = ($_POST['encDecIslem'] == 'enc' ? true : false );
        	switch ($_POST['encDecYontem']) {
        		case 'b64':
        		    if ($enc) {
        		    	$cikti = base64_encode($girdi); 
        		    } else {
                        if ($_POST['girdiFormati'] == 'b64') {
                            $cikti = $girdi;
                        } else {
                            $cikti = base64_decode($girdi);
                        }
        		    }
            		break;
        		case 'rot13':
        		    $cikti = str_rot13($girdi);
            		break;
            	case 'url':
            	    if ($enc) {
        		    	$cikti = urlencode($girdi); 
        		    } else {
        		    	$cikti = urldecode($girdi);
        		    }
            		break;
            	case 'utf8':
            	    if ($enc) {
        		    	$cikti = utf8_encode($girdi); 
        		    } else {
        		    	$cikti = utf8_decode($girdi);
        		    }
            		break;
                case 'qp':
                    if ($enc) {
        		    	$cikti = quoted_printable_encode($girdi); 
        		    } else {
        		    	$cikti = quoted_printable_decode($girdi);
        		    }
                    break;
            	default:
            		break;
        	}
        	break;
    	default:
        	break;
    }
    
	if ($_POST['ciktiFormati'] == 'b64') {
		$cikti = base64_encode($cikti);
	}

    if ($_POST['ciktiYeri'] == 'dosya') {
        $dosyaAdi = ($_POST['ciktiYeriDosyaAdi'] != '' ? mb_convert_encoding($_POST['ciktiYeriDosyaAdi'], 'utf-8', 'iso-8859-9') : 'cikti.txt');
    	header('Content-Disposition: attachment; filename="'.$dosyaAdi.'";' );
    	echo $cikti;
    	exit;
    };
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        	/*<![CDATA[*/
			html, body { height:100%;}
			body { margin:0; padding:0;}
			body, td, th{font-family:Tahoma, Verdana, sans-serif; font-size:11px;}
			input, textarea{font-family:"Courier New", Courier, monospace; font-size:11px;}
			input, select, option{padding:1px;}
			textarea{overflow:auto;}
			h1, h2{padding:0;}
			h1{margin:10px 0; font-size:18px; }
			h1 a, h1 a:visited{text-decoration: none;color:#006699;}
			h1 a:hover{color: #001621;}
			h2{ margin:7px 0; font-size:14px; color:#660000; border-bottom:solid 1px;}
			label{cursor:pointer;}
			.fullW { width:100%;}
			.fullH { height:100%;}
			#contTbl{ padding:25px 15px;}
			#mainTbl td, #mainTbl th{text-align:left;}
			.islemDiv td, .islemDiv th{vertical-align:middle;}
			.hata{color:#f00;}
			.btn{font-family:Tahoma, Verdana, sans-serif;}
			/*]]>*/
		</style>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript">
        	//<![CDATA[
			function jsIslem(girdi, encDecYontem, encDec) {
				var ret = '';
				switch (encDecYontem) {
					case 'js_esc':
						if (encDec == 'enc') {
							ret = escape(girdi);
						} else {
							ret = unescape(girdi);
						}
						break;
						
					case 'js_uri':
						if (encDec == 'enc') {
							ret = encodeURI(girdi);
						} else {
							ret = decodeURI(girdi);
						}
						break;
						
					case 'js_uri_comp':
						if (encDec == 'enc') {
							ret = encodeURIComponent(girdi);
						} else {
							ret = decodeURIComponent(girdi);
						}
						break;
						
					default:
						break;
				}
				return ret;
			}
			var jsOps = {
				'js_esc'	  : 'JS escape/unescape',
				'js_uri'	  : 'JS enc/dec URI',
				'js_uri_comp' : 'JS enc/dec URIComponent'
			};
			function tab(sClass, sId) {
				$('.'+sClass).hide();
				$('#'+sId).show();
			}
			function chkForJs() {
				if (!$('#girdiYazi').val() && !$('#girdiDosya').val()) {
					alert('Lütfen girdiyi giriniz.');
					return false;
				}
				var islem = $('input:radio[name=islem]:checked').val();
				if (!islem) {
					alert('Lütfen bir işlem seçiniz.');
					return false;
				}
				
				var encDecYontem = $('select[name=encDecYontem]').val();
				var girdiYontemi = $('input:radio[name=girdiYontemi]:checked').val();
				if (girdiYontemi == 'gyYazi' && islem == 'iEncDec' && jsOps[encDecYontem]) {
					$('#cikti').val((jsIslem($('textarea[name=girdiYazi]').val(), encDecYontem, $('#encDecIslem').val())));
					$('#ciktiTr').show();
					return false;
				}
				return true;
			}
			//]]>
		</script>
        <title>Şifreleme, Hashing, Encode/Decode, vb</title>
    </head>
    <body>
    	<table cellpadding="0" cellspacing="0" border="0" class="fullW fullH" id="contTbl">
			<tr>
                <td class="fullW" valign="top" align="center">
                	<h1><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">Şifreleme, Hashing, Encode/Decode, vb</a></h1>
                    <form id="mainForm" name="mainForm" action="" method="post" enctype="multipart/form-data" onsubmit="return chkForJs();">
                    	<table border="0" cellspacing="15" cellpadding="0" id="mainTbl">
                            <tr>
                                <td width="300" align="left" valign="top">
                                	<h2>Girdi</h2>
                                	<table border="0" cellpadding="0" cellspacing="4">
                                		<tr>
                                			<td valign="middle"><label for="girdiFormati">Girdi Formatı</label></td>
                                			<td valign="middle">
                                				<select id="girdiFormati" name="girdiFormati">
                                                	<option value="duz">Düz</option>
                                                    <option value="b64">Base64</option>
                                                </select>
                                			</td>
                                		</tr>
                                	</table>
                                    <br />
                                    <input type="radio" id="girdiYontemiYazi" name="girdiYontemi" value="gyYazi" onclick="tab('girdiDiv', 'girdiYaziDiv');$('girdiYazi').activate();" <?php if (!isset($_POST['girdiYontemi']) || $_POST['girdiYontemi'] == 'gyYazi') { ?>checked="checked"<?php } ?> /><label for="girdiYontemiYazi">Yaz</label>&nbsp;&nbsp;
                                    <input type="radio" id="girdiYontemiDosya" name="girdiYontemi" value="gyDosya" onclick="tab('girdiDiv', 'girdiDosyaDiv');$('girdiDosya').click();" <?php if (isset($_POST['girdiYontemi']) && $_POST['girdiYontemi'] == 'gyDosya') { ?>checked="checked"<?php } ?> /><label for="girdiYontemiDosya">Dosyadan Al</label>
                                    <div class="girdiDiv" id="girdiYaziDiv">
                                    	<textarea rows="15" cols="35" style="width:290px" wrap="off" id="girdiYazi" name="girdiYazi"><?php if (isset($_POST['girdiYazi'])) { echo htmlspecialchars($_POST['girdiYazi']); } ?></textarea>
                                    </div>
                                    <div class="girdiDiv" id="girdiDosyaDiv" style="display:none">
                                   		<input type="file" size="27" id="girdiDosya" name="girdiDosya" /><br />
                                   		( En fazla : <?php echo ini_get('upload_max_filesize'); ?> )<br />
										<label for="dosyaTipi">Dosya Tipi </label>
										<select id="dosyaTipi" name="dosyaTipi">
											<option value="metin">Metin Dosyası</option>
											<option value="bin">Binary</option>
										</select>
                                    </div>
                                </td>
                                <td width="300" align="left" valign="top">
                                	<h2>İşlem</h2>
                                    <label><input type="radio" name="islem" value="iSifrele" onclick="tab('islemDiv', 'islemSifreleDiv')" <?php if ($mcryptModuleErr) echo 'disabled="disabled"'; ?>/>Anahtarlı Şifreleme<?php if ($mcryptModuleErr) echo '<span class="hata"> ! mcrypt modülüne erişilemiyor.</span>'; ?></label><br />
                                    <label><input type="radio" name="islem" value="iHash" onclick="tab('islemDiv','islemHashDiv')" <?php if ($hashFuncErr) echo 'disabled="disabled"'; ?>/>Hashing<?php if ($mcryptModuleErr) echo '<span class="hata"> ! hash fonksiyonuna erişilemiyor.</span>'; ?></label><br />
                                    <label><input type="radio" name="islem" value="iEncDec" onclick="tab('islemDiv','islemEncDecDiv')" />Encode/Decode</label>
                                    <br /><br /><br />
                                    <div class="islemDiv" id="islemSifreleDiv" style="display:none">
                                    	<h2>Anahtarlı Şifreleme Seçenekleri</h2>
                                    	<table border="0" cellspacing="4" cellpadding="0">
                                        	<tr>
                                                <td><label for="sifreleIslem">İşlem</label></td>
                                                <td>
                                                	<select id="sifreleIslem" name="sifreleIslem">
                                                    	<?php echo optionYap(array('sifrele'=>'Şifrele', 'coz'=>'Çöz'), @$_POST['sifreleIslem']); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="sifreleSifre">Anahtar (Şifre)</label></td>
                                                <td><input type="text" id="sifreleSifre" name="sifreleSifre" size="24" value="<?php if (isset($_POST['sifreleSifre'])) {echo htmlspecialchars($_POST['sifreleSifre']);} ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><label for="sifreleAlgo">Algoritma</label></td>
                                                <td>
                                                	<select id="sifreleAlgo" name="sifreleAlgo">
														<?php foreach ($mcryptAlgos as $algo) { ?>
                                                            <option value="<?php echo $algo; ?>"<?php echo ((@$_POST['sifreleAlgo']==$algo||$varsayilanMcryptAlgo==$algo)?' selected="selected"':''); ?>><?php echo $algo; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="sifreleMod">Mod</label></td>
                                                <td>
                                                	<select id="sifreleMod" name="sifreleMod">
														<?php foreach ($mcryptModes as $mode) { ?>
                                                            <option value="<?php echo $mode; ?>"<?php echo ((@$_POST['sifreleMod']==$mode||$varsayilanMcryptMod==$mode)?' selected="selected"':''); ?>><?php echo $mode; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>           
                                    </div>
                                    <div class="islemDiv" id="islemHashDiv" style="display:none">
                                    	<h2>Hashing Seçenekleri</h2>
                                       	<label>Algoritma : <select name="hashAlgo">
											<?php foreach ($hashAlgos as $algo) { ?>
                                                <option value="<?php echo $algo; ?>"<?php if ((isset($_POST['hashAlgo']) && $_POST['hashAlgo'] == $algo) || (!isset($_POST['hashAlgo']) && $varsayilanHashAlgo == $algo)) { ?> selected="selected" <?php } ?>><?php echo $algo; ?></option>
                                            <?php }?>
                                        </select></label>
                                    </div>
                                    <div class="islemDiv" id="islemEncDecDiv" style="display:none">
                                    	<h2>Encode/Decode Seçenekleri</h2>
                                        <table border="0" cellspacing="4" cellpadding="0">
                                        	<tr>
                                                <td><label for="encDecIslem">İşlem</label></td>
                                                <td>
                                                	<select id="encDecIslem" name="encDecIslem">
                                                    	<?php echo optionYap(array('enc'=>'Encode', 'dec'=>'Decode'), @$_POST['encDecIslem']); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="encDecYontem">Yöntem</label></td>
                                                <td>
                                                	<select id="encDecYontem" name="encDecYontem">
                                                    	<?php echo optionYap(array('b64'=>'Base64', 'rot13'=>'ROT13', 'url'=>'PHP urlencode/urldecode', 'utf8'=>'PHP utf8_encode/utf8_decode', 'qp' => 'Quoted printable'), @$_POST['encDecYontem']); ?>
                                                        <script type="text/javascript">
															var postEncDecYontem = '<?php echo htmlspecialchars(@$_POST['encDecYontem'], ENT_QUOTES, 'utf-8'); ?>';
															jQuery.each(jsOps, function(i, s){document.write('<option value="'+i+'"'+(postEncDecYontem == i ? ' selected="selected" ' : '')+'>'+s+'</option>');});
														</script>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td width="300" align="left" valign="top">
                                	<h2>Çıktı Seçenekleri</h2>
                                    <br />
                                    <table border="0" cellpadding="0" cellspacing="4">
                                    	<tr>
                                    		<td width="65" valign="middle">Çıktı Yeri</td>
                                    		<td valign="middle">
                                    			<input type="radio" id="ciktiYeriEkran" name="ciktiYeri" value="ekran" onclick="tab('ciktiYeriDiv', 'ciktiYeriEkranDiv')" <?php if (!isset($_POST['ciktiYeri']) || $_POST['ciktiYeri'] == 'ekran') { ?>checked="checked"<?php } ?> /><label for="ciktiYeriEkran">Ekran</label>
                                    			<span class="ciktiYeriDiv" id="ciktiYeriEkranDiv" style="display:none"></span><br />
                                                <input id="ciktiYeriDosya" type="radio" name="ciktiYeri" value="dosya" onclick="tab('ciktiYeriDiv', 'ciktiYeriDosyaDiv');$('ciktiYeriDosyaAdi').activate();" <?php if (isset($_POST['ciktiYeri']) && $_POST['ciktiYeri'] == 'dosya') { ?>checked="checked"<?php } ?> /><label for="ciktiYeriDosya">Dosya</label>
                                                <span class="ciktiYeriDiv" id="ciktiYeriDosyaDiv" style="display:none">
                                                	<label> Adı : <input type="text" id="ciktiYeriDosyaAdi" name="ciktiYeriDosyaAdi" size="18" /><br />( uzantıyla beraber )</label>
                                                </span>
                                    		</td>
                                    	</tr>
                                    	<tr><td colspan="2" style="height: 10px;"></td></tr>
                                		<tr>
                                			<td valign="middle"><label for="ciktiFormati">Çıktı Formatı</label></td>
                                			<td valign="middle">
                                				<select id="ciktiFormati" name="ciktiFormati">
                                                	<option value="duz">Düz</option>
                                                    <option value="b64">Base64</option>
                                                </select>
                                			</td>
                                		</tr>
                                	</table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="3">
                                	<h2>&nbsp;</h2>
                                	<div align="center">
                                        <input type="hidden" name="sent" value="1" />
                                        <input class="btn" type="submit" value="Çalıştır" />
                                    </div>
                                </td>
                            </tr>
                            <tr id="ciktiTr" style=" <?php echo (isset($cikti) && $_POST['ciktiYeri'] == 'ekran' ? '' : 'display:none;'); ?>">
                            	<td colspan="3">
                                	<h2 align="center">Çıktı</h2>
                                    <textarea readonly="readonly" name="cikti" id="cikti" style="border: solid 1px #999; padding: 3px; width: 99%;" rows="15" cols="50"><?php echo @$cikti; ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
    	</table>
        <script type="text/javascript">
        	//<![CDATA[
			<?php if (isset($_POST['islem']) && $_POST['islem'] != '') { ?>
				var postIslem = '<?php echo htmlspecialchars($_POST['islem'], ENT_QUOTES, 'utf-8'); ?>';
				var sel = $('input:radio[name=islem][value="'+postIslem+'"]');
				if (sel) {
					sel.click();
				}
			<?php } ?>
			//]]>
		</script>
    </body>
</html>
