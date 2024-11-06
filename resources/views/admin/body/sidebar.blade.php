<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('admin_index') }}" class="sidebar-brand">
        CDC<span> Admin</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('admin_index') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#nhansu" role="button" aria-expanded="false" aria-controls="nhansu">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Nhân sự</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="nhansu">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('employee') }}" class="nav-link">Danh sách nhân viên</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('view.add.employee') }}" class="nav-link">Thêm nhân viên</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('division.employee') }}" class="nav-link">Phân công nhân sự</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#project" role="button" aria-expanded="false" aria-controls="project">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dự án</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="project">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('project') }}" class="nav-link">Danh sách dự án</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.project') }}" class="nav-link">Thêm dự án</a>
              </li>
              @if($project)
                  <!-- Hiển thị nội dung nếu $project có giá trị -->
                  <li class="nav-item">
                    <a href="{{ route('view.task',$project->id) }}" class="nav-link">Chi tiết dự án</a>
                  </li>
              @endif
              
              
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#client" role="button" aria-expanded="false" aria-controls="project">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Đối tác</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="client">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('client') }}" class="nav-link">Danh sách đối tác</a>
              </li>
              <li class="nav-item">
                {{-- <a href="{{ route('view.add.client') }}" class="nav-link">Thêm đối tác</a> --}}
              </li>
              
              
            </ul>
          </div>
        </li>
        
        
        
      </ul>
    </div>
  </nav>