<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all');
        $search = trim((string) $request->query('search', ''));
        $radius = (int) $request->query('radius', 10);
        if (!in_array($radius, [5, 10, 25], true)) {
            $radius = 10;
        }

        $location = $request->query('location', 'Kebayoran Baru, Jakarta Selatan (Sesuai GPS)');
        $onlineOnly = $request->boolean('online', true);
        $highRating = $request->boolean('rating', false);
        $bnspOnly = $request->boolean('bnsp', false);
        $selectedCode = $request->query('selected');

        $allTechnicians = Technician::orderBy('distance_km')->get();

        $filteredTechs = $allTechnicians->filter(function (Technician $tech) use ($category, $search, $radius, $onlineOnly, $highRating, $bnspOnly) {
            if ($category !== 'all' && $category !== '') {
                $catNeedle = strtolower($category);
                $matched = collect($tech->skills_category)->contains(fn ($c) => str_contains(strtolower($c), $catNeedle))
                    || collect($tech->skills_tags)->contains(fn ($t) => str_contains(strtolower($t), $catNeedle));
                if (!$matched) {
                    return false;
                }
            }

            if ($search !== '') {
                $q = strtolower($search);
                $matchedSearch = str_contains(strtolower($tech->full_name), $q)
                    || collect($tech->skills_category)->contains(fn ($c) => str_contains(strtolower($c), $q))
                    || collect($tech->skills_tags)->contains(fn ($t) => str_contains(strtolower($t), $q));
                if (!$matchedSearch) {
                    return false;
                }
            }

            if ($tech->distance_km > $radius) {
                return false;
            }
            if ($onlineOnly && !$tech->is_online) {
                return false;
            }
            if ($highRating && $tech->rating_average < 4.8) {
                return false;
            }
            if ($bnspOnly && !str_contains(strtolower($tech->certification_level), 'bnsp')) {
                return false;
            }
            return true;
        })->values();
        $selectedTech = $selectedCode
            ? $allTechnicians->firstWhere('code', $selectedCode)
            : ($filteredTechs->first() ?? $allTechnicians->first());

        $services = ServiceCategory::orderBy('id')->get();
        $activeOrderCount = ServiceOrder::whereIn('status', ['ON_THE_WAY', 'ACTIVE', 'PENDING'])->count();

        return view('pages.technicians', compact(
            'filteredTechs',
            'allTechnicians',
            'selectedTech',
            'services',
            'category',
            'search',
            'radius',
            'location',
            'onlineOnly',
            'highRating',
            'bnspOnly',
            'activeOrderCount'
        ));
    }

    public function apiIndex(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Technician::orderBy('distance_km')->get(),
        ]);
    }

    public function apiShow(string $code): JsonResponse
    {
        $tech = Technician::where('code', $code)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $tech,
        ]);
    }
}