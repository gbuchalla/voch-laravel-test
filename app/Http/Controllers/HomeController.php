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
     * Exibe a página inicial com as estatísticas de registros.
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

        // Crescimento no mês
        $growthEconomicGroups = $this->getGrowth(EconomicGroup::class);
        $growthBrands = $this->getGrowth(Brand::class);
        $growthUnits = $this->getGrowth(Unit::class);
        $growthEmployees = $this->getGrowth(Employee::class);

        // Passa os dados para a view
        return view('home', compact(
            'totalEconomicGroups', 'totalBrands', 'totalUnits', 'totalEmployees',
            'growthEconomicGroups', 'growthBrands', 'growthUnits', 'growthEmployees'
        ));
    }

    /**
     * Calcula o crescimento de registros do mês atual em comparação com o mês anterior.
     *
     * @param  string  $model
     * @return int
     */
    private function getGrowth($model)
    {
        $lastMonthCount = $this->getCountForMonth($model, Carbon::now()->subMonth());
        $thisMonthCount = $this->getCountForMonth($model, Carbon::now());
        
        return $thisMonthCount - $lastMonthCount;
    }

    /**
     * Retorna o número de registros criados em um determinado mês.
     *
     * @param  string  $model
     * @param  \Carbon\Carbon  $date
     * @return int
     */
    private function getCountForMonth($model, Carbon $date)
    {
        return $model::whereBetween('created_at', [
            $date->startOfMonth(),
            $date->endOfMonth()
        ])->count();
    }
}
