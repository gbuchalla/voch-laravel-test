<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;


class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $audits = Audit::with(['user'])->orderBy('created_at', 'desc')->paginate(10);
        
        return view('audits.index', compact('audits'));
    }
}
