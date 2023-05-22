@php
    $isEmployees = Auth::user()->employees != -1 ? true:false;
@endphp

@if (!$isEmployees)
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link @if(Route::is('home')) active @endif">หน้าแรก</a>
    </li>
@endif



@if (!$isEmployees)

    <li class="nav-item">
        <a href="{{ route('categories') }}" class="nav-link @if(request()->segment(1) == 'categories' ) active @endif">ประเภทสินค้า</a>
    </li>

@endif

<li class="nav-item dropdown ">
    <a id="navbarDropdown" class="nav-link dropdown-toggle @if((request()->segment(1) == 'cashier' || request()->segment(1) == 'product') && request()->get('retail') ) active @endif" href="#" role="button"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        ค้าส่ง
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li class="nav-item">
            <a href="{{ route('cashier', ["retail" => true]) }}" class="dropdown-item @if(Route::is('cashier', ["retail" => true]) && request()->get('retail')) active @endif">ขายสินค้า</a>
        </li>


        
        @if (!$isEmployees)
            <li class="nav-item">
                <a href="{{ route('product', ['retail' => true]) }}" class="dropdown-item @if(request()->segment(1) == 'product'  && request()->get('retail')) active @endif">สินค้า</a>
            </li>
        @endif

    </ul>
</li>


<li class="nav-item dropdown ">
    <a id="navbarDropdown" class="nav-link dropdown-toggle @if((request()->segment(1) == 'cashier' || request()->segment(1) == 'product' || request()->segment(1) == 'trade' || request()->segment(1) == 'borrows')  && !request()->get('retail') ) active @endif" href="#" role="button"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        ค้าปลีก
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li class="nav-item">
            <a href="{{ route('cashier') }}" class="dropdown-item @if(Route::is('cashier')  && !request()->get('retail')) active @endif">ขายสินค้า</a>
        </li>

        @if (!$isEmployees)
            <li class="nav-item">
                <a href="{{ route('product') }}" class="dropdown-item @if(request()->segment(1) == 'product'  && !request()->get('retail')) active @endif">สินค้า</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trade') }}" class="dropdown-item @if(request()->segment(1) == 'trade' ) active @endif">ซื้อสินค้า</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('borrows') }}" class="dropdown-item @if(request()->segment(1) == 'borrows' ) active @endif" >การเบิก</a>
            </li>
        @endif
    </ul>
</li>



<li class="nav-item dropdown ">
    <a id="navbarDropdown" class="nav-link dropdown-toggle @if(request()->segment(1) == 'history' || request()->segment(1) == 'profile' || request()->segment(1) == 'report' ) active @endif" href="#" role="button"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        ร้านของฉัน
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

        @if (!$isEmployees)
            <li><a href="{{ route('history') }}" class="dropdown-item @if(request()->segment(1) == 'history' ) active @endif">ประวัติการซื้อขาย</a></li>
            <li><a href="{{ route('setting') }}" class="dropdown-item @if(request()->segment(1) == 'profile' ) active @endif">บัญชีของฉัน</a></li>
            <li><a href="{{ route('receipt') }}" class="dropdown-item @if(request()->segment(1) == 'receipt' ) active @endif">รายการใบเสร็จ</a></li>
            <li><a href="{{ route('report') }}" class="dropdown-item @if(request()->segment(1) == 'report' ) active @endif">รายงาน</a></li>
            <li><a href="{{ route('employees') }}" class="dropdown-item @if(request()->segment(1) == 'employees' ) active @endif">พนักงาน</a></li>
        @else
            <li><a href="{{ route('history') }}" class="dropdown-item @if(request()->segment(1) == 'history' ) active @endif">ประวัติการซื้อขาย</a></li>
            <li><a href="{{ route('setting') }}" class="dropdown-item @if(request()->segment(1) == 'profile' ) active @endif">บัญชีของฉัน</a></li>
        @endif


        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a href="#" data-apply-form="logout-form" class="dropdown-item">ออกจากระบบ</a>
        </li>


        {{-- FORM --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>
</li>