<?php

namespace App\Http\Controllers;

use App\CustomHelpers;
use App\Models\Campaign;
use App\Models\Income;
use App\Models\IncomeDetail;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['only' => ['create', 'view', 'excel']]);
        // $this->middleware('permission:create-income', ['only' => ['create']]);
        // $this->middleware('permission:view-income', ['only' => ['view', 'excel']]);
    }

    public function create(Request $request, $campaign_id)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx',
            'sumber_dana' => 'required',
        ]);

        // upload file
        $fileuploaded = $request->file('file');
        $filename = pathinfo($fileuploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $fileext = $fileuploaded->getClientOriginalExtension();
        $filesize = $fileuploaded->getSize();
        $filename = $filename . '-' . uniqid() . '-' . time() . '.' . $fileext;
        $filepath = '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'incomes';
        $fileuploaded->move($filepath, $filename);

        if (!file_exists($filepath . DIRECTORY_SEPARATOR . $filename)) {
            throw new Exception('error: upload photo', 500);
        }

        // search campaign
        $campaign = Campaign::where('id', $campaign_id)->first();
        if (!$campaign) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        DB::beginTransaction();
        try {
            $income = new Income();
            $income->sumber_dana = $request->sumber_dana;
            $income->nama_file = $filename;
            $income->path = $filepath . DIRECTORY_SEPARATOR . $filename;
            $income->ukuran = $filesize;
            $campaign->Incomes()->save($income);

            $incomeDetails = [];

            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open($filepath . DIRECTORY_SEPARATOR . $filename);
            $worksheet = $reader->getSheetIterator()[0];

            foreach ($worksheet->toArray() as $key => $row) {
                if ($key == 0) {
                    continue;
                }

                $incomeDetails[] = [
                    'income_id' => $income->id,
                    'no_referensi' => $row[0],
                    'handphone' => $row[1],
                    'nominal' => $row[2],
                    'keterangan' => $row[3],
                    'tanggal_donasi' => date('Y-m-d H:i:s', strtotime($row[4])),
                    'nama' => $row[5],
                ];
            }

            IncomeDetail::insert($incomeDetails);

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $income, true);
        } catch (QueryException $e) {
            DB::rollBack();
            if (file_exists($filepath . DIRECTORY_SEPARATOR . $filename)) {
                unlink($filepath . DIRECTORY_SEPARATOR . $filename);
            }
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function view(Request $request, $income_id)
    {
        $income = Income::with(['campaign'])->where('id', $income_id)->first();

        if (!$income) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        $income_data = $income->toArray();

        $income_details = IncomeDetail::where('income_id', $income_id)
            ->select([
                'income_details.*',
                'contributors.nik'
            ])
            ->leftJoin('contributors', 'contributors.handphone', '=', 'income_details.handphone')
            ->get();

        $income_data['income_details'] = $income_details;

        return $this->writeResponseData($income_data);
    }

    public function excel(Request $request, $income_id)
    {
        $income = Income::with(['campaign'])->where('id', $income_id)->first();

        if (!$income) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        $income_details = IncomeDetail::where('income_id', $income_id)
            ->select([
                'income_details.*',
                'contributors.nik'
            ])
            ->leftJoin('contributors', 'contributors.handphone', '=', 'income_details.handphone')
            ->get();

        $array_data = [];

        // title
        $array_data[] = WriterEntityFactory::createRow([WriterEntityFactory::createCell($income->campaign->nama)]);
        $array_data[] = WriterEntityFactory::createRow([WriterEntityFactory::createCell('')]);

        // header
        $array_data[] = WriterEntityFactory::createRow([
            WriterEntityFactory::createCell('Tanggal'),
            WriterEntityFactory::createCell('No. Referensi'),
            WriterEntityFactory::createCell('NIK'),
            WriterEntityFactory::createCell('Nama'),
            WriterEntityFactory::createCell('Handphone'),
            WriterEntityFactory::createCell('Nominal'),
            WriterEntityFactory::createCell('Keterangan'),
        ]);

        $jmlrow = 3;
        foreach ($income_details as $key => $r) {
            $array_data[] = WriterEntityFactory::createRow([
                WriterEntityFactory::createCell(date('Y-m-d H:i:s', strtotime($r['tanggal_donasi']))),
                WriterEntityFactory::createCell($r['no_referensi']),
                WriterEntityFactory::createCell($r['nik']),
                WriterEntityFactory::createCell($r['nama']),
                WriterEntityFactory::createCell($r['handphone']),
                WriterEntityFactory::createCell($r['nominal']),
                WriterEntityFactory::createCell($r['keterangan']),
            ]);

            $jmlrow++;
        }

        $fileName = 'income-' . CustomHelpers::slugify($income->campaign->nama, '-') . date('Ymd-His') . '.xlsx';

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRows($array_data);
        $writer->close();
    }
}
