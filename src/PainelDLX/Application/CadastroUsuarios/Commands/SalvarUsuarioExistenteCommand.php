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

class SalvarUsuarioExistenteCommand implements CommandInterface
{
    /** @var int */
    private $usuario_id;
    /** @var string */
    private $nome;
    /** @var string */
    private $email;
    /** @var int[] */
    private $grupos = [];

    /**
     * @return int
     */
    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int[]
     */
    public function getGrupos(): array
    {
        return $this->grupos;
    }

    /**
     * SalvarUsuarioExistenteCommand constructor.
     * @param int $usuario_id
     * @param string $nome
     * @param string $email
     * @param array $grupos
     */
    public function __construct(int $usuario_id, string $nome, string $email, array $grupos)
    {
        $this->usuario_id = $usuario_id;
        $this->nome = $nome;
        $this->email = $email;
        $this->grupos = $grupos;
    }

    /**
     * Request completa do comando
     * @return array Retorna um array associativo. A chave é o nome da propriedade e o valor seu respectivo valor
     */
    public function getRequest(): array
    {
        return [
            'usuario_id' => $this->getUsuarioId(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'grupos' => $this->getGrupos()
        ];
    }
}