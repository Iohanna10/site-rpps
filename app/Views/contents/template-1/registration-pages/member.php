<!DOCTYPE html>
<html lang="pt-br">
<body>
    <div class="container-form contents">
        <form class="form-cad" method="POST" enctype="multipart/form-data">
            
            <div>
                <label for="img">
                    <div class="preview profile" title="Clique para escolher foto do integrante">
                    <div class="preview-img-container"></div>
                        <div class="container-icon">
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar foto do integrante</p>
                        </div>
                    </div>

                    <span class="error"></span>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg(this)" required>
            </div>

            <div>
                <label for="name">Nome completo:<span class="error"></span></label>
                <input id="name" type="text" name="name" placeholder="Nome" required>
            </div>
    
            <div class="cpf-div">
                <label for="cpf">CPF:<span class="error"></span></label>
                <input type="text" id="cpf" name="cpf" oninput="mascara(this)" placeholder="CPF" required>
                <div class="status">
                    <i class="fa-solid fa-xmark-large error"></i>
                    <i class="fa-solid fa-check ok"></i>
                </div>
            </div>
            
            <div>
                <label for="member_position">Área de atuação:<span class="error"></span></label>
                <input type="text" name="member_position" id="member_position" placeholder="Ex: Contador, Advogado, Agente Administrativo" required>
            </div>
    
            <div class="two-inputs">
                <div class="biggest">
                    <label for="member_location">Local em que está atuando:<span class="error"></span></label>
                    <input type="text" name="member_location" id="member_location" placeholder="Ex: Secretaria de Planejamento, Secretaria de Saúde" required>
                </div>
                <div class="smallest">
                    <label for="holder">É títular?</label>
                    <select name="holder" id="holder" title="Selecione se o membro é ou não efetivado em seu cargo" required>
                        <option value="0" selected>Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
            </div>
    
            <div>
                <label for="certificate">Certificação e validade da certificação:</label>
                <textarea id="certificate" class="editor-c" type="text" name="certificate" placeholder="Ex: certificação APIMEC CGRPPS nº 443, com validade até 20/08/2025." data-value=""></textarea>
            </div>
    
            <div>
                <label for="email">E-mail para contato com a equipe em que o membro atua:<span class="error"></span></label>
                <input type="email" name="email" id="email" placeholder="E-mail">
            </div>
    
            <div>
                <label for="tel">Número de telefone para contato com a equipe em que o membro atua:<span class="error"></span></label>
                <input type="tel" id="tel" name="tel" onkeypress="mask(this, mphone)" placeholder="Nº de telefone" />
            </div>

            <div>
                <label for="council">Selecione a equipe a qual o membro pertence:</label>
                <select name="council" id="council" required>
                    <option value="0" selected>Equipe do instituto</option>
                    <option value="1">Cômite de investimentos</option>
                    <option value="2">Cômite Fiscal</option>
                    <option value="3">Cômite Deliberativo</option>
                </select>
            </div>

            <div>
                <button id="submit" type="button">Cadastrar</button>
            </div>
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success fa-sharp fa-solid fa-check"></i></h1>
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>
    </div>
</body>
</html>
