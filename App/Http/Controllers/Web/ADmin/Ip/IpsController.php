<?php

namespace Lareon\Modules\Fence\App\Http\Controllers\Web\ADmin\Ip;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Lareon\Modules\Fence\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Fence\App\Http\Requests\Admin\DeleteIpRequest;
use Lareon\Modules\Fence\App\Http\Requests\Admin\NewIpRequest;
use Lareon\Modules\Fence\App\Http\Requests\Admin\UpdateIpRequest;
use Lareon\Modules\Fence\App\Logic\IpLogic;
use Lareon\Modules\Fence\App\Models\RestrictIp;
use Teksite\Lareon\Facade\WebResponse;

class IpsController extends Controller implements HasMiddleware
{
    public function __construct(public IpLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.setting.edit'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restrctips=$this->logic->get()->result;
        return view('fence::admin.pages.ips.index', compact('restrctips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fence::admin.pages.ips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewIpRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res, route('admin.settings.ips.index'))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(RestrictIp $restrctip)
    {
        if(Route::has('tags.show')){
            return redirect()->route('tags.show', compact('restrctip'));
        }
        abort(404);
    }

    public function destroy(DeleteIpRequest $request)
    {
        $res= $this->logic->delete($request->validated());
        return WebResponse::byResult($res, route('admin.settings.ips.index'))->go();
    }
}
