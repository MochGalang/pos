<nav class="mt-2">
  <!--begin::Sidebar Menu-->
  <ul
    class="nav sidebar-menu flex-column"
    data-lte-toggle="treeview"
    role="navigation"
    aria-label="Main navigation"
    data-accordion="false"
    id="navigation">
    <li class="nav-item menu-open">
      <a href="{{ url('/') }}" class="nav-link active">
        <i class="nav-icon bi bi-house"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('categories') }}" class="nav-link active">
        <i class="nav-icon bi bi-tag-fill"></i>
        <p>
          Category
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('mobil') }}" class="nav-link active">
        <i class="nav-icon bi bi-bag"></i>
        <p>
          Product
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('member') }}" class="nav-link active">
        <i class="nav-icon bi bi-person"></i>
        <p>
          Member
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('order') }}" class="nav-link active">
        <i class="nav-icon bi bi-basket-fill"></i>
        <p>
          Order
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('order_detail') }}" class="nav-link active">
        <i class="nav-icon bi bi-envelope"></i>
        <p>
          Order Detail
        </p>
      </a>
    </li>
  </ul>
  <!--end::Sidebar Menu-->
</nav>