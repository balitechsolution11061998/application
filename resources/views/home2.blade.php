<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="row">


        <!-- Dashboard Cards -->
        <div class="container mt-4">
            <div class="row">
                @can('siswa-show')
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-user-graduate"></i> Jumlah Siswa</h2>
                                    <div id="spinner-student" style="display: none;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-users icon-animate" style="font-size: 48px; color: #f39c12;"></i>
                                        <span class="chart-number custom-font" id="student-content">{{ $siswa }}</span>
                                    </div>
                                    <a href="/students" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-user-graduate"></i> View Students
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-chalkboard-teacher"></i> Jumlah Kelas</h2>
                                    <div id="spinner-kelas" style="display: none;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-chalkboard icon-animate" style="font-size: 48px; color: #007bff;"></i>
                                        <span class="chart-number custom-font" id="kelas-content">{{ $kelas }}</span>
                                    </div>
                                    <a href="/classes" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-chalkboard-teacher"></i> View Classes
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-book"></i> Mata Pelajaran</h2>
                                    <div id="spinner-mata-pelajaran" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-book-open icon-animate" style="font-size: 48px; color: #28a745;"></i>
                                        <span class="chart-number custom-font" id="mata-pelajaran-content">{{ $mapel }}</span>
                                    </div>
                                    <a href="/subjects" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-book"></i> View Subjects
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-user"></i> User Registrations</h2>
                                    <div id="spinner-user" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-user-plus icon-animate" style="font-size: 48px; color: #17a2b8;"></i>
                                        <span class="chart-number custom-font" id="user-content">{{ $user }}</span>
                                    </div>
                                    <a href="/users" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-user"></i> View Users
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-chalkboard-teacher"></i> Guru</h2>
                                    <div id="spinner-guru" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-chalkboard-teacher icon-animate" style="font-size: 48px; color: #e83e8c;"></i>
                                        <span class="chart-number custom-font" id="guru-content">{{ $guru }}</span>
                                    </div>
                                    <a href="/teachers" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-chalkboard-teacher"></i> View Teachers
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <div class="card equal-height">
                                    <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Jadwal</h2>
                                    <div id="spinner-jadwal" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="chart-container text-center">
                                        <i class="fas fa-calendar-alt icon-animate" style="font-size: 48px; color: #ffc107;"></i>
                                        <span class="chart-number custom-font" id="jadwal-content">{{ $jadwal }}</span>
                                    </div>
                                    <a href="/schedules" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-calendar-alt"></i> View Schedules
                                    </a>
                                </div>
                            </div>
                        </div>


                        <!-- Additional Details Section -->

                    </div>
                @endcan
            </div>
        </div>

        <div class="col-md-12" id="load_content">
            <div class="card card-primary">
              <div class="card-body">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Jam Pelajaran</th>
                          <th>Mata Pelajaran</th>
                          <th>Kelas</th>
                          <th>Ruang Kelas</th>
                          <th>Ket.</th>
                        </tr>
                      </thead>
                      <tbody id="data-jadwal">
                          @php
                            $hari = date('w');
                            $jam = date('H:i');
                          @endphp
                          @if ( $jadwalGuru->count() > 0 )
                            @if (
                              $hari == '1' && $jam >= '09:45' && $jam <= '10:15' ||
                              $hari == '1' && $jam >= '12:30' && $jam <= '13:15' ||
                              $hari == '2' && $jam >= '09:15' && $jam <= '09:45' ||
                              $hari == '2' && $jam >= '12:00' && $jam <= '13:00' ||
                              $hari == '3' && $jam >= '09:15' && $jam <= '09:45' ||
                              $hari == '3' && $jam >= '12:00' && $jam <= '13:00' ||
                              $hari == '4' && $jam >= '09:15' && $jam <= '09:45' ||
                              $hari == '4' && $jam >= '12:00' && $jam <= '13:00' ||
                              $hari == '5' && $jam >= '09:00' && $jam <= '09:15' ||
                              $hari == '5' && $jam >= '11:15' && $jam <= '13:00'
                            )
                            <tr>
                              <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat!</td>
                            </tr>
                            @else
                            @foreach ($jadwal as $data)
                              <tr>
                                <td>{{ $data->jam_mulai.' - '.$data->jam_selesai }}</td>
                                <td>
                                    <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                                    <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                                </td>
                                <td>{{ $data->kelas->nama_kelas }}</td>
                                <td>{{ $data->ruang->nama_ruang }}</td>
                                <td>
                                  @if ($data->absen($data->guru_id))
                                    <div style="margin-left:20px;width:30px;height:30px;background:#{{ $data->absen($data->guru_id) }}"></div>
                                  @elseif (date('H:i:s') >= '09:00:00')
                                    <div style="margin-left:20px;width:30px;height:30px;background:#F00"></div>
                                  @else
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                        @endif
                        @elseif ($jam <= '07:00')
                          <tr>
                            <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Akan Segera Dimulai!</td>
                          </tr>
                      @elseif (
                        $hari == '1' && $jam >= '16:15' ||
                        $hari == '2' && $jam >= '16:00' ||
                        $hari == '3' && $jam >= '16:00' ||
                        $hari == '4' && $jam >= '16:00' ||
                        $hari == '5' && $jam >= '15:40'
                      )
                        <tr>
                          <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Sudah Selesai!</td>
                        </tr>
                      @elseif ($hari == '0' || $hari == '6')
                        <tr>
                          <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Sekalah Libur!</td>
                        </tr>
                      @elseif($hari == '1' && $jam >= '07:00' && $jam <= '07:30')
                        <tr>
                          <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Upacara Bendera!</td>
                        </tr>
                      @else
                        <tr>
                          <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Tidak Ada Data Jadwal!</td>
                        </tr>
                      @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-warning" style="min-height: 385px;">
              <div class="card-header">
                <h3 class="card-title" style="color: white;">
                  Pengumuman
                </h3>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  {!! $pengumuman->isi !!}
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  Keterangan :
                </h3>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <table class="table" style="margin-top: -21px; margin-bottom: -10px;">
                    @foreach ($kehadiran as $data)
                      <tr>
                        <td>
                          <div style="width:30px;height:30px;background:#{{ $data->color }}"></div>
                        </td>
                        <td>:</td>
                        <td>{{ $data->ket }}</td>
                      </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
          </div>

        <div class="col-md-12">
            <div class="card shadow-sm border-light">
                <div class="card-header">
                    <h2 class="section-title mb-0"><i class="fas fa-info-circle"></i> History Ujian</h2>
                </div>
                <div class="card-body">
                    <div id="spinner-history-detail" class="text-center mb-3" style="display: none;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Rombel - Kelas</th>
                                    <th>Jumlah Benar</th>
                                    <th>Jumlah Salah</th>
                                    <th>Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="historyUjian-table-body">
                                <!-- Dynamic Data Here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Additional CSS -->
    <div class="row d-flex align-items-stretch">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">Data Guru</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $guru }}
                            </span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <!-- ApexCharts container -->
                                    <div id="pieChartGuru"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">Data Siswa</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $siswa }}
                            </span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="pieChartSiswa" class="chart-responsive"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">Kelas / Paket Keahlian</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $kelas }}
                            </span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="pieChartPaket" class="chart-responsive"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('modals.modal') --}}
    @include('modals.chat')

    @push('scripts')
        <script src="{{ asset('js/home2.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                var options = {
                    series: [{{ $gurulk }}, {{ $gurupr }}],
                    chart: {
                        type: 'pie',
                        height: 250,
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        }
                    },
                    labels: ['Laki-laki', 'Perempuan'],
                    colors: ['#007BFF', '#DC3545'],
                    legend: {
                        position: 'right',
                        offsetY: 0,
                        height: 230,
                        fontSize: '14px',
                        fontFamily: 'Montserrat, sans-serif',
                        labels: {
                            colors: ['#333'],
                            useSeriesColors: false
                        },
                        markers: {
                            width: 12,
                            height: 12,
                            strokeWidth: 0,
                            strokeColor: '#fff',
                            fillColors: undefined,
                            radius: 12,
                            customHTML: undefined,
                            onClick: undefined,
                            offsetX: 0,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 5
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.globals.series[opts.seriesIndex] + '%';
                        },
                        dropShadow: {
                            enabled: true,
                            top: 1,
                            left: 1,
                            blur: 2,
                            opacity: 0.5
                        },
                        style: {
                            fontSize: '16px',
                            colors: ['#333']
                        }
                    },
                    tooltip: {
                        enabled: true,
                        theme: 'dark',
                        y: {
                            formatter: function(val) {
                                return val + " Guru";
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pieChartGuru"), options);
                chart.render();


                var options = {
                    series: [{{ $siswalk }}, {{ $siswapr }}],
                    chart: {
                        type: 'donut',
                        height: 300,
                    },
                    labels: ['Laki-laki', 'Perempuan'],
                    colors: ['#007BFF', '#DC3545'],
                    legend: {
                        position: 'right',
                        offsetY: 0,
                        height: 230,
                        labels: {
                            colors: '#333',
                            fontSize: '14px',
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '14px',
                            colors: ['#333']
                        },
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '16px',
                                        fontFamily: 'Helvetica, Arial, sans-serif',
                                        color: '#333',
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        fontFamily: 'Helvetica, Arial, sans-serif',
                                        color: '#333',
                                        offsetY: 10
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pieChartSiswa"), options);
                chart.render();

                var options = {
                    series: [{{ $bkp }}, {{ $dpib }}, {{ $ei }}, {{ $oi }},
                        {{ $tbsm }}, {{ $rpl }}, {{ $tpm }}, {{ $las }}
                    ],
                    chart: {
                        type: 'donut',
                        height: 300,
                    },
                    labels: [
                        'Bisnis kontruksi dan Properti',
                        'Desain Permodelan dan Informasi Bangunan',
                        'Elektronika Industri',
                        'Otomasi Industri',
                        'Teknik dan Bisnis Sepeda Motor',
                        'Rekayasa Perangkat Lunak',
                        'Teknik Pemesinan',
                        'Teknik Pengelasan'
                    ],
                    colors: ['#d4c148', '#ba6906', '#ff990a', '#00a352', '#2cabe6', '#999999', '#0b2e75',
                        '#7980f7'
                    ],
                    legend: {
                        position: 'right',
                        offsetY: 0,
                        height: 230,
                        labels: {
                            colors: '#333',
                            fontSize: '14px',
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '14px',
                            colors: ['#333']
                        },
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '16px',
                                        fontFamily: 'Helvetica, Arial, sans-serif',
                                        color: '#333',
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        fontFamily: 'Helvetica, Arial, sans-serif',
                                        color: '#333',
                                        offsetY: 10
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pieChartPaket"), options);
                chart.render();

                fetchHistoryUjian();
                fetchStudentData();
            })

            function fetchHistoryUjian() {
                $('#spinner-history-detail').show(); // Show spinner before loading data

                $.ajax({
                    url: '/ujian/fetchHistory',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let tableBody = $('#historyUjian-table-body');
                        tableBody.empty(); // Clear any existing data

                        if (data.length === 0) {
                            tableBody.append(`
                    <tr>
                        <td colspan="5" class="text-center">Data not found</td>
                    </tr>
                `);
                        } else {
                            // Iterate over the data and append rows to the table
                            data.forEach(function(row) {
                                tableBody.append(`
                        <tr>
                            <td>${row.siswa_name}</td>
                            <td>${row.rombel_name} - ${row.kelas_name}</td>
                            <td>${row.jumlah_benar}</td>
                            <td>${row.jumlah_salah}</td>
                            <td>${row.total_nilai}</td>
                        </tr>
                    `);
                            });
                        }

                        $('#spinner-history-detail').hide(); // Hide spinner after data is loaded
                    },
                    error: function() {
                        $('#spinner-history-detail').hide(); // Hide spinner on error
                        alert('Failed to load data');
                    }
                });
            }
        </script>
    @endpush
</x-default-layout>
