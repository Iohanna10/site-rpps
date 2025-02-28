<?php require("config/content-config.php"); /* pegar a url */ ?> 
<head>
    <link rel="shortcut icon" href="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/favicon/favicon.png")?>" type="image/x-icon">
    <title><?php echo ucfirst($url) . " - " . $_GET['pdf'] ?></title>
</head>
<body style="margin: 0;">
<?php

/**
função para buscar pdf's em todos os diretórios até encontrá-los (ou não).
*/

$namePdf = $_GET['pdf']; // nome do pdf que vem da url

/*
$arrayPath: (todos os diretórios e arquivos encontrados)
scandir = pega todos os diretórios e arquivos e transforma em array
array_diff = retira os "." do array 
*/

$arrayPath = array_diff(scandir("././dynamic-page-content/$url/assets/uploads/pdf"), ['.', ".."]); 

$foundFile = false; // o arquivo foi encontrado?

// loop para verificação
foreach ($arrayPath as $path) {

    $currentDir = "././dynamic-page-content/$url/assets/uploads/pdf/$path"; // diretório atual

    // função para verificar se o arquivo existe e exibi-lo
    $foundFile = findPdf($currentDir); // retorna true se o arquivo existir
    
    if($foundFile === true){
        break; // para o loop
    }
}

if(!$foundFile){
    echo "Não há nada para ver aqui, arquivo não encontrado.";
}

function findPdf($currentDir){

    // pegar a url
    require("config/content-config.php");

    $namePdf = $_GET['pdf']; // nome do pdf


        if(is_dir($currentDir)){

        // verificar se o arquivo existe no diretório atual
        if(is_file("$currentDir/$namePdf")){

            // var_dump($currentDir);
            
            // exibir arquivo
            echo '<embed src="' . base_url("$currentDir/$namePdf") .'" type="application/pdf" width="100%" height="100%">';

            return true;
        } 

        // verificar se o arquivo está fora do diretório
        elseif(is_file("$currentDir/../$namePdf")){
            
            // exibir arquivo
            echo '<embed src="' . base_url("$currentDir/../$namePdf") .'" type="application/pdf" width="100%" height="100%">';
            
            return true;
        }

        // verificar se o diretório atual possui outros diretórios e repetir a função
        elseif(is_dir($currentDir)){
            $newArrayPath = array_diff(scandir($currentDir), ['.', ".."]);

            foreach ($newArrayPath as $path) {
                
                if(findPdf("$currentDir/$path") === true){
                    return true;
                }
            }
        }

    }
}

?>
</body>
