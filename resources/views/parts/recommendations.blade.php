<div class="centered {{ isset($templateNarrow) ? 'width1088' : '' }} ">
    <h2>@lang('recommendations.title')</h2>
</div>

<div class="favorites {{ isset($templateNarrow) ? 'width1088' : '' }}">
    <div class="centered">
        <div class="navi-parent">
            <div class="swiper-button-next nextFav"><img src="/images/elements/arrow-black-right.svg" alt=""></div>
            <div class="swiper-button-prev prevFav"><img src="/images/elements/arrow-black-left.svg" alt=""></div>
            <div class="swiper-container swiper-favorites">
                <ul class="swiper-wrapper">
                    @foreach (\App\Data\RecommendedCourses::get() as $course)
                        <li class="swiper-slide">
                            <div style="width: 100%; height: 221px; display: flex; align-items: center; justify-content: center;
                                    background: {{ $course->speciality->picture_background }}">
                                <img style="max-width: 90px; max-height: 90px;" src="{{ $course->speciality->getUploadedUrl('picture') }}" alt="">
                            </div>
                            <div class="category">
                                {{ $course->speciality->getParentCategory() }}
                                : {{ $course->speciality->getChildCategory() }}
                            </div>
                            <div class="title">
                                <a href="{{ route('course', ['id' => $course->id]) }}">{{ $course->title }}</a>
                            </div>
                            <div class="chars">
                                <span class="lessons">@lang('recommendations.parts'): {{ $course->parts->count() }}</span>
                                <span class="hours"> {{ $course->parts->sum('duration_hours') }} ч</span>
                            </div>
                            <div class="link">
                                <a href="{{ route('course', ['id' => $course->id]) }}"
                                   class="btn blue">@lang('recommendations.go')</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
