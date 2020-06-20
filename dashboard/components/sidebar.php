    
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-tree"></i>
      </div>
      <div class="sidebar-brand-text mx-4">SPK </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li id="navDashboard" class="nav-item">
      <a class="nav-link" href="<?= $url ?>/dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Beranda</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Interface
    </div>

    <!-- Nav Item - Dataset -->
    <li id="navDataset" class="nav-item">
      <a class="nav-link" href="<?= $url ?>/dashboard/dataset">
        <i class="fas fa-fw fa-database"></i>
        <span>Dataset</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li id="navKriteria" class="nav-item">
      <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>SPK</span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">SPK:</h6>
          <a id="dropKriteria" class="collapse-item" href="<?= $url ?>/dashboard/kriteria">Kriteria</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Admin -->
    <li id="navAdmin" class="nav-item">
      <a class="nav-link" href="<?= $url ?>/dashboard/admin">
        <i class="fas fa-fw fa-user"></i>
        <span>Admin</span></a>
    </li>

    <!-- Nav Item - Laporan -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>
    <!-- End of Sidebar -->