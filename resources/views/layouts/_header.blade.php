<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                BBS
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                {{--active_class($condition,$activeClass='active',$inactiveClass='')函数 如果满足指定条件$condition,就返回$activeClass,不满足返回$inactiveClass
                --}}
                {{-- 扩展包类库hieu-le/active:~3.5 提供一批函数
                if_route() - 判断当前对应的路由是否是指定的路由;
                if_route_param() - 判断当前的 url 有无指定的路由参数;
                if_query() - 判断指定的 GET 变量是否符合设置的值;
                if_uri() - 判断当前的 url 是否满足指定的 url;
                if_route_pattern() - 判断当前的路由是否包含指定的字符;
                if_uri_pattern() - 判断当前的 url 是否含有指定的字符;
                --}}
                <li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a></li>
                <li class="{{ active_class((if_route('categorys.show') && if_route_param('category', 1))) }}"><a href="{{ route('categorys.show', 1) }}">分享</a></li>
                <li class="{{ active_class((if_route('categorys.show') && if_route_param('category', 2))) }}"><a href="{{ route('categorys.show', 2) }}">教程</a></li>
                <li class="{{ active_class((if_route('categorys.show') && if_route_param('category', 3))) }}"><a href="{{ route('categorys.show', 3) }}">问答</a></li>
                <li class="{{ active_class((if_route('categorys.show') && if_route_param('category', 4))) }}"><a href="{{ route('categorys.show', 4) }}">公告</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <!-- Authentication Links -->
                <!-- @ guest 或 @ auth用来判断用户是否登录(5.5新增) -->
                <!--用@ if(auth()->check())或@ if(auth()->guest())也可以  -->
                @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    <li>
                        <a href="{{ route('topics.create') }}">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                    {{-- 消息通知标记 --}}
                    <li>
                        <a href="{{ route('notifications.index') }}" class="notifications-badge" style="margin-top: -2px;">
                            <span class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }} " title="消息提醒">
                                {{ Auth::user()->notification_count }}
                            </span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{ Auth::user()->head }}" class="img-responsive img-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('users.show', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.edit', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    编辑资料
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                    退出登录
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>