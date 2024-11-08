@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<div class="lk flex between align-top centered width1088">
		<div class="profile">
			<div class="top flex between align-center" style="height:120px">
				<div class="balance">@lang('profile.balance'): <span style="font-size:14pt;">{{ $user->money_amount_kzt }} Т</span>

					<form action="/create_new_payment.php" method="POST" id="add_funds" target="_blank">
						<input type="hidden" name="user_id" value="{{ $user->id }}">
						<input type="hidden" name="user_email" value="{{ $user->email }}">
						<br>
						<table>
							<tr>
								<td>@lang('profile.fill_balance'):</td>
								<td width="5"></td>
								<td><input type="text" name="amount" style="width:100px;height:30px;font-size:12pt"></td>
								<td width="5"></td>
								<td><button type="submit" class="btn black">@lang('profile.fill')</button></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<div class="wrap">
				@if (session('message'))
					<div style="margin-bottom: 16px;color: green;font-size: 18px;">
						{{ session('message') }}
					</div>
				@endif
				<div class="photo-name">
					<img style="max-width: 122px; max-height: 122px;" src="{{ $user->photoUrl }}" alt="">
					<div class="name">
						<p>{{ $user->full_name }}</p>
						<a href="{{ route('editProfile') }}" class="edit">@lang('profile.edit')</a>
						@if ($user->isAdmin())
							<br>
							<a style="color: red; font-size: 18px;"
								href="{{ @route('admin.index') }}">@lang('profile.to_admin')</a>
						@endif
					</div>
				</div>
				<div class="contacts">
					<div class="col">
						<span class="email"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
						<span class="phone">
                  	@if ($user->phone)
								<a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
							@else
								@lang('profile.not_specified')
							@endif
						</span>
						<span class="role">
							{{ $user->position ?? __('profile.not_specified') }}
						</span>
					</div>
					<div class="col">
						<span class="geo">{{ $user->company_name ?? __('profile.not_specified') }}</span>
						{{--						<span class="education">ГУ "Школа-гимназия"№3</span>--}}
						<span class="key"><a href="{{ route('editPassword') }}">@lang('profile.change_password')</a></span>
					</div>
				</div>
			</div>
			<a class="btn-support flex center align-center">
				<img src="/images/elements/support.svg" alt="">
				<span>@lang('profile.support')</span>
			</a>
		</div>
		<div class="courses">
			<div class="title">@lang('profile.my_courses')</div>
			<div class="wrap">
				@forelse ($courses as $course)
					<div class="course physics">
						<div class="title" style="font-size: 10pt;">{{ $course->title }}</div>
						<div class="watch"><a href="{{ route('course', [ 'id' => $course->id ]) }}"
													 class="btn blue shadow watch">@lang('profile.watch')</a></div>
					</div>
				@empty
					@lang('profile.no_courses')
				@endforelse
			</div>
		</div>
	</div>
	<div class="lk between align-top centered width1088 olympic-results">
		<h2>Пройденные олимпиады</h2>

		<div class="inner">
			@forelse($olympicResults as $olympicResult)
			<div class="card">
				<div class="card-body">
					<a href="{{ route('olympic.show.result', $olympicResult->id) }}"><h5 class="card-title">{{ $olympicResult->course->title }}</h5></a>
				</div>
			</div>
			@empty
				<p>Нет пройденных олимпиад</p>
			@endforelse
		</div>
	</div>

	@include('parts.recommendations', [ 'templateNarrow' => true ])
	@include('parts.chat')

	@push('scripts')
		<script src="{{ mix('/js/app.min.js') }}"></script>
	@endpush

@endsection
