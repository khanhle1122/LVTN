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
                <a href="{{ route('division.employee') }}" class="nav-link">Phân công nhân viên</a>
              </li>
              
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ route('project') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Danh sách dự án</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('client') }}" >
            <i class="link-icon icon-sm" data-feather="users"></i>
              <span class="link-title">Danh sách đối tác</span>
          </a>
          
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ route('report.project') }}" >
            <i class="link-icon icon-sm" data-feather="file-text"></i>

            <span class="link-title">Báo cáo nghiệm thu</span>
          </a>
          
        </li>
        
        
        
      </ul>
    </div>
  </nav>