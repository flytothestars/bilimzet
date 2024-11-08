@extends('layouts.base')

@section('content')
   {{--<div class="centered page-title width1088 olimp-header"></div>--}}

   <div class="text-block-section centered page-title width1088">
       {{--<div class="top-olimpic-text">
           <h2>Какая польза от наших олимпиад?</h2>
           <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_DMgKk1.json" class="olimp-lottie-player first-block" background="transparent"  speed="1"  style="width: 300px; height: 280px;"  loop autoplay></lottie-player>
           <p>
               Вы скорее всего задаетесь вопросом, какая же может быть польза от наших олимпиад?.<br/>
               Наш центр вам отвечает:<br/>
               Олимпиады - это хороший способ честно и качественно проверить свои достижения и определить точный результат своих знаний.<br/>
               Какие ошибки вы можете допускать.<br/>
               При выполнении каких задач вы затрудняетесь, не можете ответить.<br/>
               В конце прохождения олимпиады мы вручим вам сертификат.
           </p>
       </div>--}}

       <div class="top-olimpic-text">
           <div class="centered pate-title width1088">
               <div class="top-info">
                   <h1 class="olimp-title">@lang('olympics.title')</h1>

                   <div class="top-block-info flex between align-center">
                       <div>
                           @lang('olympics.top_block_one')
                       </div>
                       <div class="price-text">@lang('olympics.price')</div>
                       <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_xcpxkfnu.json" background="transparent"  speed="1"  style="width: 300px; height: 250px;"  loop autoplay></lottie-player>
                   </div>
                   <div class="bottom-info-block flex align-center between">
                       @lang('olympics.middle_text')
                   </div>
               </div>
           </div>
           <h2>@lang('olympics.requires')</h2>
           <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_kcixdxqk/animations/lf30_editor_opilardo.json" class="olimp-lottie-player second-block" background="transparent"  speed="1"  style="width: 300px; height: 250px;"  loop autoplay></lottie-player>
           @lang('olympics.requires_block')
       </div>
       <div class="olympics width1088 flex between wrap align-top" id="app">
          <div class="box-shadow p-30 width1088 white-background">
             @if($currentSession)
                  <p class="olympic-alert info">
                      @lang('olympics.session_exist')<br/>
                      <a href="{{ route('olympic.start') . '?token=' . $currentSession->token }}">{{ route('olympic.start') . '?token=' . $currentSession->token }}</a>
                  </p>
             @else
                  <olympic-main-list></olympic-main-list>
             @endif
          </div>
       </div>
   </div>

   @push('scripts')
      <script src="{{ mix('/js/app.min.js') }}"></script>
      <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
   @endpush
@endsection