# site-rpps
Site de RPPS da WebPrev 

RPPS - Sistema de Gestão de Regimes Próprios de Previdência Social.

Este repositório contém o código-fonte para o desenvolvimento de um site dedicado a Institutos de Regimes Próprios de Previdência Social (RPPS). O objetivo principal do sistema é fornecer uma plataforma para que os institutos mantenham os servidores informados e atualizados sobre notícias, eventos e serviços relacionados à previdência. A plataforma também oferece links úteis para acessar informações essenciais, como `Calendário de pagamentos`, `Prova de vida`, `Legislação previdenciária`, `Emissão de certificados`, `Folha de pagamentos` e `Portal de Transparência`.

## Tecnologias Utilizadas
- **HTML** e **CSS**: Para estruturar e estilizar o conteúdo das páginas.
- **JavaScript**: Para interatividade e funcionalidades dinâmicas.
- **PHP**: Para o backend e lógica do sistema.
- **MySQL**: Para gerenciamento de banco de dados.

## Funcionalidades de gestão dedicadas ao instituto
- **Avaliações e Feedbacks**: Área para visualizar as satisfação dos servidores com o desempenho do instituto.
- **Configurações**:
  - **Informações**: Área para gerenciar as informações do instituto (endereço, horário de atendimento, princípios, etc.)
  - **Personalizar**: Área para personalizar o instituto (adicionar banner, alterar cores, gerenciar os temas, etc.)
- **Gerenciamento de Publicações (Publicação, Edição e Exclusão)**:
  - **Galerias**: Área gerenciamento das galerias.
  - **Notícias**: Área gerenciamento de notícias importantes para os servidores, incluindo o destaque de publicação.
  - **Eventos**: Área gerenciamento de eventos e das reuniões dos membros dos conselhos.
  - **Equipes**: Área gerenciamento dos membros pertencentes aos conselhos/equipe do instituto.
  - **CRPS**: Área gerenciamento dos certificados de regularidade previdenciária.
  - **Cálculo Atuarial**: Área gerenciamento dos relatórios de calculo atuarial.

## Funcionalidades dedicadas ao usuário
- **Notícias**: Área para visualizar as notícias publicadas pelo instituto.
- **Pesquisa**: Área para pesquisar por títulos especificos em noticias publicadas pelo instituto.
- **Links Úteis**:
  - Calendário de Pagamentos: Para consultar as datas de pagamento e vencimento.
  - Prova de Vida: Acesso a informações sobre o processo de prova de vida e envio das provas para serem avaliadas pelo instituto.
  - Legislação Previdenciária: Principais normas e leis que regulamentam os RPPS.
  - Emissão de Certificados: Sistema para emissão de certificados de contribuições.
  - Folha de Pagamentos: Acesso às folhas de pagamento dos servidores.
  - Portal de Transparência: Informações sobre a transparência na gestão do RPPS.
- **Calendário de eventos**: Visualizar os eventos do ano e checar suas informações.
- **Informações do instituto**: Visualizar as informações de funcionamento do instituto (no rodapé da página), bem como outras informações (Princípios, Membros dos Conselhos, etc.) em páginas interenas dedicadas.
- **Avaliações e Feedback**: Avaliar por meio de enquetes a satisfação com o instiuto, enviar um feedback e visualizar a satisfação geral e feedbacks de outros servidores.
- **Fale conosco**: Enviar email de contato para o instituto.

### Funcionalidades que receberão possíveis altearações:
- **Cadastro de usuários**: Atualmente permite ao usuário se cadastrar sem aprovação do instituto e sem verificação de CPF por uma base de dados (Receita Federal, DataPrev, Serpro, entre outro).
  - Possível alteração - receber usuários diretamente da base de dados do sistema Meu RPPS e remover a funcionalidade de cadastro.
- **Configurações de perfil**: Atualmente permite ao usuário alterar livremente as informações de perfil.
  - Possível alteração - restringir informações passiveis de alteração.

## Como Executar o Projeto

### 1. Clone o repositório
```bash
git clone https://github.com/Iohanna10/site-rpps.git
```
### 2. Configuração do Ambiente:
- Instale o PHP e o MySQL em sua máquina, caso ainda não os tenha.
- Configure o seu banco de dados MySQL com as tabelas necessárias. Você pode usar o arquivo rpps-schema.sql para criar as tabelas iniciais.

### 3. Configuração do Banco de Dados:
- No arquivo app\Config\Database.php, altere as credenciais do banco de dados para se conectar ao MySQL.

### 4. Inicie o servidor local:
- Coloque os arquivos na pasta htdocs e inicie o servidor Apache e MySQL.

### 5. Acesse o site:
- Abra o navegador e acesse http://localhost:8000 (ou o endereço configurado).
