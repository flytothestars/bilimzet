@extends('layouts.admin')

@section('content')

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.testResults') }}">Результаты тестов</a></li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ $item ? 'Редактировать' : 'Добавить' }} сертификат
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} сертификат</h2>
	<div>
		<form id="form" method="post" action="{{ route(($certId ? 'admin.updateCertificate' : 'admin.storeCertificate'), [ 'id' => $id, 'certId' => $certId ]) }}" enctype="multipart/form-data">
			@csrf
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif

			<div class="form-group">
				<label for="course_title">Название курса</label>
				<input value="{{ $item->course_title ?? old('course_title') }}"
						 class="form-control @error('course_title') is-invalid @enderror"
						 type="text"
						 name="course_title" id="course_title" placeholder="">
				@error('course_title')
				<div class="invalid-feedback">
					{{ $errors->first('course_title') }}
				</div>
				@enderror
			</div>

			<div class="cert" style="line-height:1;">
				<div class="cert-head">
					<div class="cert-head__left">
						Қазақстан Республикасының <br>
						Білім және Ғылым Министрлігінің <br>
						Бұйрығына сәйкес <br>
						Қазақстандық Қайта Даярлау және Біліктілікті <br>
						Арттыру Орталығы
					</div>
					<img src="/img/223.png" alt="" class="cert-head__img">
					<div class="cert-head__right">
						Согласно Приказу <br>
						Министерства Образования и Науки <br>
						Республики Казахстан <br>
						Казахстанский Центр Переподготовки и <br>
						Повышения Квалификации
					</div>
				</div>
				<div class="cert__title">СЕРТИФИКАТ</div>
				<div class="cert__disc">
					Қазақстан Республикасы Білім және Ғылым Министрлігінің <br>
					2016 жылғы 28 қаңтардағы № 95 бұйрығына сәйкес
				</div>
				<div class="name-wrap">
					<div class="name-lab">Осы сертификат</div>
					<input type="text" id="name-inp" class="name-inp" value="{{ $item->fio ?? old('fio') }}" name="fio" id="fio">
					<div class="name-hint">(тегі аты, әкесінің аты/фамилия, имя, отчество)</div>
				</div>
				<div class="accept-wrap">
					<div class="accept-lab">Данный сертификат подтверждает, что</div>
					<input type="text" id="accept-inp" class="accept-inp" value="{{ $item->title ?? old('title') }}" name="title" id="title">
					<div class="accept-hint">
						прошел(ла) курс повышения квалификации на тему / тақырыбында
					</div>
				</div>
				<div class="clock-wrap">
					<input type="text" class="clock-inp" id="clock-inp" value="{{ $item->duration ?? old('duration') }}" name="duration" id="duration">
					<div class="clock-hint">
						в объеме часов / сағат көлемінде біліктілікті арттыру курсынан өткенін растайды
					</div>
				</div>
				<div class="sign-wrap">
					<div class="sign-left">
						<div class="sign-name">ҚҚДБАО</div>
						<div class="sign-wr">
							<div class="sign-lab">Бас директоры:</div>
							<label>
								<input type="text" id="sign-inp" class="sign-inp">
								<div class="sign-hint">қолы/подпись</div>
								<span>/</span>
							</label>
							<label>
								<input type="text" id="sign-inp" name="sign1" class="sign-inp">
								<div class="sign-hint">аты-жөні/Ф.И.О</div>
								<span>/</span>
							</label>
						</div>
					</div>
					<div class="sign-right">
						<div class="sign-name">Директордың ОӘЖ</div>
						<div class="sign-wr">
							<div class="sign-lab">Бас директоры:</div>
							<label>
								<input type="text" id="sign-inp" class="sign-inp">
								<div class="sign-hint">қолы/подпись</div>
								<span>/</span>
							</label>
							<label>
								<input type="text" id="sign-inp" name="sign2" class="sign-inp">
								<div class="sign-hint">аты-жөні/Ф.И.О</div>
								<span>/</span>
							</label>
						</div>
					</div>
				</div>
				<div class="foot">
					<div class="foot-date">
						<div class="foot-labs">
							<div class="foot-lab">Берілген күні</div>
							<div class="foot-lab">Дата выдачи</div>
						</div>
						<div class="foot-wrap">
					<span>“<input type="text" id="foot-inp" value="{{ $item->day ?? old('day') }}" name="day" id="day" class="foot-inp foot-inp_d">”</span>
							<input type="text" id="foot-inp" value="{{ $item->month ?? old('month') }}" name="month" id="month" class="foot-inp foot-inp_m">
							<div class="foot-year">{{ $item->year ?? old('year') }} ж/г</div>
						</div>
					</div>
					<div class="foot-mo">М.О.</div>
					<div class="foot-reg">
						<div>Тіркеу</div>
						<div>Регистрационный №
							<input type="text" id="foot-inp" alue="" name="reg_number" id="month" class="sign-inp"></div>
					</div>
				</div>

				<input value="{{ $item->year }}" type="hidden" name="year" id="year">

			</div>

