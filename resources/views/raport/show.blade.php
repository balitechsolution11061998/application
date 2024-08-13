<x-default-layout>
    @section('title')
        Kelas
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('kelas') }}
    @endsection
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Show Rapot</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" style="margin-top: -10px;">
                            <tr>
                                <td>No Induk Siswa</td>
                                <td>:</td>
                                <td>{{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>Nama Siswa</td>
                                <td>:</td>
                                <td>{{ $siswa->nama }}</td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td>{{ $kelas->name }}</td>
                            </tr>
                            <tr>
                                <td>Wali Kelas</td>
                                <td>:</td>
                                <td>{{ $kelas->guru->nama_guru }}</td>
                            </tr>
                            @php
                                $bulan = date('m');
                                $tahun = date('Y');
                            @endphp
                            <tr>
                                <td>Semester</td>
                                <td>:</td>
                                <td>
                                    @if ($bulan > 6)
                                        {{ 'Semester Ganjil' }}
                                    @else
                                        {{ 'Semester Genap' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Tahun Pelajaran</td>
                                <td>:</td>
                                <td>
                                    @if ($bulan > 6)
                                        {{ $tahun }}/{{ $tahun + 1 }}
                                    @else
                                        {{ $tahun - 1 }}/{{ $tahun }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                            <thead>
                                <tr>
                                    <th class="ctr" rowspan="2">No.</th>
                                    <th rowspan="2">Mata Pelajaran</th>
                                    <th class="ctr" colspan="3">Pengetahuan</th>
                                    <th class="ctr" colspan="3">Keterampilan</th>
                                </tr>
                                <tr>
                                    <th class="ctr">Nilai</th>
                                    <th class="ctr">Predikat</th>
                                    <th class="ctr">Deskripsi</th>
                                    <th class="ctr">Nilai</th>
                                    <th class="ctr">Predikat</th>
                                    <th class="ctr">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapel as $val => $data)
                                    <?php $data = $data[0] ?? null; ?>
                                    @if ($data && $data->mapel)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->mapel->nama_mapel }}</td>
                                            @php
                                                $array = ['mapel' => $val, 'siswa' => $siswa->id];
                                                $jsonData = json_encode($array);
                                                $cekRapot = $data->cekRapot($jsonData) ?? [
                                                    'p_nilai' => '-',
                                                    'p_predikat' => '-',
                                                    'p_deskripsi' => '-',
                                                    'k_nilai' => '-',
                                                    'k_predikat' => '-',
                                                    'k_deskripsi' => '-',
                                                ];
                                            @endphp
                                            <td class="ctr">{{ $cekRapot['p_nilai'] }}</td>
                                            <td class="ctr">{{ $cekRapot['p_predikat'] }}</td>
                                            <td class="ctr">{{ $cekRapot['p_deskripsi'] }}</td>
                                            <td class="ctr">{{ $cekRapot['k_nilai'] }}</td>
                                            <td class="ctr">{{ $cekRapot['k_predikat'] }}</td>
                                            <td class="ctr">{{ $cekRapot['k_deskripsi'] }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">Data is not available</td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-default-layout>
