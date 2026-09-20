<?php


namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Deirdrelear\Seat\Infrastructure\Service;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
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

    public function miningstructures(Request $request)
    {
        $validated = $request->validate([
            'target_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $targetDate = isset($validated['target_date'])
            ? Carbon::createFromFormat('Y-m-d', $validated['target_date'])->startOfDay()
            : now()->addMonth()->startOfDay();

        $userCorporationsIds = Service::getUserCorporationsIds();
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);
        $miningStructures = Service::getMetenoxStructuresInSpace($allianceCorporationsIds, $targetDate);

        return view("infrastructure::alliance_miningstructures", [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate,
        ]);


}
