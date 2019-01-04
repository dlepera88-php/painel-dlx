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

namespace PainelDLX\Domain\CadastroUsuarios\Repositories;


use DLX\Domain\Repositories\EntityRepositoryInterface;
use PainelDLX\Domain\CadastroUsuarios\Entities\Usuario;

interface UsuarioRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Verificar se há outro usuário com o mesmo email da entidade informada.
     * @param Usuario $usuario
     * @return bool
     */
    public function hasOutroUsuarioComMesmoEmail(Usuario $usuario): bool;

    /**
     * Fazer login
     * @param string $email
     * @param string $senha
     * @return Usuario|null
     */
    public function fazerLogin(string $email, string $senha): ?Usuario;
}