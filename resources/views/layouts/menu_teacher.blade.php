
<li class="side-item side-item-category">Main</li>
<li class="slide {{ Request::is('home') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('home') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">
        <i class=" ion-ios-desktop side-menu__icon"></i>
        <span class="side-menu__label">{{__('lang.home')}}</span>
    </a>
</li>


<li class="slide {{ Request::is('teacher.groups*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('teacher.groups*') ? 'active' : '' }}"
       href="{{ route('teacher.groups.index') }}"
    >
        <i class=" si si-organization side-menu__icon"></i>
                    <span class="side-menu__label">{{__('models/groups.plural')}}</span>
    </a>
</li>


<li class="slide {{ Request::is('teacher.questions*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('teacher.questions*') ? 'active' : '' }}"
       href="{{ route('teacher.questions.index') }}"
    >
        <i class=" si si-question side-menu__icon"></i>
        <span class="side-menu__label">{{__('models/questions.plural')}}</span>

    </a>
</li>

<li class="slide {{ Request::is('teacher.exams*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('teacher.exams*') ? 'active' : '' }}"
       href="{{ route('teacher.exams.index') }}"
    >
        <i class=" si si-question side-menu__icon"></i>
        <span class="side-menu__label">{{__('models/exams.plural')}}</span>

    </a>
</li>










