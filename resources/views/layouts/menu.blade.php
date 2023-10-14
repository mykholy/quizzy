
<li class="side-item side-item-category">Main</li>
<li class="slide {{ Request::is('home') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
        <i class=" ion-ios-desktop side-menu__icon"></i>
        <span class="side-menu__label">{{__('lang.home')}}</span>
    </a>
</li>
<li class="slide {{ Request::is('admin.teachers*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('admin.teachers*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
        <i class=" bx bx-user-circle side-menu__icon"></i>
        <span class="side-menu__label">{{__('models/teachers.plural')}}</span>
    </a>
</li>





<li class="slide {{ Request::is('admin.subjects*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('admin.subjects*') ? 'active' : '' }}"
       href="{{ route('admin.subjects.index') }}"
    >
        <i class=" si si-notebook side-menu__icon"></i>
                    <span class="side-menu__label">{{__('models/subjects.plural')}}</span>

    </a>
</li>

<li class="slide {{ Request::is('admin.groups*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('admin.groups*') ? 'active' : '' }}"
       href="{{ route('admin.groups.index') }}"
    >
        <i class=" si si-organization side-menu__icon"></i>
                    <span class="side-menu__label">{{__('models/groups.plural')}}</span>

    </a>
</li>

<li class="slide {{ Request::is('admin.students*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('admin.students*') ? 'active' : '' }}"
       href="{{ route('admin.students.index') }}"
    >
        <i class=" si si-people side-menu__icon"></i>
                    <span class="side-menu__label">{{__('models/students.plural')}}</span>

    </a>
</li>

<li class="slide {{ Request::is('admin/settings*') ? 'active' : '' }}">
    <a class="side-menu__item {{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings.general') }}">
        <i class=" ion-md-settings side-menu__icon"></i>
        <span class="side-menu__label">{{__('models/settings.plural')}}</span>
    </a>
</li>
