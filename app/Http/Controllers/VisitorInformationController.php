<?php

namespace App\Http\Controllers;

use App\Models\VisitorInformation;
use Carbon\Carbon;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use Throwable;

class VisitorInformationController extends Controller
{

    public function index(Request $request)
    {
        $visitorInformation = new VisitorInformation();
        $page_content = [
            'page_title'      => __('Visitor List'),
            'module_name'     => __('Visitor'),
            'sub_module_name' => __('List'),
            'module_route'    => route('visitor.index'),
            'button_type'    => 'list' //create
        ];
        $visitors = $visitorInformation->getAllVisitorInformation($request);
        $oses = $visitorInformation->getDistinctOs();
        $browsers = $visitorInformation->getDistinctBrowser();
        $device_types = $visitorInformation->getDistinctDeviceType();
        $devices = $visitorInformation->getDistinctDevice();
        $filters = $request->all();
        $visitor_statistics = $visitorInformation->getVisitorStatistics();
        $columns = Schema::getColumnListing('visitor_information');
        return view('visitor.index', compact(
            'page_content',
            'visitors',
            'filters',
            'oses',
            'browsers',
            'devices',
            'device_types',
            'visitor_statistics',
            'columns'
        ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    final public function store(Request $request): void
    {
        try{
            $position                    = env('APP_ENV') === 'local' ? Location::get('103.113.225.117') : Location::get($request->ip());
            $visitor_info['agent']       = $request->userAgent();
            $visitor_info['ip']          = $request->ip();
            $visitor_info['city']        = $position->cityName;
            $visitor_info['country']     = $position->countryName;
            $visitor_info['zip']         = $position->zipCode;
            $visitor_info['long']        = $position->longitude;
            $visitor_info['lat']         = $position->latitude;
            $visitor_info['long_react']  = $request->long;
            $visitor_info['lat_react']   = $request->lat;
            $visitor_info['region']      = $position->regionName;
            $visitor_info['timeZone']    = $position->timezone;
            $visitor_info['user_id']     = auth()->user()?->id;
            $visitor_info['browser']     = Browser::browserName();
            $visitor_info['os']          = Browser::platformName();
            $visitor_info['device']      = Browser::deviceFamily();
            $visitor_info['device_type'] = Browser::deviceType(). ' '. Browser::deviceModel();
            $previous_session            = VisitorInformation::query()->where('ip', $request->ip())->latest()->first();

            $interval = env('VISITOR_INFO_SAVE_INTERVAL') ?? VisitorInformation::VISITOR_INFO_SAVE_INTERVAL;
            if (empty($previous_session)){
                VisitorInformation::query()->create($visitor_info);
            }elseif($previous_session->created_at->diffInMinutes(Carbon::now()) >=  $interval){
                VisitorInformation::query()->create($visitor_info);
            }
            if ($request->long && $previous_session) {
                $visitor_info_update['long_react'] = $request->long;
                $visitor_info_update['lat_react']  = $request->lat;
                $previous_session->update($visitor_info_update);
            }
        }catch (Throwable $throwable){
            Log::info('VISITOR_DATA_STORE_FAILED', ['error'=>$throwable]);
        }
    }

}
