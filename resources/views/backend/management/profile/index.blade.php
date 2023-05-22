@extends('layouts.app')

@section('content')
    <div class="container mt-3 py-2 ">
        <header>
            <h1 class="h2">ผู้ใช้ : {{@session('management:name')}}</h1>
            <hr>
        </header>

        <div class="row">
            <div class="col-sm-12 col-lg-3 mb-3">
                @include('backend.management.layouts.menu')
            </div>
            <div class="col-sm-12 col-lg-9 pe-4">
                @if (session('alert'))
                    <div class="alert alert-{{session('alert-type')}} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('alert') }}
                    </div>
                @endif


                @php
                    $data = session('management:data');
                @endphp

                <section>
                    <div class="card">
                        <div class="card-header">จัดการโปรไฟล์</div>
        
                        <div class="card-body p-2">
                            
                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ข้อมูลส่วนตัว</label>
                            </div>

                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-form-label text-md-end">ชื่อผู้ใช้ : </label>
    
                                <div class="col-md-6">
                                    <input id="username" type="text" value="{{@session('management:name')}}" disabled class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="current-username">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fullname" class="col-md-4 col-form-label text-md-end">ชื่อผู้ดูแล : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="group" value="{{@session('management:fullname')}}" type="text" disabled class="form-control @error('fullname') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editManageFullName" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>
           
                            <div class="row mb-3">
                                <label for="fullname" class="col-md-4 col-form-label text-md-end">ชื่อร้าน : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="group" value="{{@session('management:callname')}}" type="text" disabled class="form-control @error('fullname') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editManageName" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="startDate" class="col-md-4 col-form-label text-md-end">เริ่มใช้งานวันที่ : </label>
    
                                <div class="col-md-6">
                                    <input id="startDate" type="text" value="{{$created_at}}" disabled class="form-control @error('startDate') is-invalid @enderror" name="startDate" required autocomplete="current-startDate">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="group" class="col-md-4 col-form-label text-md-end">ระดับผู้ใช้งาน : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="group" value="{{$groupLabel}}" type="text" disabled class="form-control @error('group') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editGroupModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="grade" class="col-md-4 col-form-label text-md-end">บริการ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="grade" value="{{$gradeLabel}}" type="text" disabled class="form-control @error('grade') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editGradeModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Allowed" class="col-md-4 col-form-label text-md-end">สถานะ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="Allowed" @if (session('management:allowed') == 1)
                                        value="อนุมัติการใช้งาน"
                                    @else
                                        value="ไม่อนุมัติการใช้งาน"
                                    @endif type="text" disabled class="form-control @error('Allowed') is-invalid @enderror" name="Allowed" required autocomplete="current-Allowed"></div>
                                    <form action="{{route('admin.user_toggleAllowed')}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-shuffle"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="group" class="col-md-4 col-form-label text-md-end">วันหมดอายุ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="aAge" value="{{$accountAgeText}}" type="text" disabled class="form-control @error('aAge') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editAgeModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">รหัสผ่าน : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="password" type="password" value="*********" disabled class=" form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editPasswordModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ช่องทางการติดต่อ</label>
                            </div>

    {{--                         <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end"> : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy"  type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>
                             --}}


                            <div class="row mb-3">
                                <label for="telphone" class="col-md-4 col-form-label text-md-end">เบอร์โทรศัพท์ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="telphone" value="{{$data['tel']}}" type="text" disabled class="form-control @error('tel') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#telphoneModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="lineId" class="col-md-4 col-form-label text-md-end">LINE ID : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="telphone" value="{{$data['lineId']}}" type="text" disabled class="form-control @error('lineId') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#lineIdModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ที่อยู่ <a href="" data-bs-toggle="modal" data-bs-target="#addressEditModal"><i class="fa-solid fa-pencil"></i></a></label>
                            </div>

                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end">ที่อยู่ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['address']}}" type="text" disabled class="form-control @error('address') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end">ตำบล : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['district']}}" type="text" disabled class="form-control @error('district') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end">อำเภอ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['area']}}" type="text" disabled class="form-control @error('area') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end">จังหวัด : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['province']}}" type="text" disabled class="form-control @error('province') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="dummy" class="col-md-4 col-form-label text-md-end">รหัสไปรษณีย์ : </label>
    
                                <div class="col-md-6 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['postalcode']}}" type="text" disabled class="form-control @error('postalcode') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<div class="modal fade" id="editGroupModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขสถานะ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user_editGroup')}}" method="post" id="editGroup">
                    @csrf
                    <label for="group" class="mb-1">สถานะผู้ใช้ :</label>
                    <select name="group" id="groupSelect" class="form-select">

                        <option value="user"  {{($isAdmin == 0 ? 'selected':'')}}>ผู้ใช้ปกติ</option>
                        <option value="admin" {{($isAdmin == 1 ? 'selected':'')}}>ผู้ดูแล</option>
                        <option value="ban"   {{($isAdmin == -1 ? 'selected':'')}} class="text-danger">ระงับการใช้งาน</option>
                    </select>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" data-apply-form="editGroup">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editManageFullName" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขชื่อผู้จัดการ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user_editFullname')}}" method="post" id="editFullname">
                    @csrf
                    <label for="group" class="mb-1">ชื่อผู้จัดการที่ต้องการจะเปลี่ยน :</label>
                    <input type="text" name="Fullname" class="form-control" placeholder="กรุณาป้อนชื่อผู้จัดการ">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editFullname">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editManageName" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขชื่อร้าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user_editCooperativeName')}}" method="post" id="editCooperativeName">
                    @csrf
                    <label for="group" class="mb-1">ชื่อผู้ร้านที่ต้องการจะเปลี่ยน :</label>
                    <input type="text" name="name" class="form-control" placeholder="กรุณาป้อนชื่อร้าน">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editCooperativeName">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editGradeModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขระดับผู้ใช้</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user_editGrade')}}" method="post" id="editGrade">
                    @csrf
                    <label for="group" class="mb-1">ระดับผู้ใช้งาน :</label>
                    <select name="group" id="gradeSelect" class="form-select">
                        <option value="basic"  {{($grade == 0 ? 'selected':'')}}>Basic</option>
                        <option value="pro" {{($grade == 1 ? 'selected':'')}}>Pro</option>
                    </select>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editGrade">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editAgeModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขวันหมดอายุ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user_editAccountAge')}}" method="post" id="editAccountAge">
                    @csrf
                    <label for="SelectAge" class="mb-1">ระดับผู้ใช้งาน :</label>
             
                    @php
                        $aAgeFormat = new DateTime($accountAge);
                        $aAgeFormat = $aAgeFormat->format('Y-m-d');
                        
                    @endphp
                    <input type="date" name="SelectAge" id="SelectAge" min="{{ now()->toDateString('Y-m-d') }}" value="{{$aAgeFormat}}" class="form-control" placeholder="dd-mm-yy" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editAccountAge">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editPasswordModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" id="editPassword" action="{{route('admin.user_editPassword')}}">
                    @csrf
                    <label for="passwordNew" class="mb-1">รหัสผ่านใหม่ : </label>
                    <input type="password" class="form-control mb-2  @error('username') is-invalid @enderror" name="passwordNew" placeholder="รหัสผ่านใหม่" required>
                    @error('passwordNew')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(()=>{
                                $('#editPasswordModal').modal('show');
                            })
                        </script>
                    @enderror

                    <label for="passwordNew_confirmation" class="mb-1">รหัสผ่านใหม่ : </label>
                    <input type="password" class="form-control mb-2  @error('username') is-invalid @enderror" name="passwordNew_confirmation" placeholder="ยืนยันรหัสผ่านใหม่" required>
                    @error('passwordNew_confirmation')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(()=>{
                                $('#editPasswordModal').modal('show');
                            })
                        </script>
                    @enderror
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" data-apply-form="editPassword">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="telphoneModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขเบอร์โทรศัพท์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action="{{route('admin.user_editTel')}}" method="post" id="editTelForm">
                    @csrf
                    <label for="group" class="mb-1">เบอร์โทรศัพท์ :</label>
                    <input type="text" name="tel" class="form-control" placeholder="เบอร์โทรศัพท์">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editTelForm">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lineIdModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไข LINE ID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action="{{route('admin.user_editlineId')}}" method="post" id="lineIdForm">
                    @csrf
                    <label for="group" class="mb-1">LINE ID :</label>
                    <input type="text" name="lineId" class="form-control" placeholder="@LINE ID">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="lineIdForm">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addressEditModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขที่อยู่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action="{{route('admin.user_addressEdit')}}"  method="post" id="addressEditForm">
                    @csrf
                    <div class="row mb-3">
                        <label for="dummy" class="col-md-12 col-form-label text-md-start">ที่อยู่ : </label>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['address']}}" name="address" type="text"  class="form-control @error('address') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="dummy" class="col-md-12 col-form-label text-md-start">ตำบล : </label>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['district']}}" name="district" type="text"  class="form-control @error('district') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="dummy" class="col-md-12 col-form-label text-md-start">อำเภอ : </label>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['area']}}" type="text" name="area"  class="form-control @error('area') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="dummy" class="col-md-12 col-form-label text-md-start">จังหวัด : </label>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['province']}}" type="text" name="province"  class="form-control @error('province') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="dummy" class="col-md-12 col-form-label text-md-start">รหัสไปรษณีย์ : </label>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['postalcode']}}" type="text" name="postalcode"  class="form-control @error('postalcode') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="addressEditForm">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

@endsection