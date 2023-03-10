<?php

namespace Modules\Service\Http\Controllers\Tenant\Admin;

use App\Helpers\LanguageHelper;
use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Entities\Service;
use Modules\Service\Entities\ServiceCategory;
use function view;

class ServiceCategoryController extends Controller
{

    public function index(Request $request){

        $all_services = ServiceCategory::all();
        return view('service::tenant.admin.services.category')->with([
            'all_services' => $all_services,
            'default_lang'=> $request->lang ?? LanguageHelper::default_slug()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'status' => 'nullable|string|max:191',
        ]);

        $service = new ServiceCategory();
        $service->setTranslation('title',$request->lang, SanitizeInput::esc_html($request->title));
        $service->status = $request->status;
        $service->save();

        return response()->success(ResponseMessage::SettingsSaved());
    }


    public function update_service(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:191',
            'status' => 'required',
        ]);

        $service = ServiceCategory::find($request->id);
        $service->setTranslation('title',$request->lang, SanitizeInput::esc_html($request->title));
        $service->status = $request->status;
        $service->save();

        return response()->success(ResponseMessage::SettingsSaved());
    }


    public function delete(Request $request,$id){
        ServiceCategory::find($id)->delete();
        return response()->danger(ResponseMessage::delete('Service Deleted'));
    }

    public function bulk_action_service(Request $request){
        ServiceCategory::whereIn('id',$request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }
}
