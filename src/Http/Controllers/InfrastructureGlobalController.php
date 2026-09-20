<?php


namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Deirdrelear\Seat\Infrastructure\Service;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureGlobalController extends Controller
{
    public function ihubs() {
        // получаем список ihub'ов всех корпораций
        $ihubs = Service::getIHubsInSpace();

        // выводим шаблон
        return view("infrastructure::global_ihubs", ['ihubs' => $ihubs]);
    }

    public function navstructures() {
        // Получаем список навигационных структур всех корпораций
        $navigationStructures = Service::getNavigationStructuresInSpace();

        // выводим шаблон
        return view("infrastructure::global_navstructures", ['navigationStructures' => $navigationStructures]);
    }

    public function dockstructures() {
        // Получаем список всех структур с доком
        $dockingStructures = Service::getDockingStructuresInSpace();

        // выводим шаблон
        return view("infrastructure::global_dockstructures", ['dockingStructures' => $dockingStructures]);
    }

    public function miningstructures(Request $request) {
        $validated = $request->validate([
            'target_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $targetDate = isset($validated['target_date'])
            ? Carbon::createFromFormat('Y-m-d', $validated['target_date'])->startOfDay()
            : now()->addMonth()->startOfDay();

        $miningStructures = Service::getMetenoxStructuresInSpace([], $targetDate);

        return view("infrastructure::global_miningstructures", [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate,
        ]);


}
