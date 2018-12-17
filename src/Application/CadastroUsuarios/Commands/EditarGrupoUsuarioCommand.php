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

namespace PainelDLX\Application\CadastroUsuarios\Commands;

use DLX\Contracts\CommandInterface;

class EditarGrupoUsuarioCommand implements CommandInterface
{
    /** @var int */
    private $grupo_usuario_id;
    /** @var string */
    private $nome;

    /**
     * @return int
     */
    public function getGrupoUsuarioId(): int
    {
        return $this->grupo_usuario_id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * EditarUsuarioCommand constructor.
     * @param int $grupo_usuario_id
     * @param string $nome
     */
    public function __construct(int $grupo_usuario_id, string $nome)
    {
        $this->grupo_usuario_id = $grupo_usuario_id;
        $this->nome = $nome;
    }

    /**
     * Request completa do comando
     * @return array Retorna um array associativo. A chave é o nome da propriedade e o valor seu respectivo valor
     */
    public function getRequest(): array
    {
        return [
            'grupo_usuario_id' => $this->getGrupoUsuarioId(),
            'nome' => $this->getNome()
        ];
    }
}