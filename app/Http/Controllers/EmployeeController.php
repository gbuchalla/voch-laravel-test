<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\EconomicGroup;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        // Carregar os colaboradores com base nos filtros
        $employees = Employee::query();

        if ($request->filled('name')) {
            $employees->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('cpf')) {
            $employees->where('cpf', 'like', '%' . $request->cpf . '%');
        }

        if ($request->filled('email')) {
            $employees->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('unit')) {
            $employees->whereHas('unit', function ($query) use ($request) {
                $query->where('fantasy_name', 'like', '%' . $request->unit . '%');
            });
        }

        if ($request->filled('brand')) {
            $employees->whereHas('unit.brand', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->brand . '%');
            });
        }

        if ($request->filled('economic_group')) {
            $employees->whereHas('unit.brand.economicGroup', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->economic_group . '%');
            });
        }

        // Paginando os resultados
        $employees = $employees->paginate(10);

        // Buscar todos os grupos econômicos para o input por select
        $economicGroups = EconomicGroup::orderBy('name')->get();

        // Retornar a view com os dados
        return view('employees.index', compact('employees', 'economicGroups'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:48',
            'email' => 'required|string|email|max:48|unique:employees,email',
            'cpf' => 'required|string|size:11|unique:employees,cpf,|regex:/^[0-9]+$/',
            'unit' => 'required|string|exists:units,fantasy_name'

        ], [
            'unit.exists' => 'A unidade informada não existe.',
            'email.unique' => 'Já existe um colaborador com esse email.',
            'cpf.unique' => 'Já existe um colaborador com esse cpf.'
        ]);

        // Encontra as instância de Unit
        $unit = Unit::where('fantasy_name', $request->unit)->first();

        // Criação do novo colaborador
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'unit_id' => $unit->id
        ]);

        return redirect()->route('employees.index')->with('success', 'Colaborador criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return view('employees.show', compact('employee'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('employees.index')->with('error', 'Colaborador não encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $economicGroups = EconomicGroup::orderBy('name')->get();
            return view('employees.edit', compact('employee', 'economicGroups'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('employees.index')->with('error', 'Colaborador não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:48',
            'email' => 'required|string|email|max:48|unique:employees,email,' . $id,
            'cpf' => 'required|string|size:11|unique:employees,cpf,' . $id . '|regex:/^[0-9]+$/',
            'unit' => 'required|string|exists:units,fantasy_name'
        ], [
            'unit.exists' => 'A unidade informada não existe.',
            'email.unique' => 'Já existe um colaborador com esse email.',
            'cpf.unique' => 'Já existe um colaborador com esse cpf.'
        ]);

        // Encontra as instâncias de Unit
        $unit = Unit::where('fantasy_name', $request->unit)->first();

        // Atualiza o colaborador
        $employee = Employee::findOrFail($id);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'unit_id' => $unit->id,
        ]);
        
        return redirect()->route('employees.index')->with('success', 'Colaborador atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Colaborador deletado com sucesso.');
    }
}
