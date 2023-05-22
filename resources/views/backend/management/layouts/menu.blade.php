<div class="list-group">
    <a href="{{route('admin.managements')}}" class="list-group-item list-group-item-action @if(Route::is('admin.managements')) active @endif">โปรไฟล์</a>
    <a href="{{route('admin.managements.product')}}" class="list-group-item list-group-item-action @if(Route::is('admin.managements.product') || Route::is('admin.managements.product.view')) active @endif @if (@session('management:group') == 1 ) disabled @endif">สินค้า</a>
    <a href="{{route('admin.managements.history')}}" class="list-group-item list-group-item-action @if(Route::is('admin.managements.history') || Route::is('admin.managements.history.view')) active @endif @if (@session('management:group') == 1 ) disabled @endif">ประวัติการซื้อขาย</a>
    <a href="{{route('admin.managements.receipt')}}" class="list-group-item list-group-item-action @if(Route::is('admin.managements.receipt') || Route::is('admin.managements.receipt.view')) active @endif @if (@session('management:group') == 1 ) disabled @endif">ใบกำกับภาษี</a> 
</div>

