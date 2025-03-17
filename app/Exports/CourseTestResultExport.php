<?php

namespace App\Exports;

use App\Models\CourseTestResult;
use App\Models\User;
use App\Models\CoursePart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CourseTestResultExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return CourseTestResult::get();
    }

    public function headings(): array
    {
        return ["ФИО", "ИИН", "Дата начала", "Дата завершения","Номер сертификата","Количество часов"];
    }

    public function map($item): array
    {
        $user = User::where('id', $item->user_id)->first();
        $part = CoursePart::where('id', $item->course_part_id)->first();

        return [
            $user->full_name,
            $user->iin,
            $item->created_at,
            $item->updated_at,
            $item->rand,
            $part->duration_hours
        ];
    }
}
