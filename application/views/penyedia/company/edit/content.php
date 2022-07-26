
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css'rel='stylesheet'/>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark"><?php echo $block_header ?></h5>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="col-12">
                <?php
                echo $alert;
                ?>
              </div>
              <div class="row">
                <div class="col-6">
                  <h5>
                    <?php echo strtoupper($header) ?>
                    <p class="text-secondary"><small><?php echo $sub_header ?></small></p>
                  </h5>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="float-right">
                        <?php echo (isset($header_button)) ? $header_button : '';  ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
                <!--  -->
                <?php echo form_open_multipart();  ?>
                <!-- <textarea class="summernote" name="" id="summernote" cols="30" rows="10"></textarea> -->
                <?php echo (isset($contents)) ? $contents : '';  ?>
                <!-- <div id='map'style='width: 100%; height: 500px;'></div> -->

                <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                    Simpan
                </button>

                <?php echo form_close()  ?>
              <!--  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
    var province_city = {
      'NAD Aceh': [
        'Kabupaten Aceh Barat',
        'Kabupaten Aceh Barat Daya',
        'Kabupaten Aceh Besar',
        'Kabupaten Aceh Jaya',
        'Kabupaten Aceh Selatan',
        'Kabupaten Aceh Singkil',
        'Kabupaten Aceh Tamiang',
        'Kabupaten Aceh Tengah',
        'Kabupaten Aceh Tenggara',
        'Kabupaten Aceh Timur',
        'Kabupaten Aceh Utara',
        'Kabupaten Bener Meriah',
        'Kabupaten Bireuen',
        'Kabupaten Gayo Lues',
        'Kabupaten Nagan Raya',
        'Kabupaten Pidie',
        'Kabupaten Pidie Jaya',
        'Kabupaten Simeulue',
        'Kota Banda Aceh',
        'Kota Langsa',
        'Kota Lhokseumawe',
        'Kota Sabang',
        'Kota Subulussalam',
      ],
      'Sumatera Utara': [
        'Kabupaten Asahan',
        'Kabupaten Batubara',
        'Kabupaten Dairi',
        'Kabupaten Deli Serdang',
        'Kabupaten Humbang Hasundutan',
        'Kabupaten Karo',
        'Kabupaten Labuhanbatu',
        'Kabupaten Labuhanbatu Selatan',
        'Kabupaten Labuhanbatu Utara',
        'Kabupaten Langkat',
        'Kabupaten Mandailing Natal',
        'Kabupaten Nias',
        'Kabupaten Nias Barat',
        'Kabupaten Nias Selatan',
        'Kabupaten Nias Utara',
        'Kabupaten Padang Lawas',
        'Kabupaten Padang Lawas Utara',
        'Kabupaten Pakpak Bharat',
        'Kabupaten Samosir',
        'Kabupaten Serdang Bedagai',
        'Kabupaten Simalungun',
        'Kabupaten Tapanuli Selatan',
        'Kabupaten Tapanuli Tengah',
        'Kabupaten Tapanuli Utara',
        'Kabupaten Toba Samosir',
        'Kota Binjai',
        'Kota Gunungsitoli',
        'Kota Medan',
        'Kota Padangsidempuan',
        'Kota Pematangsiantar',
        'Kota Sibolga',
        'Kota Tanjungbalai',
        'Kota Tebing Tinggi',
      ],
      'Sumatera Barat': [
        'Kabupaten Agam',
        'Kabupaten Dharmasraya',
        'Kabupaten Kepulauan Mentawai',
        'Kabupaten Lima Puluh Kota',
        'Kabupaten Padang Pariaman',
        'Kabupaten Pasaman',
        'Kabupaten Pasaman Barat',
        'Kabupaten Pesisir Selatan',
        'Kabupaten Sijunjung',
        'Kabupaten Solok',
        'Kabupaten Solok Selatan',
        'Kabupaten Tanah Datar',
        'Kota Bukittinggi',
        'Kota Padang',
        'Kota Padangpanjang',
        'Kota Pariaman',
        'Kota Payakumbuh',
        'Kota Sawahlunto',
        'Kota Solok',
      ],
      'Sumatera Selatan': [
        'Kabupaten Banyuasin',
        'Kabupaten Empat Lawang',
        'Kabupaten Lahat',
        'Kabupaten Muara Enim',
        'Kabupaten Musi Banyuasin',
        'Kabupaten Musi Rawas',
        'Kabupaten Musi Rawas Utara',
        'Kabupaten Ogan Ilir',
        'Kabupaten Ogan Komering Ilir',
        'Kabupaten Ogan Komering Ulu',
        'Kabupaten Ogan Komering Ulu Selatan',
        'Kabupaten Ogan Komering Ulu Timur',
        'Kabupaten Penukal Abab Lematang Ilir',
        'Kota Lubuklinggau',
        'Kota Pagar Alam',
        'Kota Palembang',
        'Kota Prabumulih',
      ],
      'Riau': [
        'Kabupaten Bengkalis',
        'Kabupaten Indragiri Hilir',
        'Kabupaten Indragiri Hulu',
        'Kabupaten Kampar',
        'Kabupaten Kepulauan Meranti',
        'Kabupaten Kuantan Singingi',
        'Kabupaten Pelalawan',
        'Kabupaten Rokan Hilir',
        'Kabupaten Rokan Hulu',
        'Kabupaten Siak',
        'Kota Dumai',
        'Kota Pekanbaru',
      ],
      'Kepulauan Riau': [
        'Kabupaten Bintan',
        'Kabupaten Karimun',
        'Kabupaten Kepulauan Anambas',
        'Kabupaten Lingga',
        'Kabupaten Natuna',
        'Kota Batam',
        'Kota Tanjung Pinang',
      ],
      'Kepulauan Jambi': [
        'Kabupaten Batanghari',
        'Kabupaten Bungo',
        'Kabupaten Kerinci',
        'Kabupaten Merangin',
        'Kabupaten Muaro Jambi',
        'Kabupaten Sarolangun',
        'Kabupaten Tanjung Jabung Barat',
        'Kabupaten Tanjung Jabung Timur',
        'Kabupaten Tebo',
        'Kota Jambi',
        'Kota Sungai Penuh',
      ],
      'Bengkulu': [
        'Kabupaten Bengkulu Selatan',
        'Kabupaten Bengkulu Tengah',
        'Kabupaten Bengkulu Utara',
        'Kabupaten Kaur',
        'Kabupaten Kepahiang',
        'Kabupaten Lebong',
        'Kabupaten Mukomuko',
        'Kabupaten Rejang Lebong',
        'Kabupaten Seluma',
        'Kota Bengkulu',
      ],
      'Bangka Belitung': [
        'Kabupaten Bangka',
        'Kabupaten Bangka Barat',
        'Kabupaten Bangka Selatan',
        'Kabupaten Bangka Tengah',
        'Kabupaten Belitung',
        'Kabupaten Belitung Timur',
        'Kota Pangkal Pinang',
      ],
      'Lampung': [
        'Kabupaten Lampung Tengah',
        'Kabupaten Lampung Utara',
        'Kabupaten Lampung Selatan',
        'Kabupaten Lampung Barat',
        'Kabupaten Lampung Timur',
        'Kabupaten Mesuji',
        'Kabupaten Pesawaran',
        'Kabupaten Pesisir Barat',
        'Kabupaten Pringsewu',
        'Kabupaten Tulang Bawang',
        'Kabupaten Tulang Bawang Barat',
        'Kabupaten Tanggamus',
        'Kabupaten Way Kanan',
        'Kota Bandar Lampung',
        'Kota Metro',
      ],
      'Banten': [
        'Kabupaten Lebak',
        'Kabupaten Pandeglang',
        'Kabupaten Serang',
        'Kabupaten Tangerang',
        'Kota Cilegon',
        'Kota Serang',
        'Kota Tangerang',
        'Kota Tangerang Selatan',
      ],
      'Jawa Barat': [
        'Kabupaten Bandung',
        'Kabupaten Bandung Barat',
        'Kabupaten Bekasi',
        'Kabupaten Bogor',
        'Kabupaten Ciamis',
        'Kabupaten Cianjur',
        'Kabupaten Cirebon',
        'Kabupaten Garut',
        'Kabupaten Indramayu',
        'Kabupaten Karawang',
        'Kabupaten Kuningan',
        'Kabupaten Majalengka',
        'Kabupaten Pangandaran',
        'Kabupaten Purwakarta',
        'Kabupaten Subang',
        'Kabupaten Sukabumi',
        'Kabupaten Sumedang',
        'Kabupaten Tasikmalaya',
        'Kota Bandung',
        'Kota Banjar',
        'Kota Bekasi',
        'Kota Bogor',
        'Kota Cimahi',
        'Kota Cirebon',
        'Kota Depok',
        'Kota Sukabumi',
        'Kota Tasikmalaya',
      ],
      'Jawa Tengah': [
        'Kabupaten Banjarnegara',
        'Kabupaten Banyumas',
        'Kabupaten Batang',
        'Kabupaten Blora',
        'Kabupaten Boyolali',
        'Kabupaten Brebes',
        'Kabupaten Cilacap',
        'Kabupaten Demak',
        'Kabupaten Grobogan',
        'Kabupaten Jepara',
        'Kabupaten Karanganyar',
        'Kabupaten Kebumen',
        'Kabupaten Kendal',
        'Kabupaten Klaten',
        'Kabupaten Kudus',
        'Kabupaten Magelang',
        'Kabupaten Pati',
        'Kabupaten Pekalongan',
        'Kabupaten Pemalang',
        'Kabupaten Purbalingga',
        'Kabupaten Purworejo',
        'Kabupaten Rembang',
        'Kabupaten Semarang',
        'Kabupaten Sragen',
        'Kabupaten Sukoharjo',
        'Kabupaten Tegal',
        'Kabupaten Temanggung',
        'Kabupaten Wonogiri',
        'Kabupaten Wonosobo',
        'Kota Magelang',
        'Kota Pekalongan',
        'Kota Salatiga',
        'Kota Semarang',
        'Kota Surakarta',
        'Kota Tegal',
      ],
      'Jawa Timur': [
        'Kabupaten Bangkalan',
        'Kabupaten Banyuwangi',
        'Kabupaten Blitar',
        'Kabupaten Bojonegoro',
        'Kabupaten Bondowoso',
        'Kabupaten Gresik',
        'Kabupaten Jember',
        'Kabupaten Jombang',
        'Kabupaten Kediri',
        'Kabupaten Lamongan',
        'Kabupaten Lumajang',
        'Kabupaten Madiun',
        'Kabupaten Magetan',
        'Kabupaten Malang',
        'Kabupaten Mojokerto',
        'Kabupaten Nganjuk',
        'Kabupaten Ngawi',
        'Kabupaten Pacitan',
        'Kabupaten Pamekasan',
        'Kabupaten Pasuruan',
        'Kabupaten Ponorogo',
        'Kabupaten Probolinggo',
        'Kabupaten Sampang',
        'Kabupaten Sidoarjo',
        'Kabupaten Situbondo',
        'Kabupaten Sumenep',
        'Kabupaten Trenggalek',
        'Kabupaten Tuban',
        'Kabupaten Tulungagung',
        'Kota Batu',
        'Kota Blitar',
        'Kota Kediri',
        'Kota Madiun',
        'Kota Malang',
        'Kota Mojokerto',
        'Kota Pasuruan',
        'Kota Probolinggo',
        'Kota Surabaya',
      ],
      'DKI Jakarta': [
        'Kota Administrasi Jakarta Barat',
        'Kota Administrasi Jakarta Pusat',
        'Kota Administrasi Jakarta Selatan',
        'Kota Administrasi Jakarta Timur',
        'Kota Administrasi Jakarta Utara',
        'Kabupaten Administrasi Kepulauan Seribu',
      ],
      'Daerah Istimewa Yogyakarta': [
        'Kabupaten Bantul',
        'Kabupaten Gunungkidul',
        'Kabupaten Kulon Progo',
        'Kabupaten Sleman',
        'Kota Yogyakarta',
      ],
      'Bali': [
        'Kabupaten Badung',
        'Kabupaten Bangli',
        'Kabupaten Buleleng',
        'Kabupaten Gianyar',
        'Kabupaten Jembrana',
        'Kabupaten Karangasem',
        'Kabupaten Klungkung',
        'Kabupaten Tabanan',
        'Kota Denpasar',
      ],
      'Nusa Tenggara Barat': [
        'Kabupaten Bima',
        'Kabupaten Dompu',
        'Kabupaten Lombok Barat',
        'Kabupaten Lombok Tengah',
        'Kabupaten Lombok Timur',
        'Kabupaten Lombok Utara',
        'Kabupaten Sumbawa',
        'Kabupaten Sumbawa Barat',
        'Kota Bima',
        'Kota Mataram',
      ],
      'Nusa Tenggara Timur': [
        'Kabupaten Alor',
        'Kabupaten Belu',
        'Kabupaten Ende',
        'Kabupaten Flores Timur',
        'Kabupaten Kupang',
        'Kabupaten Lembata',
        'Kabupaten Malaka',
        'Kabupaten Manggarai',
        'Kabupaten Manggarai Barat',
        'Kabupaten Manggarai Timur',
        'Kabupaten Ngada',
        'Kabupaten Nagekeo',
        'Kabupaten Rote Ndao',
        'Kabupaten Sabu Raijua',
        'Kabupaten Sikka',
        'Kabupaten Sumba Barat',
        'Kabupaten Sumba Barat Daya',
        'Kabupaten Sumba Tengah',
        'Kabupaten Sumba Timur',
        'Kabupaten Timor Tengah Selatan',
        'Kabupaten Timor Tengah Utara',
        'Kota Kupang',
      ],
      'Kalimantan Barat': [
        'Kabupaten Bengkayang',
        'Kabupaten Kapuas Hulu',
        'Kabupaten Kayong Utara',
        'Kabupaten Ketapang',
        'Kabupaten Kubu Raya',
        'Kabupaten Landak',
        'Kabupaten Melawi',
        'Kabupaten Mempawah',
        'Kabupaten Sambas',
        'Kabupaten Sanggau',
        'Kabupaten Sekadau',
        'Kabupaten Sintang',
        'Kota Pontianak',
        'Kota Singkawang',
      ],
      'Kalimantan Selatan': [
        'Kabupaten Balangan',
        'Kabupaten Banjar',
        'Kabupaten Barito Kuala',
        'Kabupaten Hulu Sungai Selatan',
        'Kabupaten Hulu Sungai Tengah',
        'Kabupaten Hulu Sungai Utara',
        'Kabupaten Kotabaru',
        'Kabupaten Tabalong',
        'Kabupaten Tanah Bumbu',
        'Kabupaten Tanah Laut',
        'Kabupaten Tapin',
        'Kota Banjarbaru',
        'Kota Banjarmasin',
      ],
      'Kalimantan Tengah': [
        'Kabupaten Barito Selatan',
        'Kabupaten Barito Timur',
        'Kabupaten Barito Utara',
        'Kabupaten Gunung Mas',
        'Kabupaten Kapuas',
        'Kabupaten Katingan',
        'Kabupaten Kotawaringin Barat',
        'Kabupaten Kotawaringin Timur',
        'Kabupaten Lamandau',
        'Kabupaten Murung Raya',
        'Kabupaten Pulang Pisau',
        'Kabupaten Sukamara',
        'Kabupaten Seruyan',
        'Kota Palangka Raya',
      ],
      'Kalimantan Timur': [
        'Kabupaten Berau',
        'Kabupaten Kutai Barat',
        'Kabupaten Kutai Kartanegara',
        'Kabupaten Kutai Timur',
        'Kabupaten Mahakam Ulu',
        'Kabupaten Paser',
        'Kabupaten Penajam Paser Utara',
        'Kota Balikpapan',
        'Kota Bontang',
        'Kota Samarinda',
      ],
      'Kalimantan Utara': [
        'Kabupaten Bulungan',
        'Kabupaten Malinau',
        'Kabupaten Nunukan',
        'Kabupaten Tana Tidung',
        'Kota Tarakan',
      ],
      'Gorontalo': [
        'Kabupaten Boalemo',
        'Kabupaten Bone Bolango',
        'Kabupaten Gorontalo',
        'Kabupaten Gorontalo Utara',
        'Kabupaten Pohuwato',
        'Kota Gorontalo',
      ],
      'Sulawesi Selatan': [
        'Kabupaten Bantaeng',
        'Kabupaten Barru',
        'Kabupaten Bone',
        'Kabupaten Bulukumba',
        'Kabupaten Enrekang',
        'Kabupaten Gowa',
        'Kabupaten Jeneponto',
        'Kabupaten Kepulauan Selayar',
        'Kabupaten Luwu',
        'Kabupaten Luwu Timur',
        'Kabupaten Luwu Utara',
        'Kabupaten Maros',
        'Kabupaten Pangkajene dan Kepulauan',
        'Kabupaten Pinrang',
        'Kabupaten Sidenreng Rappang',
        'Kabupaten Sinjai',
        'Kabupaten Soppeng',
        'Kabupaten Takalar',
        'Kabupaten Tana Toraja',
        'Kabupaten Toraja Utara',
        'Kabupaten Wajo',
        'Kota Makassar',
        'Kota Palopo',
        'Kota Parepare',
      ],
      'Sulawesi Tenggara': [
        'Kabupaten Bombana',
        'Kabupaten Buton',
        'Kabupaten Buton Selatan',
        'Kabupaten Buton Tengah',
        'Kabupaten Buton Utara',
        'Kabupaten Kolaka',
        'Kabupaten Kolaka Timur',
        'Kabupaten Kolaka Utara',
        'Kabupaten Konawe',
        'Kabupaten Konawe Kepulauan',
        'Kabupaten Konawe Selatan',
        'Kabupaten Konawe Utara',
        'Kabupaten Muna',
        'Kabupaten Muna Barat',
        'Kabupaten Wakatobi',
        'Kota Bau-Bau',
        'Kota Kendari',
      ],
      'Sulawesi Tengah': [
        'Kabupaten Banggai',
        'Kabupaten Banggai Kepulauan',
        'Kabupaten Banggai Laut',
        'Kabupaten Buol',
        'Kabupaten Donggala',
        'Kabupaten Morowali',
        'Kabupaten Morowali Utara',
        'Kabupaten Parigi Moutong',
        'Kabupaten Poso',
        'Kabupaten Sigi',
        'Kabupaten Tojo Una-Una',
        'Kabupaten Toli-Toli',
        'Kota Palu',
      ],
      'Sulawesi Utara': [
        'Kabupaten Bolaang Mongondow',
        'Kabupaten Bolaang Mongondow Selatan',
        'Kabupaten Bolaang Mongondow Timur',
        'Kabupaten Bolaang Mongondow Utara',
        'Kabupaten Kepulauan Sangihe',
        'Kabupaten Kepulauan Siau Tagulandang Biaro',
        'Kabupaten Kepulauan Talaud',
        'Kabupaten Minahasa',
        'Kabupaten Minahasa Selatan',
        'Kabupaten Minahasa Tenggara',
        'Kabupaten Minahasa Utara',
        'Kota Bitung',
        'Kota Kotamobagu',
        'Kota Manado',
        'Kota Tomohon',
      ],
      'Sulawesi Barat': [
        'Kabupaten Majene',
        'Kabupaten Mamasa',
        'Kabupaten Mamuju',
        'Kabupaten Mamuju Tengah',
        'Kabupaten Mamuju Utara',
        'Kabupaten Polewali Mandar',
        'Kota Mamuju',
      ],
      'Maluku': [
        'Kabupaten Buru',
        'Kabupaten Buru Selatan',
        'Kabupaten Kepulauan Aru',
        'Kabupaten Maluku Barat Daya',
        'Kabupaten Maluku Tengah',
        'Kabupaten Maluku Tenggara',
        'Kabupaten Maluku Tenggara Barat',
        'Kabupaten Seram Bagian Barat',
        'Kabupaten Seram Bagian Timur',
        'Kota Ambon',
        'Kota Tual',
      ],
      'Maluku Utara': [
        'Kabupaten Halmahera Barat',
        'Kabupaten Halmahera Tengah',
        'Kabupaten Halmahera Utara',
        'Kabupaten Halmahera Selatan',
        'Kabupaten Kepulauan Sula',
        'Kabupaten Halmahera Timur',
        'Kabupaten Pulau Morotai',
        'Kabupaten Pulau Taliabu',
        'Kota Ternate',
        'Kota Tidore Kepulauan',
      ],
      'Papua': [
        'Kabupaten Asmat',
        'Kabupaten Biak Numfor',
        'Kabupaten Boven Digoel',
        'Kabupaten Deiyai',
        'Kabupaten Dogiyai',
        'Kabupaten Intan Jaya',
        'Kabupaten Jayapura',
        'Kabupaten Jayawijaya',
        'Kabupaten Keerom',
        'Kabupaten Kepulauan Yapen',
        'Kabupaten Lanny Jaya',
        'Kabupaten Mamberamo Raya',
        'Kabupaten Mamberamo Tengah',
        'Kabupaten Mappi',
        'Kabupaten Merauke',
        'Kabupaten Mimika',
        'Kabupaten Nabire',
        'Kabupaten Nduga',
        'Kabupaten Paniai',
        'Kabupaten Pegunungan Bintang',
        'Kabupaten Puncak',
        'Kabupaten Puncak Jaya',
        'Kabupaten Sarmi',
        'Kabupaten Supiori',
        'Kabupaten Tolikara',
        'Kabupaten Waropen',
        'Kabupaten Yahukimo',
        'Kabupaten Yalimo',
        'Kota Jayapura',
      ],
      'Papua Barat': [
        'Kabupaten Fakfak',
        'Kabupaten Kaimana',
        'Kabupaten Manokwari',
        'Kabupaten Manokwari Selatan',
        'Kabupaten Maybrat',
        'Kabupaten Pegunungan Arfak',
        'Kabupaten Raja Ampat',
        'Kabupaten Sorong',
        'Kabupaten Sorong Selatan',
        'Kabupaten Tambrauw',
        'Kabupaten Teluk Bintuni',
        'Kabupaten Teluk Wondama',
      ],
    }
    $(document).ready(function() {

      $( "#province" ).change(function() {
          $('#city option').remove();
          if($( this ).val())
          {
            for(let i =0; i < province_city[$( this ).val()].length; i++ ){
              $('#city').append(`<option value="${province_city[$( this ).val()][i]}">
                                            ${province_city[$( this ).val()][i]}
                                      </option>`);
            }
          }

      });

      function setProvince(  )
      {
        for (const [key, value] of Object.entries(province_city)) {
          $('#province').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
        }
        if( $("#province_1").val() )
        {
          $(`#province option[value='${$("#province_1").val()}']`).attr('selected','selected');
          $("#province").change();

          $(`#city option[value='${$("#city_1").val()}']`).attr('selected','selected');
        }
        
      }
      setProvince();
    });
</script>