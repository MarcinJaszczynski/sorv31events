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

        // if ($request->keyword != '' and $request->contractortype != '') {

        $q = Contractor::query();

        $type = $request['contractortype'];
        if(!empty($type)){
            $q->whereHas('contractortype', function($q) use($type)
            {
                $q->where('contractor_type_id', $type);
            });
        }
        
        $keyword = $request['keyword'];

        if(!empty($request['keyword'])){
        $q->where(function($q) use($keyword){
            $q->where('name', 'LIKE', '%' .$keyword. '%')
            ->orWhere('firstname', 'LIKE', '%'.$keyword.'%')
            ->orWhere('surname', 'LIKE', '%'.$keyword.'%')
            ->orWhere('street', 'LIKE', '%'.$keyword.'%')
            ->orWhere('city', 'LIKE', '%'.$keyword.'%')
            ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
            ->orWhere('email', 'LIKE', '%'.$keyword.'%');
        });
    }
        


            //         ->orWhere('firstname', 'LIKE', '%' . $request['keyword'] . '%')
            //         ->orWhere('surname', 'LIKE', '%' . $request['keyword'] . '%')
            //         ->orWhere('city', 'LIKE', '%' . $request['keyword'] . '%')
            //         ->orWhere('street', 'LIKE', '%' . $request['keyword'] . '%')
            //         ->orWhere('phone', 'LIKE', '%' . $request['keyword'] . '%')
            //         ->orWhere('email', 'LIKE', '%' . $request['keyword'] . '%'
            //     );
            // }



            // $contractors = Contractor::with('type')
            //     ->whereRelation('type', 'contractor_type_id', '=', $request->contractortype)
            //     ->where('name', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
            //     ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
            //     ->get();
        //     $type = $request->contractortype;
        //     $contractors = Contractor::with('type')
        //         ->whereHas('type', function ($q) use ($type) {
        //             $q->where('contractor_types.id', $type);
        //         })
        //         ->where('name', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
        //         ->get();
        // } elseif ($request->keyword == '') {
        //     $contractors = Contractor::with('type')
        //         ->where('name', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
        //         ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
        //         ->get();
        // }

        $contractors = $q->with('type')->get();


        return response()->json([
            'contractors' => $contractors


        ]);
    }
}
