<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Contractor;
use App\Models\ContractorType;


use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use PhpParser\Node\Expr\AssignOp\Concat;

class CustomerSearchController extends Controller
{

    public function index()
    {
        return view('Customersearch.index');
    }

    public function showCustomer(Request $request)
    {
        $contractors = "";
        if ($request->keyword != '' and $request->contractortype != '') {

            // $contractors = Contractor::with('type')
            //     ->whereRelation('type', 'contractor_type_id', '=', $request->contractortype)
            //     ->where('name', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
            //     ->get();
            $type = $request->contractortype;
            $contractors = Contractor::with('type')
                ->whereHas('type', function ($q) use ($type) {
                    $q->where('contractor_types.id', $type);
                })
                ->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
                ->get();
        } elseif ($request->keyword == '') {
            $contractors = Contractor::with('type')
                ->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
                ->get();
        }




        return response()->json([
            'contractors' => $contractors
        ]);
    }
}
