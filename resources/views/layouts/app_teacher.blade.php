<!doctype html>
<html lang="en" dir="ltr">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="{{setting('application_name')}}">
    <meta name="Author" content="{{setting('application_name')}}">
    <meta name="Keywords" content="{{setting('application_name')}}">

    <!-- Title -->
    <title>{{setting('application_name')}}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/x-icon">

    <!-- Icons css -->
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

    <!-- Bootstrap css -->
    <link id="style" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- style css -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet">

    <!--- Animations css-->
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <!---izitoast css-->
    <link href="{{asset('assets/css/iziToast.min.css')}}" rel="stylesheet"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo+Slab:wght@400;600;700&family=Cairo:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        body, small, a, p,.blockquote ,.post-quote blockquote,.lang-label,.pricing-box-alt,.pullquote-left,.pullquote-right, span .sub-menu-container .menu-item > .menu-link, .wp-caption, .fbox-center.fbox-italic p, .skills li .progress-percent .counter, .nav-tree ul ul a, .font-body, h1, h2, h3, h4, h5, h6, #logo a, .menu-link, .mega-menu-style-2 .mega-menu-title > .menu-link, .top-search-form input, .entry-link, .entry.entry-date-section span, .button.button-desc, .fbox-content h3, .tab-nav-lg li a, .counter, label, .widget-filter-links li a, .nav-tree li a, .wedding-head, .entry-link span, .entry blockquote p, .more-link, .comment-content .comment-author span, .comment-content .comment-author span a, .button.button-desc span, .testi-content p, .team-title span, .before-heading, .wedding-head .first-name span, .wedding-head .last-name span, .font-secondary {
            font-family: 'Cairo', 'Open Sans', sans-serif !important;
        }
    </style>
    @stack('third_party_stylesheets')
    @stack('page_css')

</head>

