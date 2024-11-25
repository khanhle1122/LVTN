<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <form class="search-form" action="{{ route('search') }}" method="GET">
            <div class="input-group">
                <div class="input-group-text">
                    <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" name="query" placeholder="Search here...">
            </div>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    @if(count($notifications)>0)
                      <div class="indicator">
                        <div class="circle"></div>
                      </div>
                    @endif
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                  <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                      <p>Bạn có {{ count($notifications) }} Thông báo mới</p>
                      @if(count($notifications) > 0)
                          <a href="{{ route('clear.notification') }}" class="text-muted">Clear all</a>
                      @endif
                  </div>
                  <div class="p-1">
                      @if(count($notifications) > 0)
                          @foreach($notifications as $notification)
                              <a href="{{ route('check.notification', $notification->id) }}" class="dropdown-item d-flex align-items-center py-2">
                                  <div class="d-flex justify-content-between flex-grow-1 me-2">
                                      <div>
                                        <p>{{ $notification->title }}</p>
                                        <p class="tx-12 text-muted">{{ $notification->content }}</p>
                                      </div>
                                      <p class="tx-12 text-muted mt-2"><em>{{ $notification->created_at->diffForHumans() }}</em></p>
                                  </div>
                              </a>
                          @endforeach
                      @else
                          <div class="dropdown-item d-flex align-items-center py-2">
                              <div class="flex-grow-1 me-2">
                                  <p class="tx-12 text-muted">Bạn không có thông báo mới</p>
                              </div>
                          </div>
                      @endif
                  </div>
                  <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                      <a href="{{ route('show.notification') }}">View All Notifications</a>
                  </div>
              </div>
              
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="{{ route('chat.index') }}" >
                    <i class="fa-regular fa-comment fa-lg"></i>                    
                    @if(count($notifications)>0)
                      <div class="indicator">
                        <div class="circle"></div>
                      </div>
                    @endif
                </a>
                
              
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <p class="">{{ Auth::user()->name }}</p>

                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                       
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                            <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                    
                    <li class="dropdown-item py-2">
                        
                        <a href="{{ route('admin.logout') }}" class="text-body ms-0">
                        <i class="me-2 icon-md" data-feather="log-out"></i>
                        <span>Log Out</span>
                        </a>
                    </li>
                    </ul>
                </div>
            </li>
            
        </ul>
    </div>
</nav>