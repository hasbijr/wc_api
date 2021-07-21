<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\CampaignAgent;
use App\Models\CampaignPhoto;
use App\Models\CampaignQrCode;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->campaign1();
        $this->campaign2();
        $this->campaign3();
    }

    private function campaign3()
    {
        /**
         * seed campaign
         */
        $campaign = new Campaign();
        $campaign->nama = 'Jastip Menempuh Jarak 50 km Demi Kesembuhan Anak';
        $campaign->tanggal_mulai = '2021-05-06';
        $campaign->tanggal_selesai = null;
        $campaign->deskripsi = '“Pekerjaan apapun saya lakoni agar jantung buah hati saya tetap berdenyut kencang hingga nanti..”
        ***
        Sahabat, familiar dengan kata “jastip” atau bahkan ada yang baru pertama kali mendengarnya? Jastip adalah singkatan dari jasa titip dan menjadi mata pencaharian populer di era digital ini.
        Jastip adalah layanan yang menawarkan bantuan kepada orang-orang yang ingin membeli sesuatu tetapi tidak dapat pergi ke tempat yang diinginkan, karena berbagai alasan.

        Singkatnya, bila kita tinggal di kota A dan sedang rindu dengan jajanan khas kota B. Seorang kurir jastip akan membelikannya untuk kita, tanpa harus kita keluar kota.';
        $campaign->is_publish = 1;
        $campaign->save();

        $campaignfoto = new CampaignPhoto();
        $campaignfoto->nama_file = 'wecare-default-campaign-foto-11111111.jpg';
        $campaignfoto->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . 'wecare-default-campaign-foto-11111111.jpg';
        $campaignfoto->ekstensi = 'jpg';
        $campaignfoto->ukuran = '117.000';
        $campaign->campaignPhoto()->save($campaignfoto);

        $campaignqr = new CampaignQrCode();
        $campaignqr->nama_linkaja = 'testlinkaja22';
        $campaignqr->nama_file = 'qr-code-default.png';
        $campaignqr->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'qr_codes' . DIRECTORY_SEPARATOR . 'qr-code-default.png';
        $campaignqr->ekstensi = 'png';
        $campaignqr->ukuran = '5040';
        $campaign->campaignQrCode()->save($campaignqr);

        for ($i = 2; $i < 7; $i++) {
            $campaignagent = new CampaignAgent();
            $campaignagent->user_id = $i;
            $campaign->campaignAgents()->save($campaignagent);
        }
    }

    private function campaign2()
    {
        /**
         * seed campaign
         */
        $campaign = new Campaign();
        $campaign->nama = 'Amal Jariyah - Madrasah Kami Belum Juga Selesai';
        $campaign->tanggal_mulai = '2021-05-06';
        $campaign->tanggal_selesai = null;
        $campaign->deskripsi = 'Bismillahirohmanirohim

        berbuat baiklah selagi kita masih di beri kesempatan untuk bisa memberi dan berbagi karena orang yang sudah wafat mereka ingin kembali lagi hanya untuk ingin berbagi dan beribadah kepada ALLAH SWT.

        Assalmualaikum #orang baik

        Alhamdulilah wasyukirillah kita semua dalam keadaan sehat hingga bisa berbagi kebaikan di jalan yang allah ridhoi.

        Perkenalkan nama saya rose rosmawati yang menjadi salah satu wakil panitia pembangunan atau yang ditunjuk sama masyarakat sekitar pesantren madrasah untuk mencai dana bantuan lewat online /internet karena susahnya mencari bantuan di sekitara lingkungan kami';
        $campaign->is_publish = 1;
        $campaign->save();

        $campaignfoto = new CampaignPhoto();
        $campaignfoto->nama_file = 'wecare-default-campaign-foto-000000000.jpg';
        $campaignfoto->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . 'wecare-default-campaign-foto-000000000.jpg';
        $campaignfoto->ekstensi = 'jpg';
        $campaignfoto->ukuran = '117.000';
        $campaign->campaignPhoto()->save($campaignfoto);

        $campaignqr = new CampaignQrCode();
        $campaignqr->nama_linkaja = 'testlinkaja11';
        $campaignqr->nama_file = 'qr-code-default.png';
        $campaignqr->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'qr_codes' . DIRECTORY_SEPARATOR . 'qr-code-default.png';
        $campaignqr->ekstensi = 'png';
        $campaignqr->ukuran = '5040';
        $campaign->campaignQrCode()->save($campaignqr);

        for ($i = 8; $i < 12; $i++) {
            $campaignagent = new CampaignAgent();
            $campaignagent->user_id = $i;
            $campaign->campaignAgents()->save($campaignagent);
        }
    }

    private function campaign1()
    {
        /**
         * seed campaign
         */
        $campaign = new Campaign();
        $campaign->id = 7;
        $campaign->nama = '#Ramadhan WeCare Buka Puasa Gratis';
        $campaign->tanggal_mulai = '2021-05-01';
        $campaign->tanggal_selesai = null;
        $campaign->deskripsi = 'Assalamualaikum warrahmatullahi wabarakaatuh

        Bapak/Ibu/Rekan FU NITS yang baik dan semoga senantiasa dalam keadaan sehat walafiat..

        Dengan ini kami infokan bahwa telah dicanangkan program Sahabat We Care FU NITS dimana Program ini merupakan bentuk kepedulian jajaran NITS terhadap masyarakat di sekitar melalui partisipasi karyawan NITS maupun donatur lainnya.

        Adapun scope Program Sahabat WeCare ini fokus pada penyaluran bantuan berupa Berbagi Makanan Gratis yang disalurkan kepada masyarakat khususnya yang terkena dampak Covid-19.

        Program ini diawali dengan Program #Ramadhan WeCare, yaitu penyaluran donasi melalui penyediaan makanan setiap hari untuk Berbuka Puasa Gratis kepada masyarakat disekitar selama bulan suci Ramadhan.

        Kegiatan Amal ini, akan dilakukan secara rutin dan berkelanjutan setelah Ramadhan berakhir dengan memberikan sarapan gratis setiap hari kepada yg membutuhkan.  Panitia telah membentuk Tim Sahabat We Care (Subdit/UBIS) yang akan mengelola kegiatan amal ini.

        Untuk itu kami mengajak Bapak/Ibu/Rekan untuk bergabung dalam kegiatan #Ramadhan WeCare ini, dengan cara ikut berdonasi yang dapat disalurkan ke rekening diatas atau Link Aja, penggalangan dana paling lambat tanggal 6 Mei 2021

        Demikian kami infokan...kiranya dapat bermanfaat bagi orang2 yang membutuhkan.

        Terima kasih

        #Sedekahituindah#
        #salamberbagi#';
        $campaign->is_publish = 1;
        $campaign->save();

        $campaignfoto = new CampaignPhoto();
        $campaignfoto->nama_file = 'wecare-default-campaign-foto-test.jpg';
        $campaignfoto->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . 'wecare-default-campaign-foto-test.jpg';
        $campaignfoto->ekstensi = 'jpg';
        $campaignfoto->ukuran = '117.000';
        $campaign->campaignPhoto()->save($campaignfoto);

        $campaignqr = new CampaignQrCode();
        $campaignqr->nama_linkaja = 'testlinkaja';
        $campaignqr->nama_file = 'qr-code-default.png';
        $campaignqr->path = 'campaign_assets' . DIRECTORY_SEPARATOR . 'qr_codes' . DIRECTORY_SEPARATOR . 'qr-code-default.png';
        $campaignqr->ekstensi = 'png';
        $campaignqr->ukuran = '5040';
        $campaign->campaignQrCode()->save($campaignqr);

        for ($i = 13; $i < 17; $i++) {
            $campaignagent = new CampaignAgent();
            $campaignagent->user_id = $i;
            $campaign->campaignAgents()->save($campaignagent);
        }
    }
}
