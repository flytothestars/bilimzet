@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Добавление курса</h2>
    @if (\Session::has('message'))
        <div class="alert alert-success" role="alert">
            {!! \Session::get('message') !!}
        </div>
    @endif

    <form action="{{ route('admin.olympic.courses.update', $course->id) }}" id='select_predmet_form' method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-2">
                <label class="font-weight-bold">Локализация</label>
                <select name="locale" class="form-control">
                    <option value="ru" @if($course->locale == 'ru') selected @endif>Ru</option>
                    <option value="kz" @if($course->locale == 'kz') selected @endif>Kz</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" placeholder="Название курса" class="form-control" value="{{ $course->title }}">
            </div>
            <div class="col-md-1">
                <input type="number" name="price" placeholder="Цена курса" class="form-control" value="{{ $course->price }}">
            </div>
            <div class="col-md-2">
                <select name="classification" class="form-control">
                    @foreach($classifications as $classification)
                        <option value="{{ $classification->id }}" @if($course->classification_id == $classification->id) selected @endif>{{ $classification->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="member" class="form-control">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" @if($course->member_id == $member->id) selected @endif>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="subject" class="form-control">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @if($course->subject_id == $subject->id) selected @endif>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
		 <h2>Вопросы <a href="#" class="btn btn-success" id="add_new_question">Добавить вопрос</a></h2>
        <div class="questions-list">
            @foreach($course->questions as $question)
                <div class="row" id="question-{{ $question->id }}">
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="question[{{ $question->id }}][title]" placeholder="Вопрос" value="{{ $question->question }}">
                    </div>
                    @foreach($question->answers as $answer)
                    <div class="col-md-2">
                            <input class="form-control" type="text" name="question[{{ $question->id }}][answers][{{ $answer->id }}]" placeholder="Ответ" value="{{ $answer->answer }}">
                            <input data-answer-id="{{ $answer->id }}"  data-question-id="{{ $question->id }}" class="form-check-input answer edit" type="radio" name="is_right[{{ $question->id }}]" value="{{ $answer->id }}" @if($answer->is_right) checked @endif id="exampleRadios{{ $answer->id }}"
                                   data-key="{{ $answer->id }}"
                                   data-question="{{ $question->id }}">
                            <label class="form-check-label" for="exampleRadios{{ $answer->id }}">
                                Верный ответ
                            </label>
                    </div>
                        @if($answer->is_right)
                            <input id="right_answer_{{ $question->id }}" type="hidden" name="question[{{ $question->id }}][right_answer][]" value="{{ $answer->id }}">
                        @endif
                    @endforeach
						 <div>
							 <button class="btn btn-danger question-delete" data-question-id="{{ $question->id }}">Удалить</button>
						 </div>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Обновить курс</button>
            </div>
        </div>
    </form>

@endsection
