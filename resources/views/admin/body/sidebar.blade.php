<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i> <span>Dashboard</span>
                    </a>
                </li>


                @can('manage.supplier.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-truck-moving"></i> <span>Manage Suppliers</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @can('supplier.list')
                        <li><a href="{{ route('supplier.all') }}">All Supplier</a></li>
                        @endcan
                    </ul>

                </li>
                @endcan

                @can('manage.customer.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-circle"></i> <span>Manage Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    @can('customer.list')
                        <li><a href="{{ route('customer.all') }}">All Customer</a></li>
                    @endcan
                    @can('credit.customer.submenu')
                        <li><a href="{{ route('credit.customer') }}">Credit Customer</a></li>
                    @endcan
                    @can('paid.customer.submenu')
                        <li><a href="{{ route('paid.customer') }}">Paid Customer</a></li>
                    @endcan
                    @can('customer.wise.report.submenu')
                        <li><a href="{{ route('customer.wise.report') }}">Customer Wise Report</a></li>
                    @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.unit.menu')
                <li>

                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-balance-scale"></i> <span>Manage Units</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @can('unit.list')
                        <li><a href="{{ route('unit.all') }}">All Unit</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.category.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tags"></i> <span>Manage Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('category.list')
                        <li><a href="{{ route('category.all') }}">All Category</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.product.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-shopping-cart"></i> <span>Manage Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('product.list')
                        <li><a href="{{ route('product.all') }}">All Porduct</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.purchase.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-shopping-bag"></i> <span>Manage Purchase</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('all.purchase.submenu')
                        <li><a href="{{ route('purchase.all') }}">All Purchase</a></li>
                        @endcan
                        @can('approval.purchase.submenu')
                        <li><a href="{{ route('purchase.pending') }}">Approval Purchase</a></li>
                        @endcan
                        @can('daily.purchase.report.submenu')
                        <li><a href="{{ route('daily.purchase.report') }}">Daily Purchase Report</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.invoice.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Manage Invoice</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('all.invoice.submenu')
                        <li><a href="{{ route('invoice.all') }}">All Invoice</a></li>
                        @endcan
                        @can('approval.invoice.submenu')
                        <li><a href="{{ route('invoice.pending.list') }}">Approval Invoice</a></li>
                        @endcan
                        @can('print.invoice.list.submenu')
                        <li><a href="{{ route('print.invoice.list') }}">Print Invoice List</a></li>
                        @endcan
                        @can('daily.invoice.report.list')
                        <li><a href="{{ route('daily.invoice.report') }}">Daily Invoice Report</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan


                @can('manage.stock.menu')
                <li class="menu-title">Stock</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-dolly"></i> <span>Manage Stock</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('stock.report.submenu')
                        <li><a href="{{ route('stock.report') }}">Stock Report</a></li>
                        @endcan
                        @can('supplier.product.wise.submenu')
                        <li><a href="{{ route('stock.supplier.wise') }}">Supplier / Product Wise</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.role.permission.menu')
                <li class="menu-title">Roles & Permission</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-shield"></i> <span>Roles & Permission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('all.permission.submenu')
                        <li><a href="{{ route('permissions') }}">All Permissions</a></li>
                        @endcan
                        @can('all.role.submenu')
                        <li><a href="{{ route('roles') }}">All Roles</a></li>
                        @endcan
                        @can('')
                        <li><a href="{{ route('role.permissions.create') }}">Assign Permissions</a></li>
                        @endcan
                        @can('all.role.has.permission.submenu')
                        <li><a href="{{ route('role.permissions') }}">All Roles Has Permissions</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage.admin.menu')
                <li class="menu-title">Admin</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-cog"></i> <span>Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('admin.list')
                        <li><a href="{{ route('admin.all') }}">All Admin</a></li>
                        @endcan
                        @can('admin.add')
                        <li><a href="{{ route('admin.add') }}">Add Admin</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Utility</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-directory.html">Directory</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
