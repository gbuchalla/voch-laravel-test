<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {

        return Employee::with(['unit', 'unit.brand', 'unit.brand.economicGroup'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'CPF',
            'CPF Formatado',
            'Unidade',
            'Marca',
            'Grupo Econômico',
            'Data de Criação',
            'Última Atualização',
        ];
    }

    public function map($employee): array
    {
        // Mapeamento dos dados para exportação
        return [
            $employee->id,
            $employee->name,
            $employee->email,
            $employee->cpf,
            substr($employee->cpf, 0, 3) . '.' . substr($employee->cpf, 3, 3) . '.' . substr($employee->cpf, 6, 3) . '-' . substr($employee->cpf, 9, 2),
            optional($employee->unit)->fantasy_name ?? 'N/A',
            optional($employee->unit?->brand)->name ?? 'N/A',
            optional($employee->unit?->brand?->economicGroup)->name ?? 'N/A',
            $employee->created_at->format('d/m/Y H:i:s'),
            $employee->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
