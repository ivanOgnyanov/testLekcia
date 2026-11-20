<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Контролер с едно действие (__invoke) - лекция 5, слайд 14.
 *
 * Експортът не е от 7-те ресурсни метода, затова е в отделен клас.
 */
class ExportMembersController extends Controller
{
    /**
     * Download all members as a CSV file.
     */
    public function __invoke(): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['id', 'name', 'email']);

            foreach (Member::orderBy('id')->lazy() as $member) {
                fputcsv($file, [$member->id, $member->name, $member->email]);
            }

            fclose($file);
        }, 'members.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
