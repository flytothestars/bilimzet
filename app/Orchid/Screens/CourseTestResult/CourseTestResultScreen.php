<?php

namespace App\Orchid\Screens\CourseTestResult;

use Orchid\Screen\Screen;
use App\Models\CourseTestResult;
use App\Models\User;
use App\Models\CoursePart;
use App\Models\Course;
use App\Models\CourseModule;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Group;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use setasign\Fpdi\Tcpdf\Fpdi;
use Orchid\Support\Facades\Toast;

class CourseTestResultScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'course_test_result_list' => CourseTestResult::orderBy('id', 'desc')->get()->map(function($result){
                $result->user = $result->user->full_name;
                $result->speciality = $result->coursePart->course->speciality->title;
                $result->course = $result->coursePart->course->title;
                $result->test = $result->coursePart->courseTest[0]->title ?? null;
                $result->date = $result->created_at;
                $result->result = $result->total_correct_question . '/' . $result->total_question;
                return $result;
            })
            
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Результаты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }
    protected $styleButton = 'border-radius: 5px;';

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('course_test_result_list',[
            TD::make('id', 'ID'),
            TD::make('user', 'Пользователь'),
            TD::make('speciality', 'Специализация'),
            TD::make('course', 'Курс'),
            TD::make('test', 'Тест'),
            TD::make('date', 'Дата прохождения'),
            TD::make('result', 'Результат'),
            TD::make('action', 'Действие')->render(function ($result) {
                return Group::make([
                    Button::make('Посмотреть')
                        ->method('show')
                        ->parameters([
                            'item' => $result->id
                        ])
                        ->type(Color::SUCCESS)
                        ->rawClick()
                        ->style($this->styleButton)
                        ->canSee($this->showCertificate($result)),
                    Button::make('Выдать')
                        ->method('issue')
                        ->parameters([
                            'item' => $result->id
                        ])
                        ->type(Color::WARNING)
                        ->style($this->styleButton)
                        ->canSee($this->issueCertificate($result)),
                    Button::make('Создать')
                        ->method('generate')
                        ->parameters([
                            'item' => $result->id
                        ])
                        ->type(Color::PRIMARY)
                        ->style($this->styleButton)
                        ->rawClick()
                        ->canSee($this->generateCerficateStatus($result)),
                    ]);
            })->width('200px'),
            ])
        ];
    }

    public function showCertificate(CourseTestResult $item): bool
    {
        // return $item->status_certificate === 2 ? true : false;
        return true;
    }

    public function issueCertificate(CourseTestResult $item): bool
    {
        return $item->status_certificate === 1 ? true : false;
    }

    public function generateCerficateStatus(CourseTestResult $item): bool
    {
        
        return $item->status_certificate === 0 ? true : false;
    }

    public function show(CourseTestResult $item)
    {
        $outputPath = storage_path('app/public/cert-'.auth()->user()->id.'-'.$item->id.'-'.$item->rand.'.pdf');
        return response()->download($outputPath);
    }

    public function issue(CourseTestResult $item)
    {
        $item->update([
            'status_certificate' => 2,
        ]);
        Toast::info('Сертификат выдан');
    }

    public function generate(CourseTestResult $item)
    {
        $user = User::find($item->user_id);
        $part = CoursePart::where('id', $item->course_part_id)->first();
        $modules = CourseModule::where('course_part_id', $item->course_part_id)->get();
        $course = Course::where('id', $part->course_id)->first();
        $reg_number = rand(000000, 999999);
        $date_day = date('d');
        $date_month = date('m');

        $templatePath = storage_path('app/templates/certificate.pdf');
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($templatePath);
        // dd($templatePath);
        
        // Page 1
        $templateId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($templateId);

        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

        $pdf->useTemplate($templateId);
        $pdf->SetFont('FreeSerif', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->SetXY(110, 93);
        $pdf->Write(0, $user->full_name); 
        $pdf->SetXY(40, 106.5);         
        $pdf->Write(0, $course->title);
        $pdf->SetXY(105, 120);         
        $pdf->Write(0, $part->duration_hours . ' (академиялық сағат/академических часов)');
        $pdf->SetXY(248, 177);         
        $pdf->Write(0, $reg_number);
        $pdf->SetXY(66, 171);         
        $pdf->Write(0, $date_day);
        $pdf->SetXY(78, 171);         
        $pdf->Write(0, $this->getNameMonth($date_month));

        // Page 2
        $templateId = $pdf->importPage(2);
        $size = $pdf->getTemplateSize($templateId);
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pageWidth = round($size['width']);
        $pageHeight = round($size['height']);
        $pdf->useTemplate($templateId);
        $pdf->SetFont('FreeSerif', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(120, 64);
        $pdf->Write(0, $user->full_name); 
        $pdf->SetXY(245, 178);         
        $pdf->Write(0, $reg_number);
        $pdf->SetXY(46, 174);         
        $pdf->Write(0, $date_day);
        $pdf->SetXY(53, 174);         
        $pdf->Write(0, $this->getNameMonth($date_month));

        $header = ['№', 'Бағдарлама модульдерінің атауы / Наименование модулей программы', 'Сағат саны / Количество часов', 'Баға / Оценка'];

        // Header
        $pdf->SetFont('FreeSerif', 'B', 9);
        $pdf->SetXY(50, 100);
        $pdf->Cell(8,8, $header[0], 1, 0, 'C');
        $pdf->SetXY(58, 100);
        $pdf->Cell(110, 8, $header[1], 1, 'C'); 
        $pdf->SetXY(168, 100);
        $pdf->Cell(50, 8, $header[2], 1, 1, 'C');
        $pdf->SetXY(218, 100);
        $pdf->Cell(30, 8, $header[3], 1, 0, 'C');
        // Content
        
        $padding = 108;        
        foreach($modules as $module) {
            $pdf->SetXY(50, $padding);
            $pdf->Cell(8,8, '1', 1, 0, 'C');
            $pdf->SetXY(58, $padding);
            $pdf->Cell(110, 8, $module->title, 1, 'C'); 
            $pdf->SetXY(168, $padding);
            $pdf->Cell(50, 8, $module->duration_hours, 1, 1, 'C');
            $pdf->SetXY(218, $padding);
            $pdf->Cell(30, 8, 'Сынақ / Зачет', 1, 0, 'C');
            $padding += 8;
        }
        
        $outputPath = storage_path('app/public/cert-'.$item->user_id.'-'.$item->id.'-'.$reg_number.'.pdf');
        $pdf->Output($outputPath, 'F');
        $item->update([
            'status_certificate' => 1,
            'rand' => $reg_number
        ]);
        Toast::info('Сертификат создан');
        return response()->download($outputPath);
    }

    public function getNameMonth(int $month): string
    {
        $monthsKK = [
            1 => 'Қаңтар',  2 => 'Ақпан',  3 => 'Наурыз',  4 => 'Сәуір',
            5 => 'Мамыр',   6 => 'Маусым', 7 => 'Шілде',   8 => 'Тамыз',
            9 => 'Қыркүйек', 10 => 'Қазан', 11 => 'Қараша', 12 => 'Желтоқсан'
        ];

        $monthsRU = [
            1 => 'Январь',  2 => 'Февраль',  3 => 'Март',    4 => 'Апрель',
            5 => 'Май',     6 => 'Июнь',     7 => 'Июль',    8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
        ];

        if ($month < 1 || $month > 12) {
            return 'Неверный номер месяца';
        }

        return $monthsKK[$month] . ' / ' . $monthsRU[$month];
    }

}
