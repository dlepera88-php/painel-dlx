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

namespace PainelDLX\Application\CadastroUsuarios\Handlers;


use PainelDLX\Application\CadastroUsuarios\Commands\AlterarSenhaUsuarioCommand;
use PainelDLX\Domain\CadastroUsuarios\Repositories\UsuarioRepositoryInterface;
use PainelDLX\Domain\CadastroUsuarios\Services\VerificaSenhasIguais;

class AlterarSenhaUsuarioHandler
{
    /** @var UsuarioRepositoryInterface */
    private $usuario_repository;

    /**
     * AlterarSenhaUsuarioHandler constructor.
     * @param UsuarioRepositoryInterface $usuario_repository
     */
    public function __construct(UsuarioRepositoryInterface $usuario_repository)
    {
        $this->usuario_repository = $usuario_repository;
    }

    /**
     * @param AlterarSenhaUsuarioCommand $command
     * @throws \Exception
     */
    public function handle(AlterarSenhaUsuarioCommand $command)
    {
        try {
            $usuario = $command->getUsuario();
            $senha = $command->getSenhaUsuario();

            // Verificar se as senhas coincidem
            (new VerificaSenhasIguais($usuario, $senha))->executar();

            $usuario->setSenha($senha->getSenhaInformada());
            $this->usuario_repository->update($usuario);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}