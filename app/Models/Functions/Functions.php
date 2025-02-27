<?php

namespace App\Models\Functions;

use CodeIgniter\Model;

class Functions extends Model {

    protected $table = 'posts';

    function AjaxConstructor()
	{
		parent::Model();
	}

    public function newName($name) { # criar e retornar um nome único para as mídias
        if(pathinfo($name, PATHINFO_EXTENSION) != '') {
            $newName = uniqid() . "." . pathinfo($name, PATHINFO_EXTENSION);
            return $newName;
        }
        return $name;
    }

    public function deleteFiles($files, $path){ # deletar arquivos
        foreach ($files as $key => $file) {
            if(isset($file)){
                if(file_exists("$path$file")){
                    unlink("$path$file");
                }
            }
        }
    }

    public function removeEmptyDir($dir) {
        $files = array_diff(scandir($dir), array('.','..')); 
        if(count($files) === 0){
            rmdir($dir); 
        }
    }

    public function delTree($dir) { # remover pasta
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    }

    public function getType($type){ # retorna tipo
        if($type == 'img'){
            return 'imagem_principal';
        } 
        elseif ($type == 'carousel_media') {
            return 'midias';
        }
    }

    public function nameDir($str){ # alterar nome do diretório
        $chars = array(
			// Decompositions for Latin-1 Supplement.
			'ª' => 'a', 'º' => 'o', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 'ß' => 's', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y', 'Ø' => 'O', 
            // Decompositions for Latin Extended-A.
			'Ā' => 'A', 'ā' => 'a', 'Ă' => 'A', 'ă' => 'a', 'Ą' => 'A', 'ą' => 'a', 'Ć' => 'C', 'ć' => 'c', 'Ĉ' => 'C', 'ĉ' => 'c', 'Ċ' => 'C', 'ċ' => 'c', 'Č' => 'C', 'č' => 'c', 'Ď' => 'D', 'ď' => 'd', 'Đ' => 'D', 'đ' => 'd', 'Ē' => 'E', 'ē' => 'e', 'Ĕ' => 'E', 'ĕ' => 'e', 'Ė' => 'E', 'ė' => 'e', 'Ę' => 'E', 'ę' => 'e', 'Ě' => 'E', 'ě' => 'e', 'Ĝ' => 'G', 'ĝ' => 'g', 'Ğ' => 'G', 'ğ' => 'g', 'Ġ' => 'G', 'ġ' => 'g', 'Ģ' => 'G', 'ģ' => 'g', 'Ĥ' => 'H', 'ĥ' => 'h', 'Ħ' => 'H', 'ħ' => 'h', 'Ĩ' => 'I', 'ĩ' => 'i', 'Ī' => 'I', 'ī' => 'i', 'Ĭ' => 'I', 'ĭ' => 'i', 'Į' => 'I', 'į' => 'i', 'İ' => 'I', 'ı' => 'i', 'Ĳ' => 'IJ', 'ĳ' => 'ij', 'Ĵ' => 'J', 'ĵ' => 'j', 'Ķ' => 'K', 'ķ' => 'k', 'ĸ' => 'k', 'Ĺ' => 'L', 'ĺ' => 'l', 'Ļ' => 'L', 'ļ' => 'l', 'Ľ' => 'L', 'ľ' => 'l', 'Ŀ' => 'L', 'ŀ' => 'l', 'Ł' => 'L', 'ł' => 'l', 'Ń' => 'N', 'ń' => 'n', 'Ņ' => 'N', 'ņ' => 'n', 'Ň' => 'N', 'ň' => 'n', 'ŉ' => 'n', 'Ŋ' => 'N', 'ŋ' => 'n', 'Ō' => 'O', 'ō' => 'o', 'Ŏ' => 'O', 'ŏ' => 'o', 'Ő' => 'O', 'ő' => 'o', 'Œ' => 'OE', 'œ' => 'oe', 'Ŕ' => 'R', 'ŕ' => 'r', 'Ŗ' => 'R', 'ŗ' => 'r', 'Ř' => 'R', 'ř' => 'r', 'Ś' => 'S', 'ś' => 's', 'Ŝ' => 'S', 'ŝ' => 's', 'Ş' => 'S', 'ş' => 's', 'Š' => 'S', 'š' => 's', 'Ţ' => 'T', 'ţ' => 't', 'Ť' => 'T', 'ť' => 't', 'Ŧ' => 'T', 'ŧ' => 't', 'Ũ' => 'U', 'ũ' => 'u', 'Ū' => 'U', 'ū' => 'u', 'Ŭ' => 'U', 'ŭ' => 'u', 'Ů' => 'U', 'ů' => 'u', 'Ű' => 'U', 'ű' => 'u', 'Ų' => 'U', 'ų' => 'u', 'Ŵ' => 'W', 'ŵ' => 'w', 'Ŷ' => 'Y', 'ŷ' => 'y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'ź' => 'z', 'Ż' => 'Z', 'ż' => 'z', 'Ž' => 'Z', 'ž' => 'z', 'ſ' => 's', 
            // Decompositions for Latin Extended-B.
			'Ə' => 'E', 'ǝ' => 'e', 'Ș' => 'S', 'ș' => 's', 'Ț' => 'T', 'ț' => 't', // Euro sign.
			'€' => 'E',
			// GBP (Pound) sign.
			'£' => '',
			// Vowels with diacritic (Vietnamese). Unmarked.
			'Ơ' => 'O', 'ơ' => 'o', 'Ư' => 'U', 'ư' => 'u', // Grave accent.
			'Ầ' => 'A', 'ầ' => 'a', 'Ằ' => 'A', 'ằ' => 'a', 'Ề' => 'E', 'ề' => 'e', 'Ồ' => 'O', 'ồ' => 'o', 'Ờ' => 'O', 'ờ' => 'o', 'Ừ' => 'U', 'ừ' => 'u', 'Ỳ' => 'Y', 'ỳ' => 'y', 
            // Hook.
			'Ả' => 'A', 'ả' => 'a', 'Ẩ' => 'A', 'ẩ' => 'a', 'Ẳ' => 'A', 'ẳ' => 'a', 'Ẻ' => 'E', 'ẻ' => 'e', 'Ể' => 'E', 'ể' => 'e', 'Ỉ' => 'I', 'ỉ' => 'i', 'Ỏ' => 'O', 'ỏ' => 'o', 'Ổ' => 'O', 'ổ' => 'o', 'Ở' => 'O', 'ở' => 'o', 'Ủ' => 'U', 'ủ' => 'u', 'Ử' => 'U', 'ử' => 'u', 'Ỷ' => 'Y', 'ỷ' => 'y', // Tilde.
			'Ẫ' => 'A', 'ẫ' => 'a', 'Ẵ' => 'A', 'ẵ' => 'a', 'Ẽ' => 'E', 'ẽ' => 'e', 'Ễ' => 'E', 'ễ' => 'e', 'Ỗ' => 'O', 'ỗ' => 'o', 'Ỡ' => 'O', 'ỡ' => 'o', 'Ữ' => 'U', 'ữ' => 'u', 'Ỹ' => 'Y', 'ỹ' => 'y', 
            // Acute accent.
			'Ấ' => 'A', 'ấ' => 'a', 'Ắ' => 'A', 'ắ' => 'a', 'Ế' => 'E', 'ế' => 'e', 'Ố' => 'O', 'ố' => 'o', 'Ớ' => 'O', 'ớ' => 'o', 'Ứ' => 'U', 'ứ' => 'u', // Dot below.
			'Ạ' => 'A', 'ạ' => 'a', 'Ậ' => 'A', 'ậ' => 'a', 'Ặ' => 'A', 'ặ' => 'a', 'Ẹ' => 'E', 'ẹ' => 'e', 'Ệ' => 'E', 'ệ' => 'e', 'Ị' => 'I', 'ị' => 'i', 'Ọ' => 'O', 'ọ' => 'o', 'Ộ' => 'O', 'ộ' => 'o', 'Ợ' => 'O', 'ợ' => 'o', 'Ụ' => 'U', 'ụ' => 'u', 'Ự' => 'U', 'ự' => 'u', 'Ỵ' => 'Y', 'ỵ' => 'y',
			// Vowels with diacritic (Chinese, Hanyu Pinyin).
			'ɑ' => 'a',
			// Macron.
			'Ǖ' => 'U', 'ǖ' => 'u',
			// Acute accent.
			'Ǘ' => 'U', 'ǘ' => 'u',
			// Caron.
			'Ǎ' => 'A', 'ǎ' => 'a', 'Ǐ' => 'I', 'ǐ' => 'i', 'Ǒ' => 'O', 'ǒ' => 'o', 'Ǔ' => 'U', 'ǔ' => 'u', 'Ǚ' => 'U', 'ǚ' => 'u',
			// Grave accent.
			'Ǜ' => 'U', 'ǜ' => 'u',
        );

        $special_chars = array('¹', '²', '³', '¬', '¢', '¨', '-', '§', 'ª', 'º', '°', '^', '´', '@', '?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', '’', '‘', '«', '»', '”', '“', chr( 0 ));

        $str = str_replace($special_chars, '', $str); // remove caracteres especiais
        $str = strtr($str, $chars); // remove acentuação
        $str = preg_replace('/[^A-Za-z ]/u', '', $str); // remove qualquer outro caractere especial 
        $str = strtolower(trim($str));
        $str = str_replace(' ', '_', $str); // remover espaços no começo e final, setar para letras minúsculas e alterar espaços para "_"

        return $str;
    }

    function changeQuotes($str) {
        $new_str = $this->changeFor(explode('"', $str), '“', '”');
        $new_str = $this->changeFor(explode("'", $new_str), "‘", "’");

        return $new_str;
    }

    function changeFor($parts, $charOpen, $charClose) {
        $new_str = ''; // nova string

        if(count($parts) > 1) {
            foreach ($parts as $key => $part) {
                if($key % 2 == 0) {
                    $new_str = $new_str . $part;
                }
                else {
                    $new_str = $new_str . $charOpen . $part . $charClose;
                }
            }

            return $new_str;
        }
        
        return $parts[0];
    }
}
