<?php
/**
 * Created by PhpStorm.
 * User: diegolepera
 * Date: 07/02/2019
 * Time: 12:17
 */

namespace PainelDLX\UseCases\Modulos\GetListaMenu;


use PainelDLX\Domain\Modulos\Repositories\MenuRepositoryInterface;
use PainelDLX\UseCases\Modulos\GetListaMenu\GetListaMenuCommand;

class GetListaMenuCommandHandler
{
    /**
     * @var MenuRepositoryInterface
     */
    private $menu_repository;

    /**
     * GetListaMenuCommandHandler constructor.
     * @param MenuRepositoryInterface $menu_repository
     */
    public function __construct(MenuRepositoryInterface $menu_repository)
    {
        $this->menu_repository = $menu_repository;
    }

    /**
     * @param GetListaMenuCommand $command
     * @return array
     */
    public function handle(GetListaMenuCommand $command): array
    {
        return $this->menu_repository->getListaMenu($command->getUsuario());
    }
}