{{--		<!-----}}
{{--       --}}
{{--            <div class="form-group">--}}
{{--                <label for="title">Название сертификата</label>--}}
{{--                <input --}}
{{--                       class="form-control @error('title') is-invalid @enderror"--}}
{{--                       type="text"--}}
{{--                        placeholder="">--}}
{{--                @error('title')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('title') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}

{{--			<div class="form-group">--}}
{{--				 <label for="fio">ФИО человека</label>--}}
{{--				 <input value="{{ $item->fio ?? old('fio') }}"--}}
{{--                       class="form-control @error('fio') is-invalid @enderror"--}}
{{--                       type="text"--}}
{{--                       name="fio" id="fio" placeholder="">--}}
{{--                @error('fio')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('fio') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}

{{--			<div class="form-group">--}}
{{--				 <label for="course_title">Название курса</label>--}}
{{--				 <input value="{{ $item->course_title ?? old('course_title') }}"--}}
{{--                       class="form-control @error('course_title') is-invalid @enderror"--}}
{{--                       type="text"--}}
{{--                       name="course_title" id="course_title" placeholder="">--}}
{{--                @error('course_title')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('course_title') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}

{{--			<div class="form-group">--}}
{{--				 <label for="duration">Длительность</label>--}}
{{--				 <input value="{{ $item->duration ?? old('duration') }}"--}}
{{--                       class="form-control @error('duration') is-invalid @enderror"--}}
{{--                       type="text"--}}
{{--                       name="duration" id="duration" placeholder="">--}}
{{--                @error('duration')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('duration') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}

{{--			<div class="form-row">--}}
{{--				 <div class="form-group col-md-2">--}}
{{--					  <label for="day">День</label>--}}
{{--					  <input value="{{ $item->day ?? old('day') }}"--}}
{{--                           class="form-control @error('day') is-invalid @enderror"--}}
{{--                           type="text"--}}
{{--                           name="day" id="day" placeholder="">--}}
{{--                    @error('day')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('day') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}
{{--			<div class="form-group col-md-4">--}}
{{--				 <label for="month">Месяц</label>--}}
{{--				 <input value="{{ $item->month ?? old('month') }}"--}}
{{--                           class="form-control @error('month') is-invalid @enderror"--}}
{{--                           type="text"--}}
{{--                           name="month" id="month" placeholder="">--}}
{{--                    @error('month')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('month') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}
{{--			<div class="form-group col-md-2">--}}
{{--				 <label for="year">Год</label>--}}
{{--				 <input value="{{ $item->year ?? old('year') }}"--}}
{{--                           class="form-control @error('year') is-invalid @enderror"--}}
{{--                           type="text"--}}
{{--                           name="year" id="year" placeholder="">--}}
{{--                    @error('year')--}}
{{--			<div class="invalid-feedback">--}}
{{--{{ $errors->first('year') }}--}}
{{--			</div>--}}
{{--@enderror--}}
{{--			</div>--}}
{{--	  </div>--}}
{{----->--}}
			<br><br>

			<button type="submit" name="_save_opt" value="create" class="btn btn-primary">Создать сертификат</button>
		</form>

	</div>

@endsection
