<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFees;
use App\Models\AdmissionQuery;
use App\Models\Program;
use App\Models\SourceType;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\get;

class LeadIntegrstionController extends Controller
{
    public function index($id)
    {
        $programIds = AdmissionFees::pluck('program_id')->unique();
        $programs = Program::whereIn('id', $programIds)->get();
        return view('lead_integration', compact('id', 'programs'));
    }



    public function store(Request $request)
    {
       
        $programFee = AdmissionFees::where('program_id', $request->program_id)->first();
        
        if (!$programFee) {
            return redirect()->back()->with('error', 'Invalid Program Selected.');
        }
    
        if (!SourceType::where('id', $request->source_id)->exists()) {
            return redirect()->back()->with('error', 'Invalid Source Type.');
        }
    
        $institution = DB::table('institutions')->first();
        
        $admission = new AdmissionQuery();
        $admission->first_name = $request->first_name;
        $admission->last_name = $request->last_name;
        $admission->email = $request->email;
        $admission->phone = $request->mobile;
        $admission->source_type_id = $request->source_id;
        $admission->batch_id = $programFee->batch_id;  
        $admission->program_id = $request->program_id; 
        $admission->institution_id = $institution->id;
        $admission->save();
    
        return redirect()->back()->with('success', 'Admission Created Successfully.');
    }
}
