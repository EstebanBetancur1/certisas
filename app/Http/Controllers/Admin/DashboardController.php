<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    protected $userRepository = null;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repository = $this->userRepository;

        $customers = $repository->findWhere([
            ['is_admin', '<>', 1],
            ['type', '=', 1],
        ]);

        $assistants = $repository->findWhere([
            ['is_admin', '<>', 1],
            ['type', '=', 2],
        ]);
        
        $reuest = DB::table('requests')->where('status', '=', 0);

        $RequestCliets = DB::table('company_users')->where('status', '=', 0)->get();

    
        $customersCount = $customers->count();
        $assistantsCount = $assistants->count();
        $reuestCount = $reuest->count();
        $RequestClietsCount = $RequestCliets->count();

        return view('admin.dashboard.index', compact('customersCount', 'assistantsCount', 'reuestCount', 'RequestClietsCount'));
    }


}
