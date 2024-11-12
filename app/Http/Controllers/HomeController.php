<?php

namespace App\Http\Controllers;

use App\Models\EconomicGroup;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Employee;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total de registros
        $totalEconomicGroups = EconomicGroup::count();
        $totalBrands = Brand::count();
        $totalUnits = Unit::count();
        $totalEmployees = Employee::count();

        // Crescimento no mês (compara o número de registros deste mês com o mês anterior)
        $economicGroupsLastMonth = EconomicGroup::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        $economicGroupsThisMonth = EconomicGroup::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();
        $growthEconomicGroups = $economicGroupsThisMonth - $economicGroupsLastMonth;

        $brandsLastMonth = Brand::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        $brandsThisMonth = Brand::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();
        $growthBrands = $brandsThisMonth - $brandsLastMonth;

        $unitsLastMonth = Unit::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        $unitsThisMonth = Unit::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();
        $growthUnits = $unitsThisMonth - $unitsLastMonth;

        $employeesLastMonth = Employee::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        $employeesThisMonth = Employee::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();
        $growthEmployees = $employeesThisMonth - $employeesLastMonth;

        // Passa os dados para a view
        return view('home', compact(
            'totalEconomicGroups', 'totalBrands', 'totalUnits', 'totalEmployees',
            'growthEconomicGroups', 'growthBrands', 'growthUnits', 'growthEmployees'
        ));
    }
}
