<?php namespace Controllers;
    use Models\Model_mhs;
    class Mahasiswa
    {
        public function __construct()
        {
            $this->mhs = new Model_mhs();
        }

        public function index()
        {
            require_once 'app/Views/index.php';
        }

        function show_data()
        {
            if(!isset($_GET['i']))
            {
                $rs = $this->mhs->lihatData();
                require_once('app/Views/mhsList.php');
            }
            else
            {
                //ada parameter id yan dikirim, tampilkan detail dari salah satu data yang dipilih
                $rs = $this->mhs->lihatDataDetail($_GET['i']);
                require_once('app/Views/mhsDetail.php');
            }
        }

        function save()
        {
            $nim =  $_POST['nim'];
            $nama = $_POST['nama'];

            $this->mhs->simpanData($nim,$nama);
            $this->index();
        }
    }