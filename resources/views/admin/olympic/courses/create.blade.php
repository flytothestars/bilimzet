@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Добавление курса</h2>
    @if (\Session::has('message'))
        <div class="alert alert-success" role="alert">
            {!! \Session::get('message') !!}
        </div>
    @endif

    <form action="{{ route('admin.olympic.courses.store') }}" id='select_predmet_form' method="post">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <label class="font-weight-bold">Локализация</label>
                <select name="locale" class="form-control">
                    <option value="ru">Ru</option>
                    <option value="kz">Kz</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" placeholder="Название курса" class="form-control">
            </div>
            <div class="col-md-1">
                <input type="number" name="price" placeholder="Цена курса" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="classification" class="form-control">
                    @foreach($classifications as $classification)
                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="member" class="form-control">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="subject" class="form-control">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <h2>Вопросы <a href="#" class="btn btn-success" id="add_new_question">Добавить вопрос</a></h2>
        <div class="questions-list">
            <div class="row" id="question-1">
                <div class="col-md-3">
                    <input class="form-control" type="text" name="question[1][title]" placeholder="Вопрос">
                </div>
                @for($i = 1; $i <= 4; $i++)
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="question[1][answers][{{ $i }}]" placeholder="Ответ">
                        <input class="form-check-input answer" type="radio" name="is_right" id="exampleRadios{{ $i }}" data-key="{{ $i }}" data-question="1">
                        <label class="form-check-label" for="exampleRadios{{ $i }}">
                            Верный ответ
                        </label>
                    </div>
                @endfor
                <div class="right-answer"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Создать курс</button>
            </div>
        </div>
    </form>

@endsection
