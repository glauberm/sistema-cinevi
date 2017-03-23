# TO-DO

## Da reunião
- Ações múltiplas de confirmação na tabela dos usuários
- Variável de config não passando para o SecurityBundle
- Máscara de dinheiro
- Criar confirmação para Cópia Final ("Pendente entrega a cópia do filme") com notificação o usuário.
- Cópia final após criação: "Para finalizar o processo você deve se encontrar com Cláudio (disponível na Sala Zeca Porto, de 8 às 14h), que pode ser contatado pelo e-mail claudio.ciambelli@gmail.com , para entrega-lo um arquivo da versão final do filme, obrigatoriamente no seguinte formato: MPEG4 H264. Deverá entregá-lo também uma cópia de visionamento, no formato MOV.
Assim que o processo for finalizado você receberá um email de confirmação e poderá voltar a cadastrar projetos." -> CRIAR COMO ALERTA ACIMA DA MENSAGEM DE SUCESSO DA CRIAÇÃO E CASO O ATUAL USER SEJA O RESPONSÁVEL DA CÓPIA FINAL
- Qualquer usuário pode cadastrar Função (pendente aprovação)
- Na reserva "Equipamento(s)" para "Equipamento(s)" disponíveis.
- Na reserva -> Mensagem de sucesso fala "para editar ou excluir sua reserva, clique nela pelo calendário ou através do link".
- Mudar mensagem de não-confirmação: Seus dados ainda não foram confirmados. Até lá, você não poderá realizar ações no sistema. Edite o seu perfil com nome, matrícula e telefone corretos e você receberá um email assim que seu cadastro for confirmado. Caso você não receba esse email, entre em contato com o departamento.
-Sumir com TODAS as views para os não confirmados!
- Cadastre seus projetos, reserve equipamentos no almoxarifado e muito mais pelo seu celular, tablet ou qualquer outro dispositivo com acesso à internet. Site de uso exclusivo para alunos, funcionários e professores do Departamento de Cinema e Vídeo da UFF.
- Criar home pública com o mesmo texto do login mas sem o formulário: "Cadastre seus projetos, reserve equipamentos no almoxarifado e muito mais pelo seu celular, tablet ou qualquer outro dispositivo com acesso à internet. Se você é aluno, funcionário ou professor do Departamento de Cinema e Vídeo da UFF, acesse o sistema.
- Colocar alerta no topo do site de "Clique em "Acessar o Sistema" no menu para ir ao sistema".
- Tirar tudo do Almoxarifado, tirar tudo do Perguntas Frequentes e Espaço Discente fica só "Documentos de Produção".
- Checar permissões de login do site e retirar login completamente do site.

## Cópias Finais
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
