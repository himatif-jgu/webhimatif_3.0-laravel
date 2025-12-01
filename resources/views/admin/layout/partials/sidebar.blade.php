<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
      Noble<span>UI</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav" id="sidebarNav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['dashboard']) }}">
        <a href="{{ route('dashboard') }}" class="nav-link">
          <i class="link-icon" data-lucide="home"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['admin/members*']) }}">
        <a href="{{ route('admin.members.index') }}" class="nav-link">
          <i class="link-icon" data-lucide="users"></i>
          <span class="link-title">Kelola Anggota</span>
        </a>
      </li>
      
      @if(auth()->user()?->hasRole(['admin', 'bph']))
      <li class="nav-item {{ active_class(['admin/blogs*', 'admin/blog-categories*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#blogMenu" role="button" aria-expanded="{{ active_class(['admin/blogs*', 'admin/blog-categories*'], 'true', 'false') }}" aria-controls="blogMenu">
          <i class="link-icon" data-lucide="file-text"></i>
          <span class="link-title">Blog Management</span>
          <i class="link-arrow" data-lucide="chevron-down"></i>
        </a>
        <div class="collapse {{ active_class(['admin/blogs*', 'admin/blog-categories*'], 'show') }}" id="blogMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ active_class(['admin/blogs*']) }}">All Posts</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.blogs.create') }}" class="nav-link">Create Post</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.blog-categories.index') }}" class="nav-link {{ active_class(['admin/blog-categories*']) }}">Categories</a>
            </li>
          </ul>
        </div>
      </li>
      @endif
      
      @if(auth()->user()?->isAdmin())
      <li class="nav-item nav-category">Admin</li>
      <li class="nav-item {{ active_class(['admin/divisions*']) }}">
        <a href="{{ route('admin.divisions.index') }}" class="nav-link">
          <i class="link-icon" data-lucide="layers"></i>
          <span class="link-title">Divisi</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['admin/roles*']) }}">
        <a href="{{ route('admin.roles.index') }}" class="nav-link">
          <i class="link-icon" data-lucide="shield-check"></i>
          <span class="link-title">Roles</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['admin/permissions*']) }}">
        <a href="{{ route('admin.permissions.index') }}" class="nav-link">
          <i class="link-icon" data-lucide="key"></i>
          <span class="link-title">Permissions</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>
