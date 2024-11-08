@extends('layouts.base')

@section('content')

    <div class="centered page-title width1088">
        <h1>@lang('auth.reg')</h1>
    </div>

    <form method="post" class="registration centered width1088" enctype="multipart/form-data">
        @csrf
        <div class="step1 flex start align-center">
            <div class="num">01</div>
            <a href="#" class="upload-photo"><img src="/images/elements/add-photo.svg" alt=""></a>
            <div class="form">
                <input type="text" name="full_name" value="{{ @old("full_name") }}" placeholder="@lang('auth.fio')*">
                <input type="text" name="address" value="{{ @old("address") }}" placeholder="@lang('auth.address')*">
                <input type="text" name="company_name" value="{{ @old("company_name") }}" placeholder="@lang('auth.company_name')">
                <label>@lang('auth.load')</label>
                <input type="file" name="photo" placeholder="@lang('auth.load')">
            </div>
        </div>
        <div class="step2 flex between align-center">
            <div class="num">02</div>
            <div class="form">
                <input type="password" name="password" placeholder="@lang('auth.password')">
                <input type="password" name="password_confirmation" placeholder="@lang('auth.confirmation')">
            </div>
            <div class="form">
                <input type="phone" name="phone" value="{{ @old("phone") }}" placeholder="@lang('auth.phone')">
                <input type="email" name="email" value="{{ @old("email") }}" placeholder="E-mail*">
                <input type="text" name="position" value="{{ @old("position") }}" placeholder="@lang('auth.position')">
                <label>@lang('auth.diploma')</label>
                <input type="file" name="diploma" placeholder="@lang('auth.diploma')"><br>
                <label for="querylec">Стать лектором</label>
                <input type="checkbox" id="querylec" name="querylec" value="true">
            </div>
        </div>

        @if($errors->count())
            <div class="step2" style="color: red; font-size: 18px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="step3 flex between align-center">
            <div class="checkboxes">
                <label><input name="data_process_accept" {{ @old('data_process_accept') ? 'checked' : '' }}
                              type="checkbox"> @lang('auth.consent')*</label>
                <label>
                    <input name="receive_news_accept" {{ @old('receive_news_accept') ? 'checked' : '' }}
                           type="checkbox" value="true">
						 @lang('auth.get_news')
                </label>
            </div>

			<p><a href="/politic.docx" target="_blank">@lang('auth.policy')</a><br>
            <a href="/user_soglas.rtf" target="_blank">@lang('auth.agreement')</a></p>

            <button class="btn blue">@lang('auth.create')</button>
        </div>
    </form>



@endsection
