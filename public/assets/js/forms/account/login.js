// pegar dados para tratamento
if(document.querySelector("#btnSubmit") != null){
    document.querySelector("#btnSubmit").addEventListener("click", () => {
        submit();
    })
}

$(".access input").keypress(function (e) {
    if (e.key === 'Enter') 
        submit();
})

function submit(){
    document.querySelector('#btnSubmit').innerHTML = "Entrando...";

    var data = {
        id: document.getElementById("identity").value, // pegar identificação
        pass: document.getElementById("password").value, // pegar senha
        institute: getInstitute()
    };

    err = false;

    if(data.id == ''){
        getErrorLogin(0, [document.querySelector("label[for=identity] span")]);
        err = true;
    } else clearError([document.querySelector("label[for=identity] span")]);

    if(data.pass == ''){
        getErrorLogin(0, [document.querySelector("label[for=password] span")]);
        err = true;
    } else clearError([document.querySelector("label[for=password] span")]);

    if(err) return false;

    var searchField = "beneficiary"; // buscar na tabela de benefiários
    
    // verificar se é um cpf para busca no db
    if(validarCPF(data.id)){
        data.id = data.id.replace(/[^\d]+/g,'');
    }

    // verificar se é um cnpj para busca no db
    if(validarCNPJ(data.id)){
        var searchField = "institute"; // trocar para busca na tabela de institutos
        data.id = data.id.replace(/[^\d]+/g,'');
    }

    ajaxData(data, searchField)
}

// enviar dados para verificar se existem no db
function ajaxData(data, searchField){
    $.ajax({
        method: "POST", 
        url: getUriRoute(`${getInstitute()}/login-${searchField}`),
        data: data,
        success: function (response){  
            document.querySelector('#btnSubmit').innerHTML = "Entrar";

            if(response.success == true){
                window.location.replace(getUriRoute(`${getInstitute()}`));
            } 
            else if (response.success == false && response.msg != null){
                if(typeof modal === 'function'){
                    modal(response.msg);
                }
                else {
                    document.querySelector("label[for=identity] span").innerHTML = " - <i class='error'>instruções enviadas para o email.</i>"
                }
            }
            else {
                getErrorLogin(1, [document.querySelector("label[for=identity] span"), document.querySelector("label[for=password] span")]);
            }
        }
    })
}

function getErrorLogin(error, areaError){
    if(error == 0){
        areaError.forEach((label) => {
            label.innerHTML = " - <i class='error'>campo obrigatório</i>"
        });
    }
    
    if(error == 1){
        areaError.forEach((label) => {
            label.innerHTML = " - <i class='error'>login ou senha inválidos</i>"
        });
    }

    document.querySelector('#btnSubmit').innerHTML = "Entrar";
}

function clearError(areaError){
    areaError.forEach((label) => {
        label.innerHTML = ""
    });
}

// função para testar se é um cnpj
function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
}

// função para testar se é um cpf
function validarCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}