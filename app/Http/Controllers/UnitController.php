<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand; // Para validar se a marca existe
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém as unidades com paginação de 10 itens por vez
        $units = Unit::with(['brand', 'brand.economicGroup'])->paginate(10);

        // Retorna a view com os dados das unidades
        return view('units.index', ['units' => $units]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pega todas as marcas para popular o campo de seleção de marca
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados com mensagens personalizadas
        $request->validate([
            'fantasy_name' => 'required|string|max:48',
            'corporate_name' => 'required|string|max:48|unique:units,corporate_name',
            'cnpj' => 'required|string|size:14|unique:units,cnpj|regex:/^[0-9]+$/', // Validando o CNPJ
            'brand_name' => 'required|string|max:48|exists:brands,name' // Valida se a bandeira existe na tabela `brands`
        ], [
            'corporate_name.unique' => 'Já existe uma unidade com essa Razão Social.',
            'cnpj.unique' => 'Já existe uma unidade com esse CNPJ.',
            'cnpj.regex' => 'O CNPJ deve conter apenas números, sem letras ou símbolos.',
            'brand_name.exists' => 'A bandeira informada não existe. Por favor, insira um nome de bandeira válido.' // Mensagem de erro personalizada
        ]);

        // Verifica se a bandeira existe
        $brand = Brand::where('name', $request->brand_name)->first();

        // Criação da nova unidade, associando a bandeira existente
        Unit::create([
            'fantasy_name' => $request->fantasy_name,
            'corporate_name' => $request->corporate_name,
            'cnpj' => $request->cnpj,
            'brand_id' => $brand->id, // Associa a bandeira à unidade
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Unidade criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            return view('units.show', compact('unit'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('units.index')->with('error', 'Unidade não encontrada.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            return view('units.edit', compact('unit'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('units.index')->with('error', 'Unidade não encontrada.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'fantasy_name' => 'required|string|max:48',
            'corporate_name' => 'required|string|max:48|unique:units,corporate_name,' . $id,
            'cnpj' => 'required|string|size:14|unique:units,cnpj|regex:/^[0-9]+$/',
            'brand_name' => 'required|string|max:48|exists:brands,name', // Valida se a bandeira existe na tabela `brands`
        ], [
            'corporate_name.unique' => 'Já existe uma unidade com essa Razão Social.',
            'cnpj.unique' => 'Já existe uma unidade com esse CNPJ.',
            'cnpj.regex' => 'O CNPJ deve conter apenas números, sem letras ou símbolos.',
            'brand_name.exists' => 'A bandeira informada não existe. Por favor, insira um nome de bandeira válido.' // Mensagem de erro personalizada
        ]);

        // Verifica se a bandeira existe
        $brand = Brand::where('name', $request->brand_name)->first();

        // Atualiza a unidade, associando a bandeira existente
        $unit = Unit::findOrFail($id);
        $unit->update([
            'fantasy_name' => $request->fantasy_name,
            'corporate_name' => $request->corporate_name,
            'cnpj' => $request->cnpj,
            'brand_id' => $brand->id, // Associa a bandeira à unidade
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Unidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'Unidade deletada com sucesso.');
    }
}