<body class="ltr main-body app sidebar-mini">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('assets/img/svgicons/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page">
    <div>
        <!-- main-header -->
        <div class="main-header side-header sticky nav nav-item">
            <div class="container-fluid main-container ">
                <div class="main-header-left ">
                    <div class="responsive-logo">
                        <a href="index.html" class="header-logo">
                            <img src="{{asset(setting('logo'))}}" class="logo-1" alt="logo" onerror="this.src=''">
                            <img src="{{asset(setting('logo'))}}" class="dark-logo-1" alt="logo" onerror="this.src=''">
                        </a>
                    </div>
                    <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                        <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
                        <a class="close-toggle" href="javascript:void(0);"><i class="header-icons fe fe-x"></i></a>
                    </div>
{{--                    <div class="main-header-center ms-3 d-sm-none d-md-none d-lg-block">--}}
{{--                        <input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>--}}
{{--                    </div>--}}
                </div>
                <div class="main-header-right">
                    <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon fe fe-more-vertical "></span>
                    </button>
                    <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                            <ul class="nav nav-item  navbar-nav-right ms-auto">
                                <li hidden class="">
                                    <div class="dropdown  nav-item countries">
                                        <a href="javascript:void(0);" class="d-flex  nav-item nav-link country-flag1" data-bs-toggle="dropdown" aria-expanded="false">
													<span class="avatar country-Flag me-0 align-self-center bg-transparent">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="flag-icon1"> <circle cx="256" cy="256" r="256" fill="#f0f0f0"></circle> <g fill="#0052b4"> <path d="M52.92 100.142c-20.109 26.163-35.272 56.318-44.101 89.077h133.178L52.92 100.142zM503.181 189.219c-8.829-32.758-23.993-62.913-44.101-89.076l-89.075 89.076h133.176zM8.819 322.784c8.83 32.758 23.993 62.913 44.101 89.075l89.074-89.075H8.819zM411.858 52.921c-26.163-20.109-56.317-35.272-89.076-44.102v133.177l89.076-89.075zM100.142 459.079c26.163 20.109 56.318 35.272 89.076 44.102V370.005l-89.076 89.074zM189.217 8.819c-32.758 8.83-62.913 23.993-89.075 44.101l89.075 89.075V8.819zM322.783 503.181c32.758-8.83 62.913-23.993 89.075-44.101l-89.075-89.075v133.176zM370.005 322.784l89.075 89.076c20.108-26.162 35.272-56.318 44.101-89.076H370.005z"></path> </g> <g fill="#d80027"> <path d="M509.833 222.609H289.392V2.167A258.556 258.556 0 00256 0c-11.319 0-22.461.744-33.391 2.167v220.441H2.167A258.556 258.556 0 000 256c0 11.319.744 22.461 2.167 33.391h220.441v220.442a258.35 258.35 0 0066.783 0V289.392h220.442A258.533 258.533 0 00512 256c0-11.317-.744-22.461-2.167-33.391z"></path> <path d="M322.783 322.784L437.019 437.02a256.636 256.636 0 0015.048-16.435l-97.802-97.802h-31.482v.001zM189.217 322.784h-.002L74.98 437.019a256.636 256.636 0 0016.435 15.048l97.802-97.804v-31.479zM189.217 189.219v-.002L74.981 74.98a256.636 256.636 0 00-15.048 16.435l97.803 97.803h31.481zM322.783 189.219L437.02 74.981a256.328 256.328 0 00-16.435-15.047l-97.802 97.803v31.482z"></path> </g> </svg>
													</span>
                                            <div class="my-auto">
                                                <strong class="me-2 ms-2 my-auto">English</strong>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-start  dropdown-menu-arrow">
                                            <a href="javascript:void(0);" class="dropdown-item d-flex ">
                                                <span class="avatar me-1 align-self-center bg-transparent"><img src="../assets/img/flag-imgs/french_flag.jpg" alt="img"></span>
                                                <div class="d-flex">
                                                    <span class="mt-2">French</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex">
                                                <span class="avatar me-1 align-self-center bg-transparent"><img src="../assets/img/flag-imgs/germany_flag.jpg" alt="img"></span>
                                                <div class="d-flex">
                                                    <span class="mt-2">Germany</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex">
                                                <span class="avatar me-1 align-self-center bg-transparent"><img src="../assets/img/flag-imgs/italy_flag.jpg" alt="img"></span>
                                                <div class="d-flex">
                                                    <span class="mt-2">Italy</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex">
                                                <span class="avatar me-1 align-self-center bg-transparent"><img src="../assets/img/flag-imgs/russia_flag.jpg" alt="img"></span>
                                                <div class="d-flex">
                                                    <span class="mt-2">Russia</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex">
                                                <span class="avatar me-1 align-self-center bg-transparent"><img src="../assets/img/flag-imgs/spain_flag.jpg" alt="img"></span>
                                                <div class="d-flex">
                                                    <span class="mt-2">spain</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown nav-item main-layout">
                                    <a class="new nav-link theme-layout nav-link-bg layout-setting" >
                                        <span class="dark-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/></svg></span>
                                        <span class="light-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/></svg></span>
                                    </a>
                                </li>
{{--                                <li hidden class="nav-link search-icon d-lg-none d-block">--}}
{{--                                    <form class="navbar-form" role="search">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" placeholder="Search">--}}
{{--                                            <span class="input-group-btn">--}}
{{--														<button type="reset" class="btn btn-default">--}}
{{--															<i class="fas fa-times"></i>--}}
{{--														</button>--}}
{{--														<button type="submit" class="btn btn-default nav-link resp-btn">--}}
{{--															<svg xmlns="http://www.w3.org/2000/svg" height="24px" class="header-icon-svgs" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>--}}
{{--														</button>--}}
{{--													</span>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </li>--}}
                                <li hidden class="dropdown nav-item main-header-message ">
                                    <a class="new nav-link" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg><span class=" pulse-danger"></span></a>
                                    <div class="dropdown-menu">
                                        <div class="menu-header-content bg-primary text-start">
                                            <div class="d-flex">
                                                <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">Messages</h6>
                                                <a href="javascript:void(0);" class="badge rounded-pill bg-warning ms-auto my-auto float-end">Mark All Read</a>
                                            </div>
                                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread messages</p>
                                        </div>
                                        <div class="main-message-list chat-scroll">
                                            <div class="p-3 d-flex border-bottom messages">
                                                <div class="  drop-img  cover-image  " data-bs-image-src="../assets/img/users/3.jpg">
                                                    <span class="avatar-status bg-teal"></span>
                                                </div>
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <a href="chat.html"><h5 class="mb-1 name">Petey Cruiser</h5></a>
                                                    </div>
                                                    <p class="mb-0 desc">I'm sorry but i'm not sure how to help you with that......</p>
                                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 15 3:55 PM</p>
                                                </div>
                                            </div>
                                            <div class="p-3 d-flex border-bottom messages">
                                                <div class="drop-img cover-image" data-bs-image-src="../assets/img/users/2.jpg">
                                                    <span class="avatar-status bg-teal"></span>
                                                </div>
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <a href="chat.html"><h5 class="mb-1 name">Jimmy Changa</h5></a>
                                                    </div>
                                                    <p class="mb-0 desc">All set ! Now, time to get to you now......</p>
                                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 06 01:12 AM</p>
                                                </div>
                                            </div>
                                            <div class="p-3 d-flex border-bottom messages">
                                                <div class="drop-img cover-image" data-bs-image-src="../assets/img/users/9.jpg">
                                                    <span class="avatar-status bg-teal"></span>
                                                </div>
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <a href="chat.html"><h5 class="mb-1 name">Graham Cracker</h5></a>
                                                    </div>
                                                    <p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
                                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 25 10:35 AM</p>
                                                </div>
                                            </div>
                                            <div class="p-3 d-flex border-bottom messages">
                                                <div class="drop-img cover-image" data-bs-image-src="../assets/img/users/12.jpg">
                                                    <span class="avatar-status bg-teal"></span>
                                                </div>
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <a href="chat.html"><h5 class="mb-1 name">Donatella Nobatti</h5></a>
                                                    </div>
                                                    <p class="mb-0 desc">Here are some products ...</p>
                                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 12 05:12 PM</p>
                                                </div>
                                            </div>
                                            <div class="p-3 d-flex border-bottom messages">
                                                <div class="drop-img cover-image" data-bs-image-src="../assets/img/users/5.jpg">
                                                    <span class="avatar-status bg-teal"></span>
                                                </div>
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <a href="chat.html"><h5 class="mb-1 name">Anne Fibbiyon</h5></a>
                                                    </div>
                                                    <p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
                                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Jan 29 03:16 PM</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center dropdown-footer">
                                            <a href="chat.html">VIEW ALL</a>
                                        </div>
                                    </div>
                                </li>
                                <li hidden class="dropdown nav-item main-header-notification">
                                    <a class="new nav-link" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
                                    <div class="dropdown-menu">
                                        <div class="menu-header-content bg-primary text-start">
                                            <div class="d-flex">
                                                <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">Notifications</h6>
                                                <a href="javascript:void(0);" class="badge rounded-pill bg-warning ms-auto my-auto float-end">Mark All Read</a>
                                            </div>
                                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread Notifications</p>
                                        </div>
                                        <div class="main-notification-list Notification-scroll">
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-pink">
                                                    <i class="la la-file-alt text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">New files available</h5></a>
                                                    <div class="notification-subtext">10 hour ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-purple">
                                                    <i class="la la-gem text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">Updates Available</h5></a>
                                                    <div class="notification-subtext">2 days ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-success">
                                                    <i class="la la-shopping-basket text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">New Order Received</h5></a>
                                                    <div class="notification-subtext">1 hour ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-warning">
                                                    <i class="la la-envelope-open text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">New review received</h5></a>
                                                    <div class="notification-subtext">1 day ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-danger">
                                                    <i class="la la-user-check text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">22 verified registrations</h5></a>
                                                    <div class="notification-subtext">2 hour ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-flex p-3 border-bottom">
                                                <div class="notifyimg bg-primary">
                                                    <i class="la la-check-circle text-white"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="mail.html"><h5 class="notification-label mb-1">Project has been approved</h5></a>
                                                    <div class="notification-subtext">4 hour ago</div>
                                                </div>
                                                <div class="ms-auto" >
                                                    <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-footer">
                                            <a href="mail.html">VIEW ALL</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item full-screen fullscreen-button">
                                    <a class="new nav-link full-screen-link" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
                                </li>
                                <li  class="dropdown main-profile-menu nav nav-item nav-link">
                                    <a class="profile-user d-flex" href=""><img alt="" src="{{ Auth::user()->photo }}" onerror="this.src=''"></a>
                                    <div class="dropdown-menu">
                                        <div class="main-header-profile bg-primary p-3">
                                            <div class="d-flex wd-100p">
                                                <div class="main-img-user"><img alt="" src="{{ Auth::user()->photo }}" class="" onerror="this.src=''"></div>
                                                <div class="ms-3 my-auto">
                                                    <h6>{{ Auth::user()->name }}</h6><span>Super Admin</span>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <a class="dropdown-item" href="profile.html"><i class="bx bx-user-circle"></i>Profile</a>--}}
{{--                                        <a class="dropdown-item" href="editprofile.html"><i class="bx bx-cog"></i> Edit Profile</a>--}}
{{--                                        <a class="dropdown-item" href="mail.html"><i class="bx bxs-inbox"></i>Inbox</a>--}}
{{--                                        <a class="dropdown-item" href="chat.html"><i class="bx bx-envelope"></i>Messages</a>--}}
{{--                                        <a class="dropdown-item" href="{{ route('admin.settings.general') }}"><i class="bx bx-slider-alt"></i> @lang('models/settings.plural')</a>--}}
                                        <a class="dropdown-item" href="#"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i>   {{ __('auth.sign_out') }}</a>
                                        <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                                <li hidden class="dropdown main-header-message right-toggle">
                                    <a class="nav-link pe-0" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        @include('layouts.sidebar_teacher')
        <!-- main-sidebar -->
    </div>

    <!-- main-content -->
    <div class="main-content app-content">

        <!-- container -->
        <div class="main-container container-fluid">

            <!-- breadcrumb -->
            @yield('breadcrumb')
            <!-- breadcrumb -->

            <!-- row -->
            <div class="row">
                @yield('content')
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!-- sidebar-right-->
    <div class="sidebar sidebar-right sidebar-animate">
        <div class="panel panel-primary card mb-0 box-shadow">
            <div class="tab-menu-heading border-0 p-3">
                <div class="card-title mb-0">Notifications</div>
                <div class="card-options ms-auto">
                    <a href="javascript:void(0);" class="sidebar-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#side1" class="active" data-bs-toggle="tab"><i class="fe fe-message-circle tx-15 me-2"></i> Chat</a></li>
                        <li><a href="#side2" data-bs-toggle="tab"><i class="fe fe-bell tx-15 me-2"></i> Notifications</a></li>
                        <li><a href="#side3" data-bs-toggle="tab"><i class="fe fe-users tx-15 me-2"></i> Friends</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active " id="side1">
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-primary brround avatar-md">CH</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>New Websites is Created</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">30 mins ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-danger brround avatar-md">N</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare For the Next Project</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">2 hours ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-info brround avatar-md">S</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Decide the live Discussion</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">3 hours ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-warning brround avatar-md">K</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Meeting at 3:00 pm</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">4 hours ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-success brround avatar-md">R</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">1 day ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-pink brround avatar-md">MS</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">1 day ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-purple brround avatar-md">L</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">45 minutes ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center p-3">
                            <div class="">
                                <span class="avatar bg-blue brround avatar-md">U</span>
                            </div>
                            <a class="wrapper w-100 ms-3" href="javascript:void(0);" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted me-1"></i>
                                        <small class="text-muted ms-auto">2 days ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane  " id="side2">
                        <div class="list-group list-group-flush ">
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/12.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Madeleine</strong> Hey! there I' am available....
                                    <div class="small text-muted">
                                        3 hours ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/1.jpg"></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Anthony</strong> New product Launching...
                                    <div class="small text-muted">
                                        5 hour ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/2.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Olivia</strong> New Schedule Realease......
                                    <div class="small text-muted">
                                        45 minutes ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/8.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Madeleine</strong> Hey! there I' am available....
                                    <div class="small text-muted">
                                        3 hours ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/11.jpg"></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Anthony</strong> New product Launching...
                                    <div class="small text-muted">
                                        5 hour ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/6.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Olivia</strong> New Schedule Realease......
                                    <div class="small text-muted">
                                        45 minutes ago
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/img/users/9.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-3">
                                    <strong>Olivia</strong> Hey! there I' am available....
                                    <div class="small text-muted">
                                        12 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  " id="side3">
                        <div class="list-group list-group-flush ">
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/9.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Mozelle Belt</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/11.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Florinda Carasco</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel" ><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/10.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Alina Bernier</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/2.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Zula Mclaughin</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/13.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Isidro Heide</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/12.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Mozelle Belt</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" ><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/4.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Florinda Carasco</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/7.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Alina Bernier</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" ><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/2.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Zula Mclaughin</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel" ><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/14.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Isidro Heide</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" ><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/11.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Florinda Carasco</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/9.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Alina Bernier</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/15.jpg"><span class="avatar-status bg-success"></span></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Zula Mclaughin</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex  align-items-center">
                                <div>
                                    <span class="avatar avatar-md brround cover-image" data-bs-image-src="../assets/img/users/4.jpg"></span>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">Isidro Heide</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#chatmodel"><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/Sidebar-right-->

    <!-- Message Modal -->
    <div class="modal fade" id="chatmodel" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-right chatbox" role="document">
            <div class="modal-content chat border-0">
                <div class="card overflow-hidden mb-0 border-0">
                    <!-- action-header -->
                    <div class="action-header clearfix">
                        <div class="float-start hidden-xs d-flex ms-2">
                            <div class="img_cont me-3">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img" alt="img">
                            </div>
                            <div class="align-items-center mt-2">
                                <h4 class="text-white mb-0 fw-semibold">Daneil Scott</h4>
                                <span class="dot-label bg-success"></span><span class="me-3 text-white">online</span>
                            </div>
                        </div>
                        <ul class="ah-actions actions align-items-center">
                            <li class="call-icon">
                                <a href="" class="d-done d-md-block phone-button" data-bs-toggle="modal" data-bs-target="#audiomodal">
                                    <i class="si si-phone"></i>
                                </a>
                            </li>
                            <li class="video-icon">
                                <a href="" class="d-done d-md-block phone-button" data-bs-toggle="modal" data-bs-target="#videomodal">
                                    <i class="si si-camrecorder"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="si si-options-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><i class="fa fa-user-circle"></i> View profile</li>
                                    <li><i class="fa fa-users"></i>Add friends</li>
                                    <li><i class="fa fa-plus"></i> Add to group</li>
                                    <li><i class="fa fa-ban"></i> Block</li>
                                </ul>
                            </li>
                            <li>
                                <a href=""  class="" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="si si-close text-white"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- action-header end -->

                    <!-- msg_card_body -->
                    <div class="card-body msg_card_body">
                        <div class="chat-box-single-line">
                            <abbr class="timestamp">February 1st, 2019</abbr>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                Hi, how are you Jenna Side?
                                <span class="msg_time">8:40 AM, Today</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <div class="msg_cotainer_send">
                                Hi Connor Paige i am good tnx how about you?
                                <span class="msg_time_send">8:55 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/9.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start ">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                I am good too, thank you for your chat template
                                <span class="msg_time">9:00 AM, Today</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <div class="msg_cotainer_send">
                                You welcome Connor Paige
                                <span class="msg_time_send">9:05 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/9.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start ">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                Yo, Can you update Views?
                                <span class="msg_time">9:07 AM, Today</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                But I must explain to you how all this mistaken  born and I will give
                                <span class="msg_time_send">9:10 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/9.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start ">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                Yo, Can you update Views?
                                <span class="msg_time">9:07 AM, Today</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                But I must explain to you how all this mistaken  born and I will give
                                <span class="msg_time_send">9:10 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/9.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start ">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                Yo, Can you update Views?
                                <span class="msg_time">9:07 AM, Today</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                But I must explain to you how all this mistaken  born and I will give
                                <span class="msg_time_send">9:10 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/9.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="img_cont_msg">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle user_img_msg" alt="img">
                            </div>
                            <div class="msg_cotainer">
                                Okay Bye, text you later..
                                <span class="msg_time">9:12 AM, Today</span>
                            </div>
                        </div>
                    </div>
                    <!-- msg_card_body end -->
                    <!-- card-footer -->
                    <div class="card-footer">
                        <div class="msb-reply d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control " placeholder="Typing....">
                                <div class="input-group-text bg-transparent border-0 p-0">
                                    <button type="button" class="btn btn-primary ">
                                        <i class="far fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- card-footer end -->
                </div>
            </div>
        </div>
    </div>

    <!--Video Modal -->
    <div id="videomodal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark border-0 text-white">
                <div class="modal-body mx-auto text-center p-5">
                    <h5>Valex Video call</h5>
                    <img src="../assets/img/users/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
                    <h4 class="mb-1 fw-semibold">Daneil Scott</h4>
                    <h6 class="loading">Calling...</h6>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle mb-0" href="javascript:void(0);">
                                    <i class="fas fa-video-slash"></i>
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle text-white mb-0" href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-phone bg-danger text-white"></i>
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle mb-0" href="javascript:void(0);">
                                    <i class="fas fa-microphone-slash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- modal-body -->
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- Audio Modal -->
    <div id="audiomodal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0">
                <div class="modal-body mx-auto text-center p-5">
                    <h5>Valex Voice call</h5>
                    <img src="../assets/img/users/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
                    <h4 class="mb-1  fw-semibold">Daneil Scott</h4>
                    <h6 class="loading">Calling...</h6>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle mb-0" href="javascript:void(0);">
                                    <i class="fas fa-volume-up bg-light text-dark"></i>
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle text-white mb-0" href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-phone text-white bg-success"></i>
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="icon icon-shape rounded-circle mb-0" href="javascript:void(0);">
                                    <i class="fas fa-microphone-slash bg-light text-dark"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- modal-body -->
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- Footer opened -->
    <div class="main-footer">
        <div class="container-fluid pd-t-0 ht-100p">
            <span> Copyright © {{date('Y')}} <a href="javascript:void(0);" class="text-primary">{{setting('application_name')}}</a>. Designed with <span class="fa fa-heart text-danger"></span> by <a href="{{env('DEV_COMPANY_URL',"https://web.facebook.com/devpediacompany")}}"> {{env('DEV_COMPANY',"Devpedia")}} </a> All rights reserved.</span>
        </div>
    </div>
    <!-- Footer closed -->

</div>
<!-- End Page -->

<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Bundle js -->
<script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Moment js -->
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

<!-- P-scroll js -->
<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>

<!-- Internal Select2.min js -->
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>


<!-- Sidebar js -->
<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>

<!-- Right-sidebar js -->
<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>
<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>

<!-- Sticky js -->
<script src="{{asset('assets/js/sticky.js')}}"></script>

<!-- eva-icons js -->
<script src="{{asset('assets/js/eva-icons.min.js')}}"></script>

<!--themecolor js-->
<script src="{{asset('assets/js/themecolor.js')}}"></script>

<!-- custom js -->
<script src="{{asset('assets/js/custom.js')}}"></script>

<!-- switcher-styles js -->
<script src="{{asset('assets/js/swither-styles.js')}}"></script>
<script src="{{asset('assets/js/iziToast.min.js')}}"></script>
<script>
    $('.select2').select2({
        placeholder: 'Choose',
        searchInputPlaceholder: 'Search'
    });
</script>
@include('includes.lazyload')
@stack('third_party_scripts')
@stack('page_scripts')
</body>
</html>
