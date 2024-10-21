<?php


namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Deirdrelear\Seat\Infrastructure\Service;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InfrastructureAllianceController extends Controller
{
    public function ihubs() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем идентификаторы альянсов, в которых состоят альты пользователя
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);

        // получаем список ihub'ов нужных альянсов
        $ihubs = Service::getIHubsInSpace($allianceCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_ihubs", ['ihubs' => $ihubs]);
    }

    public function navstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем идентификаторы альянсов, в которых состоят альты пользователя
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);

        // Получаем список навигационных структур нужных альянсов
        $navigationStructures = Service::getNavigationStructuresInSpace($allianceCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_navstructures", ['navigationStructures' => $navigationStructures]);
    }

    public function dockstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем идентификаторы альянсов, в которых состоят альты пользователя
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);

        // Получаем список структур с доком для заданных альянсов
        $dockingStructures = Service::getDockingStructuresInSpace($allianceCorporationsIds);

        // выводим шаблон
        return view("infrastructure::alliance_dockstructures", ['dockingStructures' => $dockingStructures]);
    }

    public function miningstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем идентификаторы альянсов, в которых состоят альты пользователя
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);

        // Получаем список метеноксов для заданных альянсов
        $miningStructures = Service::getMetenoxStructuresInSpace($allianceCorporationsIds);

        $targetDate = $request->input('target_date') ? Carbon::parse($request->input('target_date')) : now()->addMonth();

        foreach ($miningStructures as $miningStructure) {
            $miningStructure->shutdown_date = Service::calculateShutdownDate($miningStructure);
            $miningStructure->required_fuel = Service::calculateRequiredFuel($miningStructure, $targetDate);
        }
    
        return view("infrastructure::alliance_miningstructures", [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate
        ]);
    }

}
