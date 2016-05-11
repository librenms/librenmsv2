<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-warning" id="notification-menu-count">{{ count($menu_notifications) }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <!-- Inner Menu: contains the notifications -->
                        <ul id="dropdown-notifications-list" class="menu">
                            @foreach($menu_notifications->take(5) as $notification)
                                <li><!-- start notification -->
                                    <a href="{{ url('/notifications/'.$notification->notifications_id) }}" title="{{ $notification->body }}">
                                        <i class="fa fa-envelope text-aqua"></i> {{ $notification->title }}
                                    </a>
                                </li>
                                @endforeach
                                        <!-- end notification -->
                        </ul>
                    </li>
                    <li class="footer"><a href="{{ url('/notifications') }}">View all</a></li>
                </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user fa-lg" aria-hidden="true"></i>
                    <span class="hidden-xs">{{ Auth::user()->username }}</span> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <p>{{ Auth::user()->realname }} ({{ Auth::user()->username }})</p>
                        <p><small>{{ Auth::user()->email }}</small></p>
                        <p><small><strong>{{ trans('user.level.' . Auth::user()->level) }}</strong></small></p>
                        <p><small><i>{{ Auth::user()->descr }}</i></small></p>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left"><a href="{{ action('UserController@show', ['user_id' => Auth::id()]) }}" class="btn btn-default btn-flat"><i class="fa fa-cog"></i> {{ trans('nav.mysettings') }}</a></div>
                        <div class="pull-right"><a href="{{ url('/logout') }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> {{ trans('nav.logout') }}</a></div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>