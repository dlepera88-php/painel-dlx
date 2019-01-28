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

namespace PainelDLX\Testes\Application\UseCases\Usuarios\UtilizarResetSenha;

use DLX\Infra\EntityManagerX;
use PainelDLX\Application\UseCases\Usuarios\UtilizarResetSenha\UtilizarResetSenhaCommand;
use PainelDLX\Application\UseCases\Usuarios\UtilizarResetSenha\UtilizarResetSenhaHandler;
use PainelDLX\Domain\Usuarios\Entities\ResetSenha;
use PainelDLX\Domain\Usuarios\Repositories\ResetSenhaRepositoryInterface;
use PainelDLX\Testes\Application\UseCases\Usuarios\SolicitarResetSenha\SolicitarResetSenhaHandlerTest;
use PainelDLX\Testes\PainelDLXTests;

class UtilizarResetSenhaHandlerTest extends PainelDLXTests
{
    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \PainelDLX\Domain\Usuarios\Exceptions\UsuarioNaoEncontrado
     */
    public function test_Handle()
    {
        $reset_senha = (new SolicitarResetSenhaHandlerTest())->test_Handle();
        $this->assertFalse($reset_senha->isUtilizado());

        /** @var ResetSenhaRepositoryInterface $reset_senha_repository */
        $reset_senha_repository = EntityManagerX::getRepository(ResetSenha::class);

        $command = new UtilizarResetSenhaCommand($reset_senha);
        $reset_senha = (new UtilizarResetSenhaHandler($reset_senha_repository))->handle($command);

        $this->assertTrue($reset_senha->isUtilizado());
    }
}