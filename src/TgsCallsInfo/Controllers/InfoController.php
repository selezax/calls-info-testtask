<?php
namespace TgsCallsInfo\Controllers;


use TgsCallsInfo\Services\CallsData;
use TgsCallsInfo\Services\Requests;

class InfoController extends Controllers
{

    /**
     *
     */
    public function upload(){
        try{
            $request = new Requests();
            if($request->validate([
                'file_info' => ['required', 'file', 'mime|text/csv']
            ])){

                $data = new CallsData('file_info');
                $data->parseDataFromRequest();
                $this->view('info', [ 'data' => $data]);

            } else{
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }

        } catch (\RuntimeException $e){
            $this->error($e->getMessage());
        }

    }

}