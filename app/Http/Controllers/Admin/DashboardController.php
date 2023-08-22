<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
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

        $customersCount = $customers->count();
        $assistantsCount = $assistants->count();

        return view('admin.dashboard.index', compact('customersCount', 'assistantsCount'));
    }
}
