<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataModel;
use App\Models\MasterDataModel;

use PHPUnit\Framework\MockObject\Stub\ReturnValueMap;

class Maps extends BaseController
{
    public $masterDataModel;
    public function index()
    {
        helper('form');
        $model = new DataModel();
        

        $fileName= $fileName = 'https://raw.githubusercontent.com/DeaVenditama/ciwebgis/part3/public/maps/prov.geojson'; 
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $features = $file->features;

        $idMasterData=1;
        if($this->request->getPost()){
            $idMasterData= $this->request->getPost('master');
        }

        foreach ($features as $index => $feature)
        {
            $kode_wilayah = $feature->properties->kode;
            $data = $model->where('id_master_data', $idMasterData)
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();

            if($data){
                $features[$index]->properties->nilai = $data->nilai;
            }
        }

        $nilaiMax = $model->select('MAX(nilai) as nilai')->where('id_master_data', $idMasterData)->first()->nilai;

        $masterDataModel= new MasterDataModel();
        $masterData= $masterDataModel->find($idMasterData);

        $allMasterData= $masterDataModel->findAll();
        $masterDataMenu = [];

        foreach($allMasterData as $md){
            $masterDataMenu[$md->id]= $md->nama;
        }

        return view('maps/index',[
			'data' => $features,
			'nilaiMax' => $nilaiMax,
            'masterData'=>$masterData,
            'masterDataMenu'=> $masterDataMenu,
		]);
    }
}
