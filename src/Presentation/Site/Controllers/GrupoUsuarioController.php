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

namespace PainelDLX\Presentation\Site\Controllers;


use DLX\Core\Exceptions\UserException;
use League\Tactician\CommandBus;
use PainelDLX\Application\CadastroUsuarios\Commands\NovoGrupoUsuarioCommand;
use PainelDLX\Application\CadastroUsuarios\Commands\ExcluirGrupoUsuarioCommand;
use PainelDLX\Application\CadastroUsuarios\Commands\EditarGrupoUsuarioCommand;
use PainelDLX\Domain\CadastroUsuarios\Entities\GrupoUsuario;
use PainelDLX\Domain\CadastroUsuarios\Repositories\GrupoUsuarioRepositoryInterface;
use PainelDLX\Infra\ORM\Doctrine\Repositories\GrupoUsuarioRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Vilex\VileX;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GrupoUsuarioController
 * @package PainelDLX\Presentation\Site\Controllers
 * @property GrupoUsuarioRepository $repository
 */
class GrupoUsuarioController extends SiteController
{
    /**
     * GrupoUsuarioController constructor.
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(
        VileX $view,
        CommandBus $command_bus,
        GrupoUsuarioRepositoryInterface $grupo_usuario_repository
    ) {
        parent::__construct($view, $command_bus);

        $this->view->setPaginaMestra('src/Presentation/Site/Views/painel-dlx-master.phtml');
        $this->view->setViewRoot('src/Presentation/Site/Views');

        $this->repository = $grupo_usuario_repository;
    }

    /**
     * Mostrar a lista com os usuários
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     * @throws \Exception
     */
    public function listaGruposUsuarios(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $lista_grupos_usuarios = $this->repository->findAtivos($request->getParsedBody());

            // Atributos
            $this->view->setAtributo('titulo-pagina', 'Grupos de Usuários');
            $this->view->setAtributo('lista_grupos_usuarios', $lista_grupos_usuarios);

            // Views
            $this->view->addTemplate('lista_grupos_usuarios');
        } catch (UserException $e) {
            $this->view->addTemplate('mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * @return ResponseInterface
     * @throws \Exception
     */
    public function formNovoGrupoUsuario(): ResponseInterface
    {
        try {
            // Atributos
            $this->view->setAtributo('titulo-pagina', 'Adicionar novo grupo de usuário');

            // Views
            $this->view->addTemplate('form_novo_grupo_usuario');
        } catch (UserException $e) {
            $this->view->addTemplate('mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * Cadastrar um novo usuário.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     */
    public function cadastrarNovoGrupoUsuario(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var string $nome
         */
        extract($request->getParsedBody());

        try {
            /** @var GrupoUsuario $grupo_usuario */
            $grupo_usuario = $this->commandBus->handle(new NovoGrupoUsuarioCommand($nome));

            $msg['retorno'] = 'sucesso';
            $msg['mensagem'] = 'Grupo de usuário cadastrado com sucesso!';
            $msg['grupo_usuario'] = $grupo_usuario->getGrupoUsuarioId();
        } catch (\Exception $e) {
            $msg['retorno'] = 'erro';
            $msg['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($msg);
    }

    /**
     * Mostrar o formulário para alterar as informações de um grupo de usuário
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     * @throws \Exception
     */
    public function formAlterarGrupoUsuario(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var int $grupo_usuario_id
         */
        extract($request->getQueryParams());

        try {
            /** @var GrupoUsuario $grupo_usuario */
            $grupo_usuario = $this->repository->find($grupo_usuario_id);

            // Atributos
            $this->view->setAtributo('titulo-pagina', 'Atualizar informações do grupo de usuário');
            $this->view->setAtributo('grupo_usuario', $grupo_usuario);

            // Views
            $this->view->addTemplate('form_alterar_grupo_usuario');
        } catch (UserException $e) {
            $this->view->addTemplate('mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * Alterar as informações de um grupo de usuário
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function atualizarGrupoUsuarioExistente(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var int $grupo_usuario_id
         * @var string $nome
         */
        extract($request->getParsedBody());

        try {
            /** @var GrupoUsuario $grupo_usuario_atualizado */
            $grupo_usuario_atualizado = $this->commandBus->handle(
                new EditarGrupoUsuarioCommand($grupo_usuario_id, $nome)
            );

            $msg['retorno'] = 'sucesso';
            $msg['mensagem'] = 'Grupo de usuário atualizado com sucesso!';
            $msg['grupo_usuario'] = $grupo_usuario_atualizado->getGrupoUsuarioId();
        } catch (\Exception $e) {
            $msg['retorno'] = 'erro';
            $msg['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($msg);
    }

    /**
     * Excluir um determinado grupo de usuário.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function excluirGrupoUsuario(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var int $grupo_usuario_id
         */
        extract($request->getParsedBody());

        try {
            $this->commandBus->handle(new ExcluirGrupoUsuarioCommand($grupo_usuario_id));

            $msg['retorno'] = 'sucesso';
            $msg['mensagem'] = 'Grupo de usuário excluído com sucesso!';
        } catch (\Exception $e) {
            $msg['retorno'] = 'erro';
            $msg['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($msg);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Vilex\Exceptions\ContextoInvalidoException
     * @throws \Vilex\Exceptions\PaginaMestraNaoEncontradaException
     * @throws \Vilex\Exceptions\ViewNaoEncontradaException
     */
    public function detalheGrupoUsuario(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var int $grupo_usuario_id
         */
        extract($request->getQueryParams());

        try {
            /** @var GrupoUsuario $usuario */
            $grupo_usuario = $this->repository->find($grupo_usuario_id);

            // Atributos
            $this->view->setAtributo('titulo-pagina', $grupo_usuario->getNome());
            $this->view->setAtributo('grupo-usuario', $grupo_usuario);

            // Views
            $this->view->addTemplate('det_grupo_usuario');
        } catch (UserException $e) {
            $this->view->addTemplate('mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }
}