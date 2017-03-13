# TO-DO

## Da reunião
- Se marcado como "Em Manutenção", avisar todos que pegaram esse equipamento depois daquela data
- O responsável por um projeto só pode criar outro projeto quando criar uma cópia final para aquele projeto
- Ver DynamicType nos equipamentos

## Geral
- Checar spool e emails no servidor (mudar para /home/cinem752/spool)

## Template
- Adicionar ícones nos botões de adicionar, editar e remover e deixá-los fixos na nav-bar. Possíveis botões extras vão para o accordion.
- Adicionar máscaras de dinheiro, integer
- Mudar ícones nos links de painel de controle e de funções

## Validação
- Checar todos os integers para avaliação de number aparecer primerio

## Cópias Finais
- Além das fotos still, link (com possível senha) do filme
- VichUploaderBundle para os MateriaisDivulgacao (add em CopiaFinal)

## CRON
- Checar se dia atual é startDate ou endDate de alguma reserva e enviar email.

## Gráficos
- Quantidade de diretores, produtores, etc. em projetos
- Quantidade de equipamentos por categoria
- Quantidade de projetos/mês

# Perguntas
- Um Projeto para Uma Cópia Final, certo? (OneToOne)

- Mais campos das Cópias Finais para Realização para aproveitar também no Projeto
- Mais funções no Projeto?
- Interessa que os alunos preencham informações no sistema? (Talvez criar um atributo universal de "submetido por"? e Tentar um AJAX/DynamicType para poder adicionar o campo e já alterá-lo -- por exemplo, no campo das funções adicionar mais uma função através de um modal e já adicionar a opção sem recarregar)
- Interessa uma home com vídeos e outras informações do sistema (Breve currículo para os usuários com rich-text editor e Criar view de página inicial (fora do painel de controle) com infor dos usuários, filmes etc. e Fazer "Outros" podendo os usuários adicionarem?)

# Depois
- Passar a listagem, a busca por roles e outros pro Repository
- Ações em múltiplos itens de uma vez
- Linhas na tabela pelo php ao invés de javascript
- Adicionar https://packagist.org/packages/friendsofsymfony/elastica-bundle
- Se criar o submitted by nos objetos (pela pergunta 'Interessa que os alunos preencham informações no sistema?'), também criar um atributo "rascunho" que, se existir, não mostra os objetos para todos (publico, criar botão "enviar/publicar"), só para o usuário que criou (rascunho, criar botão "salvar com rascunho")
