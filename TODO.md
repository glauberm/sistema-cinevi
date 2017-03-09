# TO-DO

## Da reunião
- startDate do CalendarEvent no mínimo três dias depois de hoje -- edição também proibida pelo prazo de três dias, senão pode cancelar -- cancelamento por remoção (avisar se não der certo a questão da edição)
- Se marcado como "Em Manutenção", avisar todos que pegaram esse equipamento depois daquela data
- Nova role que é só aprovação de usuário
- O responsável por um projeto só pode criar outro projeto quando criar uma cópia final para aquele projeto
- Adicionar campo Projeto na Cópia Final com opçãos de "Outros"
- Dia de Ínicio para Dia de Retirada e Dia de Fim para Dia de Devolução
- Reserva: link para o projeto
- Na visualização do dia, mostrar com a cor verde se for retirada, e vermelho se for devolução
- Campo de Equipamentos da Reserva só mostra equipamentos com manutenção -> "NÃO"
- Exportar .csv dos equipamentos

## Imediato
- Corrigir Reservas

## Cópias Finais
- Além das fotos still, link (com possível senha) do filme
- VichUploaderBundle para os MateriaisDivulgacao (add em CopiaFinal)

## Reservas
- Ver DynamicType nos equipamentos

## Template
- Adicionar ícones nos botões de adicionar, editar e remover e deixá-los fixos na nav-bar. Possíveis botões extras vão para o accordion.
- Adicionar máscaras de dinheiro, integer
- Mudar ícones nos links de painel de controle e de funções

## Validação
- Checar todos os integers para avaliação de number aparecer primerio

## CRON
- Checar se dia atual é startDate ou endDate de alguma reserva e enviar email.

## Geral
- Checar spool e emails no servidor (mudar para /home/cinem752/spool)
- Passar a listagem, a busca por roles e outros pro Repository
- Add o "pular para o main-content" (possivelmente outras questões de acessibilidade?)

## Gráficos
- Quantidade de diretores, produtores, etc. em projetos
- Quantidade de equipamentos por categoria
- Quantidade de projetos/mês

# Perguntas
- Mais campos das Cópias Finais para Realização para aproveitar também no Projeto
- Mais funções no Projeto?
- Interessa que os alunos preencham informações no sistema? (Talvez criar um atributo universal de "submetido por"? e Tentar um AJAX/DynamicType para poder adicionar o campo e já alterá-lo -- por exemplo, no campo das funções adicionar mais uma função através de um modal e já adicionar a opção sem recarregar)
- Interessa uma home com vídeos e outras informações do sistema (Breve currículo para os usuários com rich-text editor e Criar view de página inicial (fora do painel de controle) com infor dos usuários, filmes etc. e Fazer "Outros" podendo os usuários adicionarem?)

# Depois
- Mudar rodapé do site: tirar o "Voltar ao topo" para "Código por Glauber Mota"
- Ações em múltiplos itens de uma vez
- Linhas na tabela pelo php ao invés de javascript
- Adicionar https://packagist.org/packages/friendsofsymfony/elastica-bundle
- Se criar o submitted by nos objetos (pela pergunta 'Interessa que os alunos preencham informações no sistema?'), também criar um atributo "rascunho" que, se existir, não mostra os objetos para todos (publico, criar botão "enviar/publicar"), só para o usuário que criou (rascunho, criar botão "salvar com rascunho")
- Checar o deprecated no ```The hardcoded value you are using for the $referenceType argument of the Symfony\Component\Routing\Generator\UrlGenerator::generate method is deprecated since version 2.8 and will not be supported anymore in 3.0. Use the constants defined in the UrlGeneratorInterface instead:```
- Criar factory (http://symfony.com/doc/2.8/service_container/factories.html)
