<?php

namespace App\Http\Controllers;

use App\Models\EconomicGroup;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EconomicGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém os grupos econômicos com paginação de 10 itens por vez
        $economicGroups = EconomicGroup::paginate(10);

        // Retorna a view com os dados dos grupos econômicos
        return view('economic-groups.index', ['economicGroups' => $economicGroups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('economic-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados com mensagens personalizadas
        $request->validate([
            'name' => 'required|string|max:255|unique:economic_groups,name',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'name.unique' => 'Já existe um grupo econômico com esse nome.',
        ]);

        // Criação do novo grupo
        EconomicGroup::create($request->all());

        return redirect()->route('economic-groups.index')
            ->with('success', 'Grupo econômico criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $economicGroup = EconomicGroup::findOrFail($id);
            return view('economic-groups.show', compact('economicGroup'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('economic-groups.index')->with('error', 'Grupo econômico não encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $economicGroup = EconomicGroup::findOrFail($id);
            return view('economic-groups.edit', compact('economicGroup'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('economic-groups.index')->with('error', 'Grupo econômico não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EconomicGroup $economicGroup)
    {
        // Validação dos dados com mensagens personalizadas
        $request->validate([
            'name' => 'required|string|max:255|unique:economic_groups,name,' . $economicGroup->id,
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'name.unique' => 'Já existe um grupo econômico com esse nome.',
        ]);

        // Atualização do grupo econômico
        $economicGroup->update($request->all());

        return redirect()->route('economic-groups.index')
            ->with('success', 'Grupo econômico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EconomicGroup $economicGroup)
    {
        $economicGroup->delete();

        return redirect()->route('economic-groups.index')->with('success', 'Grupo econômico deletado com sucesso.');
    }
}
