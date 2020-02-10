<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriberhistory;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscribersLifeTimeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $srvices = Subscriberhistory::select('ServiceName')->distinct()->get();

        return view('subscribeLifeTime.form', compact('srvices'));
    }

// do serach
    public function search(Request $request) {

        $from = Carbon::createFromFormat('d/m/Y', $request->start);
        $to = Carbon::createFromFormat('d/m/Y', $request->end);
        $Data = Subscriberhistory::select('phone', DB::raw('count(NewStatus) as days'))
                ->whereBetween('created_at', [$from, $to])
                ->where('ServiceName', "$request->ServiceName")
                ->where('NewStatus', 0)
                ->groupBy('phone')
                ->paginate(100);
        $DataAVG = Subscriberhistory::whereBetween('created_at', [$from, $to])
                ->where('ServiceName', "$request->ServiceName")
                ->where('NewStatus', 0)
                ->count('NewStatus');

        $Data = $Data->appends(request()->input());
        $result = view('subscribeLifeTime.index', compact('Data', 'DataAVG'))->render();

        return Response(array('data' => $result));
    }

}
