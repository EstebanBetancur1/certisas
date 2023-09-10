<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class TicketsController extends Controller
{
    protected $allowed_types_regular_expression = '/(\.xls|\.xlsx|\.pdf)$/';
    protected $allowed_types = ['xls', 'xlsx', 'pdf'];
    protected $path = 'tickets';

    function my(){
        $ticketRepository = Repository("Ticket");

        $tickets = $ticketRepository->findWhere(['user_id' => auth()->user()->id, 'status' => 1]);

        return view('backoffice.tickets.my', compact("tickets"));
    }

    function company(){

        $company = getAgent();

        $ticketRepository = Repository("Ticket");

        $tickets = $ticketRepository->findWhere(['receiver_id' => $company->id, 'status' => 1]);

        return view('backoffice.tickets.company', compact("tickets", "company"));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function emission($id){
        $repository = Repository("Emission");
        $ticketRepository = Repository("Ticket");
        $messageRepository = Repository("Message");

        $emission = $repository->find($id);

        $ticket = $ticketRepository->findWhere([
            'emission_id' => $emission->id
        ])->first();

        $messages = [];

        if($ticket){
            $messages = $messageRepository->orderBy("id", "asc")->findwhere(["ticket_id" => $ticket->id]);
        }

        return view('backoffice.tickets.emission', compact("emission", "ticket", "messages"));
    }
   
    public function store($id){

        $post = request()->all();

        $emissionRepository = Repository("Emission");
        $ticketRepository = Repository("Ticket");
        $companyRepository = Repository("Company");

        $emission = $emissionRepository->find($id);

        $company = $companyRepository->findWhere(['nit' => $emission->agent_nit])->first();

        $ticket = $ticketRepository->create([
            'subject'           => $post['subject'],
            'message'           => $post['message'],
            'user_id'           => auth()->user()->id,
            'transmitter_id'    => session("companyID"),
            'emission_id'       => $emission->id,
            'receiver_id'       => $company->id,
            'status'            => 1      ,
        ]);

        if($ticket){

            if(count(request()->allFiles()) > 0){
                $upload = $this->uploadFile();

                if(is_array($upload)){
                    if($upload['status']){
                        $ticket->file = $upload['name'];
                    }

                    $ticket->save();
                }
            }

            return back()->with("alert_success", "El ticket se ha enviado con &eacute;xito");
        }

        return back()->with("alert_error", "Ocurrio un error por favor, intente mas tarde");
    }

    public function downloadFile($id){
        $ticketRepository = Repository("Ticket");

        $item = $ticketRepository->find($id);

        if($item->file){

            if($item->file && is_file(public_path() . "/upload/{$this->path}/" . $item->file)){
                return response()->download(public_path() . "/upload/{$this->path}/" . $item->file);
            }
        }

        return back()->with("alert_error", "Ocurrio un error al descargar el archivo.");
    }

    public function downloadFileMessage($id){
        $messageRepository = Repository("Message");

        $item = $messageRepository->find($id);

        if($item->file){

            if($item->file && is_file(public_path() . "/upload/{$this->path}/" . $item->file)){
                return response()->download(public_path() . "/upload/{$this->path}/" . $item->file);
            }
        }

        return back()->with("alert_error", "Ocurrio un error al descargar el archivo.");
    }

    public function replyStore($id){

        $post = request()->all();

        $ticketRepository = Repository("Ticket");
        $messageRepository = Repository("Message");

        $ticket = $ticketRepository->find($id);

        $message = $messageRepository->create([
            'message'   => $post['message'],
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->user()->id,
            'status'    => 1
        ]);

        if($message){

            if(count(request()->allFiles()) > 0){
                $upload = $this->uploadFile();

                if(is_array($upload)){
                    if($upload['status']){
                        $message->file = $upload['name'];
                    }

                    $message->save();
                }
            }

            return back()->with("alert_success", "La respuesta se ha enviada con &eacute;xito");
        }

        return back()->with("alert_error", "Ocurrio un error por favor, intente mas tarde");
    }

    private function uploadFile($field = 'file'){

        $public_path = public_path();

        $allowed_types = $this->allowed_types;
        $max_size = config('app.max_size_image');

        Storage::disk('upload')->makeDirectory($this->path);

        $files = request()->allFiles();

        if(count($files) == 0){
            return null;
        }

        $UploadedFile = (array_key_exists($field, $files)) ? $files[$field] : [ ];

        if ($UploadedFile && $UploadedFile instanceof UploadedFile) {

            $originalName = $UploadedFile->getClientOriginalName();
            $extension = strtolower($UploadedFile->getClientOriginalExtension());
            // $size = $UploadedFile->getClientSize();

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }

            // if ($size > (int) $max_size * 1024) {
            //     return [
            //         'status' => false,
            //         'message' => 'La imagen no puede ser mayor a ('.$max_size.')Kb.'
            //     ];
            // }

            // Sustituye todo lo que no sea alfanumerico por guion
            $newName = preg_replace('/[^\.a-zA-Z0-9]+/', '-', strtolower($originalName));
            $newName = preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s')).'-'.$newName;

            $pathAbsolute = $public_path.'/upload/'.$this->path;

            try {
                $target = $UploadedFile->move($pathAbsolute, $newName);
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'message' => 'Ocurrio un error al cargar la imagen, por favor intente nuevamente'
                ];
            }

            if ($target) {
                return [
                    'status' => true,
                    'preview' => config('app.base_url').'/upload/'.$this->path.'/'.$newName,
                    'path'    => $this->path,
                    'name'    => $newName
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Ocurrio un error, por favor intente mas tarde.'
        ];
    }

    private function destroyFile($image){
        $public_path = public_path();
        $pathAbsolute = $public_path.'/upload/'.$this->path;

        if(is_file($pathAbsolute.'/'.$image)){
            unlink($pathAbsolute.'/'.$image);
        }
    }

    public function sendtikect(Request $request){


        $post = $request->all();

        $id = 1;
    
       $tick = DB::table('tickets')->insert([
            'subject' => $post['subject'],
            'message' => $post['message'],
            'user_id' => $post['user_id'],
            'transmitter_id' => session("companyID"),
            'emission_id' => $post['emission_id'],
            'receiver_id' => $post['receiver_id'],
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if($tick){
            return back()->with("alert_success", "El ticket se ha enviado con &eacute;xito");
        }

        return back()->with("alert_error", "Ocurrio un error por favor, intente mas tarde");



    }




}