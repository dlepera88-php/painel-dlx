<?php
/**
 * painel-dlx
 * @version: v1.17.08
 * @author: Diego Lepera
 *
 * Created by Diego Lepera on 2017-07-28. Please report any bug at
 * https://github.com/dlepera88-php/framework-dlx/issues
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Diego Lepera http://diegolepera.xyz/
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Comum\DAO;

trait GrupoUsuario {
    /**
     * Nome do idioma
     * @var string
     */
    protected $nome;

    /**
     * Define se esse é o grupo que os usuário são incluídos como padrão
     * @var boolean
     */
    protected $padrao = false;

    /**
     * Define se esse grupo de usuário receberá permissão automaticamente ao
     * criar um novo permissionamento
     * @var boolean
     */
    protected $autoperm = false;

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = filter_var($nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    public function isPadrao() {
        return (bool)$this->padrao;
    }

    public function setPadrao($padrao) {
        $this->padrao = filter_var($padrao, FILTER_VALIDATE_BOOLEAN);
    }

    public function isAutoperm() {
        return (bool)$this->autoperm;
    }

    public function setAutoperm($autoperm) {
        $this->autoperm = filter_var($autoperm, FILTER_VALIDATE_BOOLEAN);
    }
}
