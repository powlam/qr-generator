<?php

use App\Http\Requests\QrGenerateRequest;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function (QrGenerateRequest $request) {
    // QrCode docs: https://github.com/SimpleSoftwareIO/simple-qrcode/tree/develop/docs/en
    $qrCode = QrCode::size(300)->margin(1);

    if ($request->filled('qrColor')) {
        $color = $request->validated('qrColor');
        // how to convert color string to RGB integer values: https://www.php.net/manual/en/function.hexdec.php#99478
        $colorVal = hexdec($color);

        $qrCode->color(
            red: 0xFF & ($colorVal >> 0x10),
            green: 0xFF & ($colorVal >> 0x8),
            blue: 0xFF & $colorVal
        );
    }

    if ($request->filled('qrType')) {
        $style = $request->validated('qrType');
        $qrCode->style($style);
    }

    $link = $request->validated('linkToConvert');
    $qr = $qrCode->generate($link);

    return view('welcome', compact('qr', 'link', 'color', 'style'));
});
