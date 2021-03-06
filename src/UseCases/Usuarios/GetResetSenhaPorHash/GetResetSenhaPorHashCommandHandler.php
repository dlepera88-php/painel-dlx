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

namespace PainelDLX\UseCases\Usuarios\GetResetSenhaPorHash;


use PainelDLX\Domain\Usuarios\Entities\ResetSenha;
use PainelDLX\Domain\Usuarios\Exceptions\ResetSenhaNaoEncontradoException;
use PainelDLX\Domain\Usuarios\Repositories\ResetSenhaRepositoryInterface;
use PainelDLX\UseCases\Usuarios\GetResetSenhaPorHash\GetResetSenhaPorHashCommand;

/**
 * Class GetResetSenhaPorHashCommandHandler
 * @package PainelDLX\UseCases\Usuarios\GetResetSenhaPorHash
 * @covers GetResetSenhaPorHashCommandHandlerTest
 */
class GetResetSenhaPorHashCommandHandler
{
    /**
     * @var ResetSenhaRepositoryInterface
     */
    private $reset_senha_repository;

    /**
     * GetResetSenhaPorHashCommandHandler constructor.
     * @param ResetSenhaRepositoryInterface $reset_senha_repository
     */
    public function __construct(ResetSenhaRepositoryInterface $reset_senha_repository)
    {
        $this->reset_senha_repository = $reset_senha_repository;
    }

    /**
     * @param GetResetSenhaPorHashCommand $command
     * @return ResetSenha|null
     * @throws ResetSenhaNaoEncontradoException
     */
    public function handle(GetResetSenhaPorHashCommand $command): ?ResetSenha
    {
        $hash = $command->getHash();

        $reset_senha = $this->reset_senha_repository->findResetSenhaAtivoPorHash($hash);

        if (is_null($reset_senha)) {
            throw ResetSenhaNaoEncontradoException::porHash($hash);
        }

        return $reset_senha;
    }
}