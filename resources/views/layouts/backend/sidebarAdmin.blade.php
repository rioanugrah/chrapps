<li>
    <a href="{{ route('dashboard.index') }}">
        {{-- <i data-feather="home"></i> --}}
        <i class="mdi mdi-home"></i>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('product.index') }}">
        <i class="fas fa-folder-plus"></i>
        <span>Products</span>
    </a>
</li>
<li>
    <a href="{{ route('order.index') }}">
        <i class="fas fa-box-open"></i>
        <span>Orders</span>
    </a>
</li>
<li>
    <a href="{{ route('service.index') }}">
        <i class="fas fa-concierge-bell"></i>
        <span>Services</span>
    </a>
</li>

<li class="menu-title" data-key="t-menu">Mikrotik</li>

<li>
    <a href="{{ route('getInterfaces') }}">
        <i class="mdi mdi-home"></i>
        <span>Interfaces</span>
    </a>
</li>
<li>
    <a href="index.html">
        <i class="mdi mdi-home"></i>
        <span>Bridge</span>
    </a>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <i class="mdi mdi-home"></i>
        <span>PPP</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li><a href="{{ route('getPPPSecret') }}">Secret</a></li>
        <li><a href="{{ route('getPPPProfile') }}">Profile</a></li>
        <li><a href="{{ route('getPPPActiveConnection') }}">Active Connections</a></li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <i class="mdi mdi-home"></i>
        <span data-key="t-maps">IP</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li><a href="{{ route('getIpAddresses') }}">Addresses</a></li>
        <li><a href="{{ route('mikrotik.dns') }}">DNS</a></li>
        <li><a href="#">Firewall</a></li>
        <li><a href="{{ route('getPool') }}">Pool</a></li>
        <li><a href="#">Web Proxy</a></li>
    </ul>
</li>
<li class="menu-title" data-key="t-menu">Configurations</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <i class="mdi mdi-home"></i>
        <span data-key="t-maps">User Management</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li><a href="{{ route('admin.users') }}">Users</a></li>
        <li><a href="{{ route('admin.roles') }}">Roles</a></li>
        <li><a href="{{ route('admin.permission') }}">Permissions</a></li>
    </ul>
</li>
<li>
    <a href="{{ route('server.index') }}">
        <i class="mdi mdi-home"></i>
        <span>Servers</span>
    </a>
</li>
