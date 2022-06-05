<?php


namespace Brutusv\Seat\infrastructure\Http\Controllers;

use Brutusv\Seat\infrastructure\Service;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureAllianceController extends Controller
{
    public function ihubs() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // получаем список ihub'ов нужных корпораций
        $ihubs = Service::getIHubsInSpace($userCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_ihubs", ['ihubs' => $ihubs]);
    }

    public function navstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем список навигационных структур нужных корпораций
        $navigationStructures = Service::getNavigationStructuresInSpace($userCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_navstructures", ['navigationStructures' => $navigationStructures]);
    }

    public function dockstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем список структур с доком для заданных корпораций
        $dockingStructures = Service::getDockingStructuresInSpace($userCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_dockstructures", ['dockingStructures' => $dockingStructures]);
    }

    public function about() {
        return view("infrastructure::about");
    }
}