@extends('layouts.base')

@section('content')

   <div class="centered page-title width1088">
      <h1>@lang('olympics.title_one') - {{ $courseTitle }}</h1>
   </div>

   <div class="olympics width1088 flex between wrap align-top" id="app">
      <div class="box-shadow question width1088 p-30 white-background">
         <olympic-question
                 token-key="{{ $token }}"
                 remaining-minutes="{{ $remainingMinutes }}"
                 remaining-seconds="{{ $remainingSeconds }}">
         </olympic-question>
      </div>
   </div>

   @push('scripts')
      <script src="{{ mix('/js/app.min.js') }}"></script>
   @endpush
@endsection