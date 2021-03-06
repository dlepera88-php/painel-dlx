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

namespace PainelDLX\Application\Adapters\Router\League;


use League\Route\Router;
use PainelDLX\Application\Contracts\Router\RotaInterface;
use PainelDLX\Application\Contracts\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LeagueRouterAdapter implements RouterInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * LeagueRouterAdapter constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Adicionar rotas do tipo GET
     * @param string $path
     * @param $handler
     * @return RotaInterface
     */
    public function get(string $path, $handler): RotaInterface
    {
        return new LeagueRouteAdapter(
            $this->router->get($path, $handler)
        );
    }

    /**
     * Adicionar rotas do tipo POST
     * @param string $path
     * @param $handler
     * @return RotaInterface
     */
    public function post(string $path, $handler): RotaInterface
    {
        return new LeagueRouteAdapter(
            $this->router->post($path, $handler)
        );
    }

    /**
     * Adicionar rotas do tipo PUT
     * @param string $path
     * @param $handler
     * @return RotaInterface
     */
    public function put(string $path, $handler): RotaInterface
    {
        return new LeagueRouteAdapter(
            $this->router->put($path, $handler)
        );
    }

    /**
     * Adicionar rotas do tipo DELETE
     * @param string $path
     * @param $handler
     * @return RotaInterface
     */
    public function delete(string $path, $handler): RotaInterface
    {
        return new LeagueRouteAdapter(
            $this->router->delete($path, $handler)
        );
    }

    /**
     * Identificar e executar determinada rota
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        return $this->router->dispatch($request);
    }
}