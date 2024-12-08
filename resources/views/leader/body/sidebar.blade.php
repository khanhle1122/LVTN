<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('leader') }}" class="sidebar-brand">
        CDC<span> leader</span>
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
          <a href="{{ route('leader') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Danh sách công việc</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ route('profile.leader') }}" >
            <i class="link-icon icon-sm" data-feather="file-text"></i>

            <span class="link-title">Thông tin cá nhân</span>
          </a>
          
        </li>
        
        
        
      </ul>
    </div>
  </nav>