<?php

namespace Deirdrelear\Seat\Infrastructure\Http\Controllers;

use Carbon\Carbon;
use Deirdrelear\Seat\Infrastructure\Service;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;

class InfrastructureGlobalController extends Controller
{
    public function ihubs()
    {
        return view('infrastructure::global_ihubs', [
            'ihubs' => Service::getIHubsInSpace(),
        ]);
    }

    public function navstructures()
    {
        return view('infrastructure::global_navstructures', [
            'navigationStructures' => Service::getNavigationStructuresInSpace(),
        ]);
    }

    public function dockstructures()
    {
        return view('infrastructure::global_dockstructures', [
            'dockingStructures' => Service::getDockingStructuresInSpace(),
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

        return view('infrastructure::global_miningstructures', [
            'miningStructures' => Service::getMetenoxStructuresInSpace([], $targetDate),
            'targetDate' => $targetDate,
        ]);
    }
}
