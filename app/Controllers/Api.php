<?php

namespace App\Controllers;

use App\Models\TabelObjekModel;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    protected $format = 'json';
    protected $TabelObjekModel;

    public function __construct()
    {
        $this->TabelObjekModel = new TabelObjekModel();
    }

    public function index()
    {
        $dataobjek = $this->TabelObjekModel->findAll();

        $feature = array();

        // looping membuat data yang berjumlah lebih dari satu
        foreach ($dataobjek as $d) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        floatval($d['longitude']),
                        floatval($d['latitude']),
                    ]
                ],
                'properties' => [
                    'id' => $d['id'],
                    'nama' => $d['nama'],
                    'deskripsi' => $d['deskripsi'],
                    'foto' => $d['foto'],
                ]
            ];
        }

        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );

        return $this->respond($geojson);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        return view('v_map');
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    // Leaflet Draw Polygon GeoJSON : koneksi ke database
    public function polygon()
    {
        $db = db_connect(); //koneksi ke database
        $query = $db->query("SELECT id, nama, ST_AsGeoJSON(geom) AS geom, ST_Area(geom, true) As luas_m2, foto, deskripsi, created_at, updated_at FROM tbl_data_polygon WHERE deleted_at IS NULL");

        $query_array = $query->getResultArray();
        $feature = array();

        // looping membuat data yang berjumlah lebih dari satu
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'luas_m2' => $q['luas_m2'],
                    'luas_ha' => $q['luas_m2'] / 10000,
                    'luas_km2' => $q['luas_m2'] / 1000000,
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );

        return $this->respond($geojson);
    }

    // Leaflet Draw One Polygon GeoJSON
    public function one_polygon($id)
    {
        $db = db_connect(); //koneksi ke database
        $query = $db->query("SELECT id, nama, ST_AsGeoJSON(geom) AS geom, ST_Area(geom, true) As luas_m2, foto, deskripsi, created_at, updated_at FROM tbl_data_polygon WHERE deleted_at IS NULL");

        $query_array = $query->getResultArray();
        $feature = array();

        // looping membuat data yang berjumlah lebih dari satu
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'luas_m2' => $q['luas_m2'],
                    'luas_ha' => $q['luas_m2'] / 10000,
                    'luas_km2' => $q['luas_m2'] / 1000000,
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );

        return $this->respond($geojson);
    }

    public function polyline()
    {
        $db = db_connect(); //koneksi ke database
        $query = $db->query("SELECT id, nama, ST_AsGeoJSON(geom) AS geom, ST_Length(geom, true) As panjang_m, foto, deskripsi, created_at, updated_at FROM tbl_data_polyline");

        $query_array = $query->getResultArray();
        $feature = array();

        // looping membuat data yang berjumlah lebih dari satu
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'panjang_m' => $q['panjang_m'],
                    'panjang_km' => $q['panjang_m'] / 1000,
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );

        return $this->respond($geojson);
    }

    public function point()
    {
        $db = db_connect(); //koneksi ke database
        $query = $db->query("SELECT id, nama, ST_AsGeoJSON(geom) AS geom, foto, deskripsi, created_at, updated_at FROM tbl_data_point");

        $query_array = $query->getResultArray();
        $feature = array();

        // looping membuat data yang berjumlah lebih dari satu
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto']
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );

        return $this->respond($geojson);
    }
}
