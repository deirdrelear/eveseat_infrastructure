<?php

namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Carbon\Carbon;
use Deirdrelear\Seat\Infrastructure\Service;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureCorporationController extends Controller
{
    public function ihubs()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $ihubs = Service::getIHubsInSpace($userCorporationsIds);

        $corporationNames = [];
        foreach ($ihubs as $ihub) {
            if ($ihub->corporation) {
                $corporationNames[$ihub->corporation->corporation_id] = $ihub->corporation->name;
            }
        }

        return view('infrastructure::corporation_ihubs', [
            'corporationNames' => array_unique($corporationNames),
            'ihubs' => $ihubs,
        ]);
    }

    public function navstructures()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $navigationStructures = Service::getNavigationStructuresInSpace($userCorporationsIds);

        $corporationNames = [];
        foreach ($navigationStructures as $navigationStructure) {
            if ($navigationStructure->corporation) {
                $corporationNames[$navigationStructure->corporation->corporation_id] = $navigationStructure->corporation->name;
            }
        }

        return view('infrastructure::corporation_navstructures', [
            'corporationNames' => array_unique($corporationNames),
            'navigationStructures' => $navigationStructures,
        ]);
    }

    public function dockstructures()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $dockingStructures = Service::getDockingStructuresInSpace($userCorporationsIds);

        $corporationNames = [];
        foreach ($dockingStructures as $dockingStructure) {
            if ($dockingStructure->corporation) {
                $corporationNames[$dockingStructure->corporation->corporation_id] = $dockingStructure->corporation->name;
            }
        }

        return view('infrastructure::corporation_dockstructures', [
            'corporationNames' => array_unique($corporationNames),
            'dockingStructures' => $dockingStructures,
        ]);
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
        $miningStructures = Service::getMetenoxStructuresInSpace($userCorporationsIds, $targetDate);

        return view('infrastructure::corporation_miningstructures', [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate,
        ]);
    }
}
