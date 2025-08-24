<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomerLiveSearchController extends Controller
{
    //
    public function index()
    {
        return view('events.eventinit');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('contractors')
                    ->where('name', 'like', '%' . $query . '%')
                    ->orWhere('firstname', 'like', '%' . $query . '%')
                    ->orWhere('surname', 'like', '%' . $query . '%')
                    ->orWhere('phone', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('street', 'like', '%' . $query . '%')
                    ->orWhere('nip', 'like', '%' . $query . '%');
            } else {
                $data = DB::table('contractors')->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <td>$row -> name</td>
                    <td>$row -> street</td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }

            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
        }

        echo json_encode($data);
    }
}
