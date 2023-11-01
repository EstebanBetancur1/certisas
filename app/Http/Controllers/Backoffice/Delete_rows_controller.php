<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;
use App\Traits\CrudTrait;

use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRequest;

use App\Imports\TemplatesImport;
use Maatwebsite\Excel\Validators\ValidationException;

use PDF;

use Illuminate\Support\Facades\Validator;

class Delete_rows_controller extends Controller
{
    public function destroy(Request $request) {
        $data = $request->input('data'); // Esto será un array de arrays
    
        // dd($data);
        // die();
        $ids = array_column($data, 'id');
        $deletedCount = DB::table('declarations')->whereIn('id', $ids)->delete();
    
        // Retorna una respuesta incluyendo la cantidad de registros eliminados
        return response()->json(['status' => 'success', 'deletedCount' => $deletedCount]);
    }
}
