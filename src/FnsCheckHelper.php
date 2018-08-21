<?php

namespace FnsCheck;

/**
 * Class FnsCheckHelper
 *
 * Класс-хелпер для работы с электронными чеками.
 *
 * @package FnsCheck
 * @author kosov <akosov@yandex.ru>
 */
class FnsCheckHelper
{
    /**
     * Конвертирует данные, полученные из QR-кода, в массив данных для запроса к API.
     *
     * @param string $qrCodeString Данные QR-кода
     *
     * @return array Массив данных для запроса к API
     */
    public static function fromQRCode($qrCodeString)
    {
        $paramsMap = [
            't'  => 'date',
            's'  => 'sum',
            'fn' => 'fiscalNumber',
            'i'  => 'fiscalDocument',
            'fp' => 'fiscalSign',
            'n'  => 'operation',
        ];

        $normalizedParams = array_fill_keys(array_values($paramsMap), null);

        parse_str($qrCodeString, $qrCodeParams);

        foreach ($paramsMap as $qrField => $normalizedField) {
            if (array_key_exists($qrField, $qrCodeParams)) {
                $normalizedParams[$normalizedField] = $qrCodeParams[$qrField];
            }
        }

        $normalizedParams['sum'] = self::rub2Kopeck($normalizedParams['sum']);

        return $normalizedParams;
    }

    /**
     * Конвертирует рубли в копейки.
     *
     * @param float|int $sum Сумма в рублях
     *
     * @return int Сумма в копейках
     */
    private static function rub2Kopeck($sum)
    {
        return $sum * 100;
    }
}
