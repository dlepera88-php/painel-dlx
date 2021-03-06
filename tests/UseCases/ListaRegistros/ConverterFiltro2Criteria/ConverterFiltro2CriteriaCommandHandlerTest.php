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

namespace PainelDLX\Testes\Application\UseCases\ListaRegistros\ConverterFiltro2Criteria;

use PainelDLX\Tests\TestCase\PainelDLXTestCase;
use PainelDLX\UseCases\ListaRegistros\ConverterFiltro2Criteria\ConverterFiltro2CriteriaCommand;
use PainelDLX\UseCases\ListaRegistros\ConverterFiltro2Criteria\ConverterFiltro2CriteriaCommandHandler;

/**
 * Class ConverterFiltro2CriteriaCommandHandlerTest
 * @package PainelDLX\Testes\Application\UseCases\ListaRegistros\ConverterFiltro2Criteria
 * @coversDefaultClass \PainelDLX\UseCases\ListaRegistros\ConverterFiltro2Criteria\ConverterFiltro2CriteriaCommandHandler
 */
class ConverterFiltro2CriteriaCommandHandlerTest extends PainelDLXTestCase
{
    /**
     * @covers ::handle
     */
    public function test_Handle_deve_configurar_request_como_criteria()
    {
        $campos = ['campo1', 'campo2'];
        $busca = 'busca';

        $command = new ConverterFiltro2CriteriaCommand($campos, $busca);
        $criteria = (new ConverterFiltro2CriteriaCommandHandler())->handle($command);

        foreach ($campos as $campo) {
            $this->assertArrayHasKey($campo, $criteria);
            $this->assertEquals($busca, $criteria[$campo]);
        }
    }

    /**
     * O PHP lança uma warning quando tenta executar o foreach num valor NULL. Quando o filtro não é informado a chave
     * 'campos' do filtro não é informada.
     * @covers ::handle
     */
    public function test_Handle_nao_deve_lancar_warning_nem_erro_quando_nao_informar_campos()
    {
        $campos = null;
        $busca = null;

        $command = new ConverterFiltro2CriteriaCommand($campos, $busca);
        (new ConverterFiltro2CriteriaCommandHandler())->handle($command);

        $this->expectNotToPerformAssertions();
    }
}
