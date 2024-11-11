<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\EconomicGroup;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carregar as bandeiras com a paginação
        $brands = Brand::with('economicGroup')->paginate(10);
        $economicGroups = EconomicGroup::orderBy('name')->get();

        // Retorna a view com as bandeiras e grupos econômicos
        return view('brands.index', compact('brands', 'economicGroups'));
    }



    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $economicGroups = EconomicGroup::orderBy('name')->get();
    //     die;
    //     return view('brands.create', compact('economicGroups'));
    // }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados com mensagens personalizadas
        $request->validate([
            'name' => 'required|string|max:48|unique:brands,name', // Verifica se o nome da marca é único
            'economic_group_id' => 'nullable|exists:economic_groups,id', // Verifica se o grupo econômico existe
        ], [
            'name.unique' => 'Já existe uma bandeira com esse nome. Escolha outro nome para a bandeira.',
            'economic_group_id.exists' => 'O grupo econômico selecionado não existe. Por favor, selecione um grupo econômico válido.',
        ]);

        // Criação da nova bandeira
        Brand::create([
            'name' => $request->name,
            'economic_group_id' => $request->economic_group_id,
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Bandeira criada com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Brand $brand)
    // {
    //     $economicGroups = EconomicGroup::all();
    //     return view('brands.edit', compact('brand', 'economicGroups'));
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:48|unique:brands,name,' . $brand->id, // Verifica se o nome da marca é único, excluindo a marca atual
            'economic_group_id' => 'nullable|exists:economic_groups,id', // Verifica se o grupo econômico existe
        ], [
            'name.unique' => 'Já existe uma bandeira com esse nome. Escolha outro nome para a bandeira.',
            'economic_group_id.exists' => 'O grupo econômico selecionado não existe. Por favor, selecione um grupo econômico válido.',
        ]);

        // Atualiza a bandeira
        $brand->update([
            'name' => $request->name,
            'economic_group_id' => $request->economic_group_id,
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Bandeira atualizada com sucesso.');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Bandeira deletada com sucesso.');
    }
}
