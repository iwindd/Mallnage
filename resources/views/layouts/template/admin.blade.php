<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        บัญชีของฉัน
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li><a href="{{ route('admin.profile') }}" class="dropdown-item">จัดการบัญชี</a></li>
        <li><a href="#" data-apply-form="logout-form" class="dropdown-item">ออกจากระบบ</a>
        </li>


        {{-- FORM --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>
</li>
