function voltarPaginaLogin(){window.location=""}"function"!=typeof $.fn.formAjax&&console.error("O plugin $.fn.formAjax não foi carregado. Por favor, adicione o plugin antes de incluir o arquivo modulo-login.js"),$('[data-form-ajax="login"]').formAjax({func_depois:function(a){void 0!==a.tipo?"-sucesso"===a.tipo?window.location.reload():mostrarAlerta(a.mensagem,{tipo:a.tipo,tema:"painel-dlx"}):mostrarAlerta(a,{tema:"painel-dlx"})}}),$('[data-form-ajax="esqueci-minha-senha"]').formAjax({func_depois:function(a,o){if(void 0!==a.tipo){var e=[],t=$(o);switch(a.tipo){case"-sucesso":e=[{texto:"Reenviar o email",funcao:$.proxy(t.trigger,t,"submit")},{texto:"Voltar para a página de login",funcao:voltarPaginaLogin}];break;case"-erro":e=[{texto:"Tentar novamente"},{texto:"Voltar para a página de login",funcao:voltarPaginaLogin}];break}mostrarAlerta(a.mensagem,{tipo:a.tipo,tema:"painel-dlx",botoes:e})}else mostrarAlerta(a,{tema:"painel-dlx"})}}),$('[data-form-ajax="reset-senha"]').formAjax({func_depois:function(a){if(void 0!==a.tipo){var o=[];switch(a.tipo){case"-sucesso":o=[{texto:"Voltar para a página de login",funcao:voltarPaginaLogin}];break;case"-erro":o=[{texto:"Tentar novamente"}];break}mostrarAlerta(a.mensagem,{tipo:a.tipo,tema:"painel-dlx",botoes:o})}else mostrarAlerta(a,{tema:"painel-dlx"})}});