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

namespace PainelDLX\UseCases\GruposUsuarios\NovoGrupoUsuario;


use Exception;
use PainelDLX\Domain\GruposUsuarios\Entities\GrupoUsuario;
use PainelDLX\Domain\GruposUsuarios\Repositories\GrupoUsuarioRepositoryInterface;
use PainelDLX\Domain\GruposUsuarios\Validators\AliasUtilizadoValidator;

class NovoGrupoUsuarioCommandHandler
{
    /**
     * @var GrupoUsuarioRepositoryInterface
     */
    private $grupo_usuario_repository;
    /**
     * @var AliasUtilizadoValidator
     */
    private $validator;

    /**
     * NovoUsuarioCommandHandler constructor.
     * @param GrupoUsuarioRepositoryInterface $grupo_usuario_repository
     * @param AliasUtilizadoValidator $validator
     */
    public function __construct(
        GrupoUsuarioRepositoryInterface $grupo_usuario_repository,
        AliasUtilizadoValidator $validator
    ) {
        $this->grupo_usuario_repository = $grupo_usuario_repository;
        $this->validator = $validator;
    }

    /**
     * @param NovoGrupoUsuarioCommand $command
     * @return GrupoUsuario
     * @throws Exception
     */
    public function handle(NovoGrupoUsuarioCommand $command)
    {
        $grupo_usuario = GrupoUsuario::create($command->getNome());

        // Verificar se o alias gerado não está sendo utilizado
        $this->validator->validar($grupo_usuario);

        $this->grupo_usuario_repository->create($grupo_usuario);

        return $grupo_usuario;
    }
}