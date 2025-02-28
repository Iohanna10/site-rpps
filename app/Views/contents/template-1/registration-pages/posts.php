<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Criar Publicação</title>
</head>
<body>
    <div class="container-form contents">
        <form>
            <div class="two-inputs">
                <div>
                    <label for="area-post">Área de publicação:</label>
                    <select name="area-post" id="area-post">
                        <option value="0" selected>Sobre o instituto</option>
                        <option value="1">Legislação</option>
                        <option value="2">Prestação de contas</option>
                        <option value="3">Conselhos</option>
                        <option value="4">Publicações</option>
                        <option value="5">Segurados</option>
                    </select>
                </div>

                <div>
                    <label for="type-post">Tipo de publicação:</label>
                    <select name="type-post" id="type-post"></select>
                </div>
            </div>

            <div class="container-committee">
                <label for="committee">Publicação para o conselho:</label>
                <select name="committee" id="committee">
                    <option value="0">Comitê de Investimento</option>
                    <option value="1">Fiscal</option>
                    <option value="2">Deliberativo</option>
                </select>
            </div>
        </form>


        <form class="form-cad post-form" method="POST" enctype="multipart/form-data" id='formPost'>

            <!-- input de foto principal da notícia -->
            <div>
                <label for="img">
                    <div class="preview" title="Clique para escolher foto principal da publicação">
                        <div class="preview-img-container">

                        </div>
                        <div class="container-icon">
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar foto principal</p>
                        </div>
                    </div>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>

                <!-- erros -->
                <div class="error">
                    <div class="wrongImg"></div>
                    <div class="type"></div>
                </div>
            </div>
            <!-- fim input de foto principal da notícia -->

            <!-- título do post -->
            <div>
                <label for="title">Título da publicação:</label>
                <input type="text" name="title" id="title" placeholder="Título">

                 <!-- erros -->
                 <div class="error">
                    <div class="title"></div>
                </div>

            </div>
            <!-- fim título do post -->

            <!-- resumo do post -->
            <div>
                <label for="description">Descrição da publicação:</label>
                <textarea type="text" name="description" id="description" placeholder="Breve descrição..."></textarea>

                 <!-- erros -->
                 <div class="error">
                    <div class="description"></div>
                </div>
            </div>
            <!-- fim resumo do post -->

             <!-- conteúdo principal do post -->
             <div>
                <label for="main_content">Conteúdo principal:</label>
                <textarea class="publication" type="text" name="main_content" id="main_content" placeholder="Digite o conteúdo principal da publicação..."></textarea>
            </div>
            <!-- fim conteúdo principal do post -->

            <!-- slider -->
                <div>
                    <label for="carousel">Mídias do carrossel:</label>
                        <!-- input de fotos e vídeos carrossel -->
                        <div>
                            <label for="carousel_media">
                                <div class="preview multiple" title="Clique para escolher fotos e vídeos do carrosel">
                                    <div class="container-icon">
                                        <i class="fa-regular fa-photo-film"></i>
                                        <p>Adicionar mídias ao carrossel</p>
                                    </div>
                                </div>
                            </label>
                            <div class="preview-all-medias"></div>
                            <input type="file" name="carousel_media" id="carousel_media" accept=".png, .jpg, .jpeg, video/*" multiple="multiple">
                           
                            <!-- erros -->
                            <div class="error">
                                <div class="wrongImg"></div>
                                <div class="wrongVideo"></div>
                                <div class="type"></div>
                            </div>

                        </div>
                        <!--fim input carrossel  -->

                        <div class="edit_media d-none">

                            <!-- mais mídias -->
                            <label for="more_media">
                                <div class="btn more-medias"><span>Adicionar mídias</span></div>
                            </label>
                            <input type="file" accept=".png, .jpg, .jpeg, video/*" name="more_media" id="more_media" multiple="multiple"></input>
                            <!-- fim mais mídias  -->
                            
                            <!-- remover todads as mídias -->
                            <div class="btn remove-all"><span>Remover todas as mídias</span></div>
                            <!-- fim remover todas as mídias -->

                        </div>
                </div>
                
                <!-- input de vídeos url carrossel -->
                <div>
                    <label for="carousel_url_videos">Url's de vídeos no Youtube para o carrossel:</label>
                    <input type="text" name="carousel_url_videos" id="carousel_url_videos" placeholder="https://www.youtube.com/watch?v=exemplo, https://www.youtube.com/watch?v=exemplo2">
                    <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Separar url's por vírgula (",").</span>
                    
                    <!-- erros -->
                    <div class="error">
                        <div class="wrongUrl"></div>
                    </div>

                </div>
                <!-- fim input de vídeos url carrossel -->

            <!-- fim slider -->

            <!-- input para enviar os dados -->
            <div>
                <button type="button" name="submit">Enviar</button>
            </div>
            <!-- fim input para enviar os dados -->
            
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