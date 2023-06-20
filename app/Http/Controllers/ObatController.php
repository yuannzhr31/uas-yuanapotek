<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Charts\ObatLineChart;

class ObatController extends Controller
{
    public function index()
    {   
        $title = "Data Obat";
        $obats = Obat::orderBy('id','asc')->get();
        return view('obats.index', compact(['obats' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Obat";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('obats.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required'
        ]);

        $obat = [
            'id_obat' => $request->id_obat,
            'golongan_obat' => $request->golongan_obat,
            'nama_obat' => $request->nama_obat,
            'khasiat' => $request->khasiat,
        ];
        if($result = Obat::create($obat)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'id_obat' => $request->id_obat,
                    'id_jadwal' => $request['id_jadwal'.$i],
                    'tempat_praktik' => $request['tempat_praktik'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('obats.index')->with('success','Obat has been created successfully.');
    }

    public function show(Obat $obat)
    {
        return view('obats.show',compact('Departement'));
    }

    public function edit(Obat $obat)
    {
        $title = "Edit Data Obat";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = Detail::where('no_obat', $obat->id_obat)->orderBy('id','asc')->get();
        return view('obats.edit',compact('obat' , 'title', 'managers', 'detail'));
    }

    public function update(Request $request, Obat $obat)
    {
        $obats = [
            'id_obat' => $request->id_obat,
            'golongan_obat' => $request->golongan_obat,
            'nama_obat' => $request->nama_obat,
            'khasiat' => $request->khasiat,
            // 'total' => $request->total,
        ];
        if ($obat->fill($obats)->save()){
            Detail::where('no_dok', $obat->id_obat)->delete();
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_dok' => $obat->id_obat,
                    'id_jadwal' => $request['id_jadwal'.$i],
                    'golongan_obat' => $request['golongan_obat'.$i],
                    'nama_obat' => $request['nama_obat'.$i],
                    'spesialisai' => $request['spesialisai'.$i],
                    'tempat_praktik' => $request['tempat_praktik'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('obats.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obats.index')->with('success','Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Obat";
        $obats = Obat::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('obats.pdf', compact(['obats', 'title']));
        return $pdf->stream('laporan-obats-pdf');
    }

    public function chartLine()
    {
        $api = url(route('obats.chartLineAjax'));
   
        $chart = new ObatLineChart;
        $chart->labels(['Ibu dan Anak', 'THT', 'Jantung', 'Mata', 'Kandungan', 'Kulit', 'Penyakit Dalam'])->load($api);
        $title = "Chart Ajax";
        return view('chart', compact('chart', 'title'));
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function chartLineAjax(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $obats = Obat::select(\DB::raw("COUNT(*) as count"))
                    ->where('nama_obat', 'LIKE', '%'.$year. '%')
                    ->groupBy(\DB::raw("khasiat"))
                    ->pluck('count');
  
        $chart = new ObatLineChart;
  
        $chart->dataset('Obat Spesialis Chart', 'line', $obats)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ]);
  
        return $chart->api();
    }

}
