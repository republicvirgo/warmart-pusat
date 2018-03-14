<?php

use App\SettingJasaPengiriman;
use Illuminate\Database\Seeder;

class SettingJasaPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting                          = new SettingJasaPengiriman();
        $setting->jasa_pengiriman         = "JNE";
        $setting->tampil_jasa_pengiriman  = 1;
        $setting->default_jasa_pengiriman = 1;
        $setting->warung_id               = 1;
        $setting->logo_jasa               = "jne.png";
        $setting->save();

        $setting                          = new SettingJasaPengiriman();
        $setting->jasa_pengiriman         = "TIKI";
        $setting->tampil_jasa_pengiriman  = 1;
        $setting->default_jasa_pengiriman = 0;
        $setting->warung_id               = 1;
        $setting->logo_jasa               = "tiki.png";
        $setting->save();

        $setting                          = new SettingJasaPengiriman();
        $setting->jasa_pengiriman         = "POS";
        $setting->tampil_jasa_pengiriman  = 1;
        $setting->default_jasa_pengiriman = 0;
        $setting->warung_id               = 1;
        $setting->logo_jasa               = "pos-indo.png";
        $setting->save();

        $setting                          = new SettingJasaPengiriman();
        $setting->jasa_pengiriman         = "COD";
        $setting->tampil_jasa_pengiriman  = 1;
        $setting->default_jasa_pengiriman = 0;
        $setting->warung_id               = 1;
        $setting->logo_jasa               = "COD.png";
        $setting->save();

        $setting                          = new SettingJasaPengiriman();
        $setting->jasa_pengiriman         = "OJEK";
        $setting->tampil_jasa_pengiriman  = 1;
        $setting->default_jasa_pengiriman = 0;
        $setting->warung_id               = 1;
        $setting->logo_jasa               = "COD.png";
        $setting->save();
    }
}