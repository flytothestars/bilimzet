@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<div class="white-wrap-border width1088">
		<div class="width1088 page-title">
			<h1>@lang('contests.my')</h1>
		</div>

		<div class="width1088 accordion">
			@foreach ($contests as $contest)
				<h3><a href="{{ route('contest', [ 'id' => $contest->id ]) }}">{{ $contest->title }}</a></h3>
				<div>
					<form class="konkurs-link-file" action="{{ route('myContests.store', [ 'id' => $contest->id ]) }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="flex between align-bottom">
							<div class="col col1">
								<label>@lang('contests.video')</label>
								<input type="text" name="video" placeholder="@lang('contests.link')">
							</div>
							<div class="input__wrapper col col2">
								<input type="file" name="file" id="input__file" accept="{{ $accept }}" class="input input__file" multiple>
								<label for="input__file" class="input__file-button">
									<span class="input__file-button-text">@lang('contests.attach')</span>
									<span class="input__file-icon-wrapper"><img class="input__file-icon" src="/images/elements/upload.svg" alt="@lang('contests.attach')" width="8"></span>
								</label>
							</div>
							<div class="col col3">
								<button type="submit" class="btn blue">@lang('contests.send')</button>
							</div>
						</div>
						<div class="job">
							<label>@lang('contests.workplace')</label>
							<input type="text" name="workplace" placeholder="@lang('contests.enter_workplace')" value="{{ $contest->workplace }}">
						</div>
					</form>
					<div class="links">
						<div class="row flex between align-center">
							<div class="files">
								@foreach ($contest->files ?? [] as $file)
									@if (!empty($file))
										<div class="link file">
											<div class="title">{{ $file }}</div>
											<a class="delete file">x</a>
											<form class="hidden form-delete-file" action="{{ route('myContests.deleteFile', [ 'id' => $contest->id ]) }}" method="post">
												@csrf
												<input type="hidden" name="file" value="{{ $file }}">
												<button type="submit"></button>
											</form>
										</div>
									@endif
								@endforeach
							</div>
							<div class="videos">
								@foreach ($contest->videos ?? [] as $video)
									@if (!empty($video))
										<div class="link video">
											<div class="title">{{ $video }}</div>
											<a class="delete video">x</a>
											<form class="hidden form-delete-video" action="{{ route('myContests.deleteVideo', [ 'id' => $contest->id ]) }}" method="post">
												@csrf
												<input type="hidden" name="video" value="{{ $video }}">
												<button type="submit"></button>
											</form>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<script>
		let inputs = document.querySelectorAll('.input__file');
		Array.prototype.forEach.call(inputs, input => {
			let label = input.nextElementSibling,
				labelVal = label.querySelector('.input__file-button-text').innerText;

			input.addEventListener('change', e => {
				let countFiles = '';
				if (this.files && this.files.length >= 1)
					countFiles = this.files.length;

				if (countFiles)
					label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
				else
					label.querySelector('.input__file-button-text').innerText = labelVal;
			});
		});
	</script>

@endsection
