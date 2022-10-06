# Relatório de entregas

## Autenticação

-   [x] Login
-   [x] Proibição de login caso o usuário não tenha finalizado seu cadastro (confirmado o e-mail cadastrado)
-   [x] Proibição de login caso o usuário não tenha sido confirmado pelo departamento
-   [x] Logout
-   [x] Cadastro
-   [x] Finalização do cadastro (confirmação do e-mail cadastrado)
-   [x] E-mail de novo usuário cadastrado que aguarda a confirmação do departamento
-   [x] Recuperação de senha
-   [x] Edição do próprio e-mail com confirmação
-   [x] Edição da própria senha

## Usuários

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Permissão concedida somente a usuários com papel de administrador de criar usuários fora do fluxo de cadastro
-   [x] Permissão concedida somente a usuários com papel de administrador de editar usuários que não a si próprio
-   [x] Permissão concedida somente a usuários com papel de administrador para remover usuários
-   [x] Proibição de remoção do usuário por ele mesmo

## Configurações

-   [x] Edição
-   [x] Visualização
-   [x] Versionamento
-   [x] Opção de fechar retiradas e devoluções para usuários comuns (alunos)
-   [x] Opção de definir datas (dia e mês) em que as retiradas e devolução não estão permitidas
-   [x] Opção da mensagem com informações acerca da confirmação das cópias finais

## Reservas

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Proibição de criação de reserva caso as reservas estejam fechadas e o usuário seja aluno
-   [x] Usuário comum (aluno) só pode adicionar a si mesmo como responsável pela reserva
-   [x] Usuário comum (aluno) só pode associar seu próprios projetos à reserva
-   [x] Proibição das retiradas serem feitas com menos de 3 dias de antecedência
-   [x] Proibição das devoluções serem feitas antes das retiradas
-   [x] Proibição das retiradas ou devoluções cairem no final de semana
-   [x] Proibição das retiradas ou devoluções cairem nas datas (dia e mês) proibidos nas configurações
-   [x] Proibição dos equipamentos já reservados entre a retirada e devolução serem reservados novamente
-   [x] E-mail para os usuários com papel de almoxarifado sobre a criação de uma reserva
-   [x] E-mail para os usuários com papel de almoxarifado sobre a edição de uma reserva
-   [x] E-mail para o professor responsável pelo projeto associado à reserva sobre a criação da reserva
-   [x] E-mail para o professor responsável pelo projeto associado à reserva sobre a edição da reserva
-   [ ] E-mail para relembrar sobre a reserva um dia anterior
-   [ ] E-mail para relembrar sobre a reserva no dia
-   [ ] Comando que verifica diariamente para relembrar retiradas
-   [ ] E-mail para relembrar sobre a devolução um dia anterior
-   [ ] E-mail para relembrar sobre a devolução no dia
-   [ ] Comando que verifica diariamente para relembrar devoluções

## Reserváveis

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Permissão de criação, edição e remoção concedida somente a usuários com papel de administrador ou almoxarifado
-   [x] E-mail para responsáveis por reservas com o reservável quando o mesmo é marcado como em manutenção
-   [x] E-mail para responsáveis por reservas com o reservável quando o mesmo é marcado como com a devolução atrasada

## Categorias de reserváveis

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Permissão de criação, edição e remoção concedida somente a usuários com papel de administrador ou almoxarifado

## Projeto

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Usuário comum (aluno) só pode adicionar a si mesmo como responsável do projeto
-   [x] Somente usuários com papel de professor podem ser adicionados como professores responsáveis
-   [x] Permissão de edição e remoção concedida apenas à usuários com papéis de administrador, departamento ou o próprio responsável do projeto
-   [x] E-mails para usuários com papéis de departamento e almoxarifado sobre a criação de um novo projeto
-   [x] E-mails para o professor responsável pelo projeto sobre a criação de um novo projeto
-   [x] E-mails para a equipe do projeto sobre a criação de um novo projeto
-   [ ] Proibição de um novo projeto ser criado pelo usuário caso ele já possua um projeto sem cópia final

## Cópias Finais

-   [ ] Criação
-   [ ] Visualização
-   [ ] Edição
-   [ ] Remoção
-   [ ] Versionamento
-   [ ] Usuário comum (aluno) só pode adicionar a si mesmo como responsável da cópia final
-   [ ] Somente usuários com papel de professor podem ser adicionados como professores responsáveis
-   [ ] Permissão de edição e remoção concedida apenas à usuários com papéis de administrador, departamento ou o próprio responsável da cópia final
-   [ ] E-mails para usuários com papéis de departamento sobre a criação de um nova cópia final
-   [ ] E-mails para o professor responsável pela cópia final sobre a criação de um nova cópia final
-   [ ] E-mails para a equipe da cópia final sobre a criação de um nova cópia final
-   [ ] E-mails para a equipe da cópia final sobre a criação de um nova cópia final
-   [ ] Exibição de mensagem com informações acerca da confirmação das cópias finais definida nas configurações
-   [ ] E-mails para usuários com papéis de departamento sobre a confirmação de um nova cópia final

## Modalidades

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Permissão de criação, edição e remoção concedida somente a usuários com papel de administrador ou departamento

## Funções

-   [x] Criação
-   [x] Visualização
-   [x] Edição
-   [x] Remoção
-   [x] Versionamento
-   [x] Permissão de criação, edição e remoção concedida somente a usuários com papel de administrador ou departamento

## Gerais

-   [ ] Migração dos dados de usuários do dados do banco de dados antigo
-   [ ] Migração dos dados de configurações do dados do banco de dados antigo
-   [ ] Migração dos dados de reservas do dados do banco de dados antigo
-   [ ] Migração dos dados de reserváveis do dados do banco de dados antigo
-   [ ] Migração dos dados de categorias de reserváveis do dados do banco de dados antigo
-   [ ] Migração dos dados de projetos do dados do banco de dados antigo
-   [ ] Migração dos dados de cópias finais do dados do banco de dados antigo
-   [ ] Migração dos dados de modalidades do dados do banco de dados antigo
-   [ ] Migração dos dados de funções do dados do banco de dados antigo
-   [ ] Visualização de versões de usuários
-   [ ] Visualização de versões das configurações
-   [ ] Visualização de versões das reservas
-   [ ] Visualização de versões dos reserváveis
-   [ ] Visualização de versões das categorias de reserváveis
-   [ ] Visualização de versões dos projetos
-   [ ] Visualização de versões das cópias finais
-   [ ] Visualização de versões das modalidades
-   [ ] Visualização de versões das funções
