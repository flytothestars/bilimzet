@extends('layouts.base')

@section('content')

    @include('parts.profileMenu')

    <div class="centered page-title width1088">
        <h1>@lang('profile.editing')</h1>
    </div>

    <form method="post" action="{{ route('updateProfile') }}" class="registration centered width1088" enctype="multipart/form-data">
        @csrf
        <div class="step1 flex start align-center">
            <div class="num">01</div>
            <a href="#" class="upload-photo">
                <img style="width: 100px; margin-top: -35px;" src="{{ $user->photoUrl }}" alt="">
            </a>
            <div class="form">
                <input type="text" name="full_name" value="{{ $user->full_name }}" placeholder="@lang('profile.fio')*">
                <input type="text" name="address" value="{{ $user->address }}" placeholder="@lang('profile.address')*">
                <input type="text" name="company_name" value="{{ $user->company_name }}" placeholder="@lang('profile.company')">
                <label>@lang('profile.load')</label>
                <input type="file" name="photo" placeholder="@lang('profile.load')">
            </div>
        </div>
        <div class="step2 flex between align-center">
            <div class="num">02</div>
            <div class="form">
                <input type="phone" name="phone" value="{{ $user->phone }}" placeholder="@lang('profile.phone')">
                <input type="text" name="position" value="{{ $user->position }}" placeholder="@lang('profile.position')">
                <label>@lang('profile.diploma')</label>
                <input type="file" name="diploma" placeholder="@lang('profile.diploma')">
                @if ($user->diploma)
                    <p>@lang('profile.use'):
                        <a href="{{ $user->diplomaUrl }}" target="_blank">@lang('profile.file')</a>
                    </p>
                @endif
                @if ($user->status_lector!=1)
                <label for="querylec">Стать лектором</label>
                <input type="checkbox" id="querylec" name="querylec" value="true">
                @endif
            </div>
        </div>

        @if($errors->count())
            <div class="step2" style="color: red; font-size: 18px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="step3 flex between align-center">
            <div class="checkboxes">
                <label>
                    <input name="receive_news_accept" {{ $user->receive_news_accept ? 'checked' : '' }} type="checkbox" value="true">
						 @lang('profile.receive')
                </label>
            </div>
            <button class="btn blue">@lang('profile.save')</button>
        </div>
    </form>

@endsection
