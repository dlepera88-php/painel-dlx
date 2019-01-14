<?php
/**
 * MIT License
 *
 * Copyright (c) 2018 PHP DLX
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace PainelDLX\Presentation\Site\Emails\Controllers;


use DLX\Core\Exceptions\UserException;
use League\Tactician\CommandBus;
use PainelDLX\Application\UseCases\Emails\ExcluirConfigSmtp\ExcluirConfigSmtpCommand;
use PainelDLX\Application\UseCases\Emails\ExcluirConfigSmtp\ExcluirConfigSmtpHandler;
use PainelDLX\Application\UseCases\Emails\GetConfigSmtpPorId\GetConfigSmtpPorIdCommand;
use PainelDLX\Application\UseCases\Emails\GetListaConfigSmtp\GetListaConfigSmtpCommand;
use PainelDLX\Domain\Emails\Entities\ConfigSmtp;
use PainelDLX\Presentation\Site\Controllers\SiteController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Vilex\VileX;
use Zend\Diactoros\Response\JsonResponse;

class ConfigSmtpController extends SiteController
{
    /**
     * ConfigSmtpController constructor.
     * @param VileX $view
     * @param CommandBus $commandBus
     */
    public function __construct(VileX $view, CommandBus $commandBus)
    {
        parent::__construct($view, $commandBus);

        $this->view->setPaginaMestra('src/Presentation/Site/public/views/painel-dlx-master.phtml');
        $this->view->setViewRoot('src/Presentation/Site/public/views/emails');
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\ContextoInvalidoException
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     * @throws \Vilex\Exceptions\ViewNaoEncontradaException
     */
    public function detalheConfigSmtp(ServerRequestInterface $request): ResponseInterface
    {
        $config_smtp_id = filter_var($request->getQueryParams()['config_smtp_id'], FILTER_VALIDATE_INT);

        try {
            /** @var ConfigSmtp $config_smtp */
            $config_smtp = $this->commandBus->handle(new GetConfigSmtpPorIdCommand($config_smtp_id));

            // View
            $this->view->addTemplate('det_config_smtp', [
                'titulo-pagina' => "Configuração SMTP: {$config_smtp->getNome()}",
                'config-smtp' => $config_smtp
            ]);
        } catch (UserException $e) {
            $this->view->addTemplate('../mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'texto' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\ContextoInvalidoException
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     * @throws \Vilex\Exceptions\ViewNaoEncontradaException
     */
    public function listaConfigSmtp(ServerRequestInterface $request): ResponseInterface
    {
        $param = $request->getQueryParams();
        unset($param['ambiente'], $param['task']);

        try {
            $lista_config_smtp = $this->commandBus->handle(new GetListaConfigSmtpCommand($param, []));

            // View
            $this->view->addTemplate('lista_config_smtp', [
                'titulo-pagina' => 'Configurações SMTP',
                'lista-config-smtp' => $lista_config_smtp
            ]);

            // JS
            $this->view->addArquivoJS('/vendor/dlepera88-jquery/jquery-form-ajax/jquery.formajax.plugin-min.js');
        } catch (UserException $e) {
            $this->view->addTemplate('../mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'texto' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function excluirConfigSmtp(ServerRequestInterface $request): ResponseInterface
    {
        $config_smtp_id = filter_var($request->getParsedBody()['config_smtp_id'], FILTER_VALIDATE_INT);

        try {
            /** @var ConfigSmtp $config_smtp */
            $config_smtp = $this->commandBus->handle(new GetConfigSmtpPorIdCommand($config_smtp_id));

            /** @covers ExcluirConfigSmtpHandler */
            $this->commandBus->handle(new ExcluirConfigSmtpCommand($config_smtp));

            $json['retorno'] = 'sucesso';
            $json['mensagem'] = 'Configuração SMTP excluída com sucesso!';
        } catch (UserException $e) {
            $json['retorno'] = 'erro';
            $json['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($json);
    }
}