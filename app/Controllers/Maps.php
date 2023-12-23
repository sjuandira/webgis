<?php

namespace App\Controllers;

class Maps extends BaseController
{
    public function index()
    {
        helper('form');
        $model = new \App\Models\DataModel();

		$filePath = FCPATH . 'maps/BALAM.json';
            // var_dump($filePath);  // Tambahkan ini untuk debugging

            if (file_exists($filePath)) {
                $fileContents = file_get_contents($filePath);
                $data = json_decode($fileContents, true);
                $features = $data['features'];

                $idMasterData = 11;
                if($this->request->getPost()){
                    $idMasterData = $this->request->getPost('master');
                }

                foreach ($features as &$index) {
                    $kode_wilayah = $index['properties']['NAMOBJ'];
                    $data = $model->join('kode_wilayah','kode_wilayah.kode_wilayah = data.kode_wilayah')->where('id_master_data', $idMasterData)
                                    ->where('nama_wilayah', $kode_wilayah)
                                    ->first();

                    if($data){
                        $index['properties']['nilai'] = $data->nilai;
                    }
                }
			}

        // $fileName = 'https://raw.githubusercontent.com/DeaVenditama/ciwebgis/part3/public/maps/prov.geojson'; 
        // $file = file_get_contents($fileName);
        // $file = json_decode($file);

        // $features = $file->features;

		// $idMasterData = 1;
		// if($this->request->getPost())
		// {
		// 	$idMasterData = $this->request->getPost('master');
		// }

        // foreach($features as $index=>$feature)
		// {
		// 	$kode_wilayah = $feature->properties->kode;
		// 	$data = $model->where('id_master_data',$idMasterData)
		// 				->where('kode_wilayah', $kode_wilayah)
		// 				->first();

		// 	if($data)
		// 	{
		// 		$features[$index]->properties->nilai = $data->nilai;
		// 	}
		// }

		$nilaiMax = $model->select('MAX(nilai) AS nilai')->where('id_master_data', $idMasterData)->first()->nilai;

        $masterDataModel = new \App\Models\MasterDataModel();
		$masterData = $masterDataModel->find($idMasterData);

		$allMasterData = $masterDataModel->findAll();

		$masterDataMenu = [];

		foreach($allMasterData as $md)
		{
			$masterDataMenu[$md->id] = $md->nama;
		}

		return view('maps/index',[
			'data' => $features,
			'nilaiMax' => $nilaiMax,
			'masterData' => $masterData,
			'masterDataMenu' => $masterDataMenu,
		]);

		
    }

    // return view('maps/index');
}