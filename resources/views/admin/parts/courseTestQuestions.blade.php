<h2 class="mt-5 mb-3">Вопросы ({{ $items ? $items->count() : 0 }})</h2>
<div class="mb-3" style="text-align: right">
    <a role="button"
       href="{{ route('admin.createCourseTestQuestion', compact('speciality', 'course', 'test')) }}"
       class="btn btn-primary btn-sm mr-2">Добавить</a>
</div>
@if($items->count())
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $question)
                <tr>
                    <td>{{ $question->title }}</td>
                    <td>
                        <a href="{{ route('admin.editCourseTestQuestion',
                                        compact('speciality', 'course', 'test', 'question')) }}"
                           role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                        <form style="display: inline-block" method="post"
                              action="{{ route('admin.destroyCourseTestQuestion',
                                        compact('speciality', 'course', 'test', 'question')) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>Нет Вопросов</p>
@endif
