# TO-DO

- CalendarEvent: ajax só é chamado no endDate -- melhor dar erro do que ficar vazio -- ver NotBlank?
- Entrando como aluno, eu não deveria poder clicar em "Usuários" e visualizar a lista de usuários. Isso deve estar habilitado só para "Departamento", "Almoxarifado" e "Administrador" verem (mas só "Departamento" e "Administrador" editarem)
- Os equipamentos Fone estão com um erro de digitação: p2, estério Tsi 433 (não é estério, mas estéreo)
- O equipamento DV/HDD/DVD JVC SR-DVM700 Blu-ray/DVD/Mini DV/Player deve sair do sistema, pois ele não está no almoxarifado e não é para ser emprestado.
- No cadastro da cópia final campos não obrigatórios para link do Vimeo e senha.
- Que a cópia final cadastrada depois do funcionário ter dado baixa gere um email para a comissão de festivais (morenoantonio.n@gmail.com)
- Barrar além dos finais de semana os feriados deste ano
- Quando há alteração na reserva o professor responsável pelo projeto recebe notificação?
- (essa sugestão pode ser executada ao longo do semestre) Que quando a gente clica nas reservas os equipamentos reservados apareçam não em linha, e sim em coluna
- Na casa do Rafael aquela opção de alterar o número de linhas visualizadas no item "equipamentos" funcionou, no teste no IACS não (no IACS usamos MAC, não sei se isso tem algo a ver)
- (acho que essa aqui também não é pra curto prazo) Foi pedido pra que se pudesse ver os equipamentos por categoria antes da reserva
- O nome da disciplina de Direção de Arte é Design Visual
- Não tem logo da UFF na nossa página
- Arrumar coisas para SEO

## Da reunião
- Ações múltiplas de confirmação na tabela dos usuários - Confirmação
- Criar confirmação para Cópia Final ("Pendente entrega a cópia do filme") com notificação o usuário.
- Qualquer usuário pode cadastrar Função (pendente aprovação) *** COLOCAR OPÇÕES PARA OS USUÁRIOS COMPLETAREM TODAS AS OPÇÕES DAS CÓPIAS FINAIS ***

# Site
- Colocar alerta no topo do site de "Clique em "Acessar o Sistema" no menu para ir ao sistema".

## Cópias Finais
- Máscara de dinheiro
- Além das fotos still, link (com possível senha) do filme
- VichUploaderBundle para os MateriaisDivulgacao (add em CopiaFinal)

## CRON
- Comando para deletar emails da caixa de entrada automaticamente a cada ano.

## Gráficos
- Quantidade de diretores, produtores, etc. em projetos
- Quantidade de equipamentos por categoria
- Quantidade de projetos/mês

# Depois
- Passar a listagem, a busca por roles, as createQueryBuilder dos formulários e outros pro Repository
- Ações em múltiplos itens de uma vez
- Nº de Linhas na tabela pelo php ao invés de javascript
- Adicionar https://packagist.org/packages/friendsofsymfony/elastica-bundle
- Se criar o submitted by nos objetos (pela pergunta 'Interessa que os alunos preencham informações no sistema?'), também criar um atributo "rascunho" que, se existir, não mostra os objetos para todos (publico, criar botão "enviar/publicar"), só para o usuário que criou (rascunho, criar botão "salvar com rascunho")
