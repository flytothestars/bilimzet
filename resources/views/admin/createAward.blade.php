@extends('layouts.admin')

@section('content')

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.contestFiles') }}">Файлы конкуров</a></li>
			<li class="breadcrumb-item active" aria-current="page">Выбрать награду</li>
		</ol>
	</nav>

	<h2 class="mt-4 mb-3">Выбрать награду</h2>

	<div>
		<form id="form" method="post" action="{{ route(('admin.storeAward'), [ 'contestFile' => $contestFile->id ]) }}">
			@csrf
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif

			<div>
				<b>Пользователь</b> {{ $contestFile->user->full_name }}
			</div>

			<div>
				<b>Конкурс</b> <a href="{{ route('admin.editContest', [ 'contest' => $contestFile->contest->id ])}}"
										role="button">{{ $contestFile->contest->title }}</a>
			</div>

			<div><b>Файлы</b></div>

			<div class="link file">
				@foreach (explode(';', $contestFile->file) as $file)
					<a href="{{ '/uploads/contest_files/' . $file }}" target="_blank">{{ $file }}</a>
				@endforeach
			</div>
			<div class="link video">
				@foreach (explode(';', $contestFile->video) as $video)
					<a href="{{ $video }}" target="_blank">{{ $video }}</a>
				@endforeach
			</div>

			<div><b>Награды</b></div>

			@if (count($certificates))
				<div class="konkurs-benefits">
					<div class="width1088">
						<div class="items flex between align-top wrap">
							@foreach ($certificates as $certificate)
								<div class="item cursor-pointer">
									<a class="select-award" data-id="{{ $certificate->id }}">
										<img src="{{ $certificate->getUploadedUrl('file') }}" alt="">
										<div class="title">{{ $certificate->name }}</div>
										<div class="description">{{ $certificate->text }}</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			@endif

			<input type="hidden" name="certificate_id" id="certificate_id">

			<button type="submit" name="_save_opt" value="create" class="btn btn-primary">Сохранить</button>
		</form>

	</div>

@endsection
