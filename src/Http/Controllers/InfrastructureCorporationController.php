<?php


namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Deirdrelear\Seat\Infrastructure\Service;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureCorporationController extends Controller
{
    public function ihubs() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // получаем список ihub'ов нужных корпораций
        $ihubs = Service::getIHubsInSpace($userCorporationsIds);

        // Получаем список корпораций для разделов
        $corporationNames = [];
        foreach ($ihubs as $ihub) {
            $corporationNames[$ihub->corporation->corporation_id] = $ihub->corporation->name;
        }

        // оставляем только уникальные элементы корпораций
        $corporationNames = array_unique($corporationNames);

        // выводим шаблон
        return view("infrastructure::corporation_ihubs", ['corporationNames' => $corporationNames,'ihubs' => $ihubs]);
    }

    public function navstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем список навигационных структур нужных корпораций
        $navigationStructures = Service::getNavigationStructuresInSpace($userCorporationsIds);

        // Получаем список корпораций для разделов
        $corporationNames = [];
        foreach ($navigationStructures as $navigationStructure) {
            $corporationNames[$navigationStructure->corporation->corporation_id] = $navigationStructure->corporation->name;
        }

        // оставляем только уникальные элементы корпораций
        $corporationNames = array_unique($corporationNames);

        // выводим шаблон
        return view("infrastructure::corporation_navstructures", ['corporationNames' => $corporationNames,'navigationStructures' => $navigationStructures]);
    }

    public function dockstructures() {
        // Получаем идентификаторы корпораций, в которых состоят альты пользователя
        $userCorporationsIds = Service::getUserCorporationsIds();

        // Получаем список структур с доком для заданных корпораций
        $dockingStructures = Service::getDockingStructuresInSpace($userCorporationsIds);

        // Получаем список корпораций для разделов
        $corporationNames = [];
        foreach ($dockingStructures as $dockingStructure) {
            $corporationNames[$dockingStructure->corporation->corporation_id] = $dockingStructure->corporation->name;
        }

        // оставляем только уникальные элементы корпораций
        $corporationNames = array_unique($corporationNames);

        // выводим шаблон
        return view("infrastructure::corporation_dockstructures", ['corporationNames' => $corporationNames,'dockingStructures' => $dockingStructures]);
    }

    public function miningstructures(Request $request) {
        $validated = $request->validate([
            'target_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $targetDate = isset($validated['target_date'])
            ? Carbon::createFromFormat('Y-m-d', $validated['target_date'])->startOfDay()
            : now()->addMonth()->startOfDay();

        $userCorporationsIds = Service::getUserCorporationsIds();
        $miningStructures = Service::getMetenoxStructuresInSpace($userCorporationsIds, $targetDate);

        return view("infrastructure::corporation_miningstructures", [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate,
        ]);

}
