<div class="list-group mb-2">
    <a href="{{route('report')}}" class="list-group-item list-group-item-action      @if(Route::is('report')) active @endif">รายงาน</a>
    <a href="{{route('reportMost')}}" class="list-group-item list-group-item-action  @if(Route::is('reportMost')) active @endif">ทำยอดขายได้มากที่สุด</a>
    <a href="{{route('reportLeast')}}" class="list-group-item list-group-item-action @if(Route::is('reportLeast')) active @endif">ทำยอดขายได้น้อยที่สุด</a>
</div>

