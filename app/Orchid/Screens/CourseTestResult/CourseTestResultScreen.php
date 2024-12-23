<?php

namespace App\Orchid\Screens\CourseTestResult;

use Orchid\Screen\Screen;
use App\Models\CourseTestResult;
use App\Models\User;
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
            'course_test_result_list' => CourseTestResult::get()->map(function($result){
                $result->user = $result->user->full_name;
                $result->speciality = $result->coursePart->course->speciality->title;
                $result->course = $result->coursePart->course->title;
                $result->test = $result->coursePart->courseTest[0]->title;
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
        $templatePath = storage_path('app/templates/шаблон_1.pdf');
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($templatePath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

            $pdf->useTemplate($templateId);

            $pdf->SetFont('FreeSerif', '', 12);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY(10, 10);
            // $text = mb_convert_encoding("Пример текста", 'UTF-8', 'auto');
            $pdf->Write(0, 'Текст');
        }
        $number = rand(00000, 99999);
        $outputPath = storage_path('app/public/cert-'.auth()->user()->id.'-'.$item->id.'-'.$number.'.pdf');
        $pdf->Output($outputPath, 'F');
        $item->update([
            'status_certificate' => 1,
            'rand' => $number
        ]);
        Toast::info('Сертификат создан');
        return response()->download($outputPath);
    }
}
