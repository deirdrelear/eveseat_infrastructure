<?php

namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Carbon\Carbon;
use Deirdrelear\Seat\Infrastructure\Service;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureAllianceController extends Controller
{
    public function ihubs()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);
        $ihubs = Service::getIHubsInSpace($allianceCorporationsIds);

        return view('infrastructure::alliance_ihubs', ['ihubs' => $ihubs]);
    }

    public function navstructures()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);
        $navigationStructures = Service::getNavigationStructuresInSpace($allianceCorporationsIds);

        return view('infrastructure::alliance_navstructures', [
            'navigationStructures' => $navigationStructures,
        ]);
    }

    public function dockstructures()
    {
        $userCorporationsIds = Service::getUserCorporationsIds();
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);
        $dockingStructures = Service::getDockingStructuresInSpace($allianceCorporationsIds);

        return view('infrastructure::alliance_dockstructures', [
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
        $allianceCorporationsIds = Service::getAllianceCorporationsIds($userCorporationsIds);
        $miningStructures = Service::getMetenoxStructuresInSpace($allianceCorporationsIds, $targetDate);

        return view('infrastructure::alliance_miningstructures', [
            'miningStructures' => $miningStructures,
            'targetDate' => $targetDate,
        ]);
    }
}
