<?php

namespace App\Controllers;

use App\Models\TabelObjekModel;
use App\Controllers\BaseController;

class Objek extends BaseController
{
    protected $TabelObjekModel;

    public function __construct()
    {
        $this->TabelObjekModel = new TabelObjekModel();
        $this->data['validation'] = \Config\Services::validation();
    }

    //memasukkan variabel data ke dalam v_input
    public function index()
    {
        session();
        return view('v_input', $this->data);
    }

    public function simpantambahdata()
    {
        if (!$this->validate([
            'input_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom nama objek harus diisi.'
                ]
            ],
            'input_longitude' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kolom longitude harus diisi.',
                    'numeric' => 'Kolom longitude harus berupa angka.'
                ]
            ],
            'input_latitude' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kolom latitude harus diisi.',
                    'numeric' => 'Kolom ltude harus berupa angka.'
                ]
            ],
            'input_foto' => [
                'rules' => 'max_size[input_foto, 1024]|mime_in[input_foto, image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 200 KB.',
                    'mime_in' => 'File yang diupload harus berupa gambar JPG/JPEG/PNG.'
                ]
            ]
        ])) {
            return redirect()->to('objek')->with("message", 'Gagal menambahkan data lokasi objek.')->withInput();
        }

        // Upload foto > menangkap file dari input foto, jika file belum ada maka akan dibuat dgn fungsi 'mkdir', 
        $file_foto = $this->request->getFile('input_foto');

        if ($file_foto->getError() == 4) {
            $nama_foto = NULL;
        } else {
            $foto_dir = 'upload/foto/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, TRUE);
            }

            $nama_foto = 'foto_' . preg_replace('/\s+/', '', $_POST['input_nama']) . '.' .
                $file_foto->getExtension();

            //memindahkan file
            $file_foto->move($foto_dir, $nama_foto);
        }


        $data = [
            'nama' => $_POST['input_nama'],
            'deskripsi' => $_POST['input_deskripsi'],
            'longitude' => $_POST['input_longitude'],
            'latitude' => $_POST['input_latitude'],
            'foto' => $nama_foto,
        ];

        $this->TabelObjekModel->save($data);

        return redirect()->to('objek/table')->with('message', 'Data berhasil ditambahkan!');
    }

    public function view()
    {
        return view('v_map');
    }

    public function table()
    {
        $data['objek'] = $this->TabelObjekModel->findAll();

        return view('v_table', $data);
    }

    public function hapus($id)
    {
        $this->TabelObjekModel->delete($id);

        return redirect()->to('objek/table')->with('message', 'Data berhasil dihapus!');
    }

    public function edit($id)
    {
        $data['objek'] = $this->TabelObjekModel->find($id);

        return view('v_edit', $data,);
    }

    public function simpaneditdata($id)
    {
        session();

        //Upload Foto
        $file_foto = $this->request->getFile('input_foto');

        if ($file_foto->getError() == 4) {
            if ($_POST['input_foto_lama'] !== '') {
                $nama_foto = $_POST['input_foto_lama'];
            } else {
                $nama_foto = NULL;
            }
            $nama_foto = NULL;
        } else {
            $foto_dir = 'upload/foto/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, TRUE);
            }

            // cek foto lama existing
            if ($_POST['input_foto_lama'] !== '') {
                if (file_exists($foto_dir . $_POST['input_foto_lama'])) {
                    unlink($foto_dir . $_POST['input_foto_lama']);
                }
            }


            $nama_foto = 'foto_' . preg_replace('/\s+/', '', $_POST['input_nama']) . '.' .
                $file_foto->getExtension();

            //memindahkan file
            $file_foto->move($foto_dir, $nama_foto);
        }


        $data = [
            'id' => $id, //sebagai parameter edit data
            'nama' => $_POST['input_nama'],
            'deskripsi' => $_POST['input_deskripsi'],
            'longitude' => $_POST['input_longitude'],
            'latitude' => $_POST['input_latitude'],
            'foto' => $nama_foto,
        ];

        $this->TabelObjekModel->save($data);

        return redirect()->to('objek/table')->with('message', 'Data berhasil diubah!');
    }
}
