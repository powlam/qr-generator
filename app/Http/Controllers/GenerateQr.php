<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrGenerateRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQr extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(QrGenerateRequest $request)
    {
        // QrCode docs: https://github.com/SimpleSoftwareIO/simple-qrcode/tree/develop/docs/en
        $qrCode = QrCode::size(300)->margin(1);

        if ($request->filled('qrColor')) {
            $rgb = $this->extractColorComponents($request->validated('qrColor'));
            $qrCode->color($rgb['red'], $rgb['green'], $rgb['blue']);
        }

        if ($request->filled('qrType')) {
            $qrCode->style($request->validated('qrType'));
        }

        if ($isPNG = self::canGeneratePNG()) {
            $qrCode->format('png');
        }

        $qr = $qrCode->generate($request->validated('linkToConvert'));

        return view('welcome', [
            'qr' => $qr,
            'png' => $isPNG,
            'link' => $request->validated('linkToConvert'),
            'color' => $request->validated('qrColor'),
            'style' => $request->validated('qrType'),
        ]);
    }

    protected function extractColorComponents(string $colorHex): array
    {
        // how to convert color string to RGB integer values: https://www.php.net/manual/en/function.hexdec.php#99478
        $colorVal = hexdec($colorHex);

        return [
            'red' => 0xFF & ($colorVal >> 0x10),
            'green' => 0xFF & ($colorVal >> 0x8),
            'blue' => 0xFF & $colorVal,
        ];
    }

    public static function canGeneratePNG(): bool
    {
        // You must install the imagick PHP extension if you plan on using the png image format: https://mlocati.github.io/articles/php-windows-imagick.html
        return extension_loaded('imagick');
    }
}
