<?php

namespace App\Http\Controllers;

use App\CustomHelpers;
use App\Models\Campaign;
use App\Models\VRekapitulasiPendanaan;
use Illuminate\Http\Request;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Exception;

class VRekapitulasiPendanaanController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['list', 'excel']]);
        $this->middleware('permission:list-rekapitulasi', ['only' => ['list', 'excel']]);
    }

    public function list(Request $request, $campaign_id)
    {
        $rekap = VRekapitulasiPendanaan::where('campaign_id', $campaign_id)->orderBy('created_at', 'DESC')->paginate()->toArray();

        $campaign = Campaign::where('id', $campaign_id)->first();
        if (!$campaign) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        $campaign['rekapitulasi_pendanaan'] = $rekap;

        return $this->writeResponseData($campaign);
    }

    public function excel(Request $request, $campaign_id)
    {
        try {
            $rekap = VRekapitulasiPendanaan::where('campaign_id', $campaign_id)->orderBy('created_at', 'DESC')->get()->toArray();

            $campaign = Campaign::where('id', $campaign_id)->first();

            if (!$campaign) {
                return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
            }

            $array_data = [];

            // // title
            $array_data[] = WriterEntityFactory::createRow([WriterEntityFactory::createCell($campaign->nama)]);
            $array_data[] = WriterEntityFactory::createRow([WriterEntityFactory::createCell('')]);
            $array_data[] = WriterEntityFactory::createRow([
                WriterEntityFactory::createCell('Income'),
                WriterEntityFactory::createCell($campaign['sum_total_income']),
            ]);
            $array_data[] = WriterEntityFactory::createRow([
                WriterEntityFactory::createCell('Outcome'),
                WriterEntityFactory::createCell($campaign['sum_total_outcome']),
            ]);
            $array_data[] = WriterEntityFactory::createRow([
                WriterEntityFactory::createCell('Sisa'),
                WriterEntityFactory::createCell(($campaign['sum_total_income'] - $campaign['sum_total_outcome'])),
            ]);
            $array_data[] = WriterEntityFactory::createRow([WriterEntityFactory::createCell('')]);

            // header
            $array_data[] = WriterEntityFactory::createRow([
                WriterEntityFactory::createCell('Tanggal'),
                WriterEntityFactory::createCell('Jenis'),
                WriterEntityFactory::createCell('Nominal'),
                WriterEntityFactory::createCell('Sumber Dana'),
            ]);

            $jmlrow = 3;
            foreach ($rekap as $key => $r) {
                $array_data[] = WriterEntityFactory::createRow([
                    WriterEntityFactory::createCell(date('Y-m-d H:i:s', strtotime($r['created_at']))),
                    WriterEntityFactory::createCell($r['type']),
                    WriterEntityFactory::createCell($r['nominal']),
                    WriterEntityFactory::createCell($r['sumber_dana']),
                ]);

                $jmlrow++;
            }

            $fileName = 'rekapitulasi-pendanaan-' . CustomHelpers::slugify($campaign['nama'], '-') . date('Ymd-His') . '.xlsx';
            $writer = WriterEntityFactory::createXLSXWriter();

            $writer->openToBrowser($fileName);
            $writer->addRows($array_data);
            $writer->close();
        } catch (Exception $e) {
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }
}
