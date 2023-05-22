@extends('layouts.app')
@php
    $isEmployees = Auth::user()->employees != -1 ? true:false;
@endphp
@section('content')

    <div class="container mt-3 py-2 ">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                @if (session('alert'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('alert') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">จัดการร้าน</div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ข้อมูลส่วนตัว</label>
                        </div>

                        <div class="row mb-2">
                            <div class="col-1"></div>
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="line-token">ชื่อร้าน :</label>
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="line-token" placeholder="ชื่อร้าน"
                                    value=" {{ session('cooperative:title') }}" disabled>
                            </div>
                            <div class="col-1"></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-1"></div>
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="line-token">ชื่อผู้จัดการ :</label>
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="line-token" placeholder="ชื่อผู้จัดการ"
                                    value=" {{ $fullname_manager }}" disabled>
                            </div>
                            <div class="col-1"></div>
                        </div>
    
                        @if ($isEmployees)
                            <div class="row mb-2">
                                <div class="col-1"></div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label for="line-token">ชื่อของคุณ :</label>
                                </div>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="line-token" placeholder="ชื่อของคุณ"
                                        value=" {{ $fullname }}" disabled>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        @endif
                        
                        <div class="row mb-2">
                            <div class="col-1"></div>
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="line-token">รหัสผ่าน :</label>
                            </div>
                            <div class="col-7">
                                <div class="d-flex gap-1">
                                    <div class="flex-grow-1"> <input type="password" value="*****************"
                                            class="form-control" name="line-token" placeholder="Password" disabled></div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editPasswordModal">แก้ไข</button>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>

                        @if (!$isEmployees)
                            <div class="row mb-2">
                                <div class="col-1"></div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label for="ageEnd">วันหมดอายุ :</label>
                                </div>
                                <div class="col-7">
                                    <input type="text" class="form-control" value="{{ $aAge }}" name="ageEnd" placeholder="วันหมดอายุ" readonly>
                                </div>
                                <div class="col-1"></div>
                            </div>    

                            <div class="row mb-2">
                                <div class="col-1"></div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label for="line-token">Line Notification :</label>
                                </div>
                                <div class="col-7">
                                    <div class="d-flex gap-1">
                                        <div class="flex-grow-1"> <input type="password" value="{{$lineToken}}"
                                                class="form-control" name="line-token" placeholder="-" disabled></div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editNotification">แก้ไข</button>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        @endif



    


                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ช่องทางการติดต่อ</label>
                        </div>

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">เบอร์โทรศัพท์ : </label>

                      {{--       <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['tel']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div> --}}

                            <div class="col-7">
                                <div class="d-flex gap-1">
                                    <div class="flex-grow-1"> 
                                        <input type="text" value="{{$data['tel']}}"
                                            class="form-control" name="tel" placeholder="-" disabled>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#telphoneModal">แก้ไข</button>
                                </div>
                                @error('tel')
                                    <span class="text-danger mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">LINE ID : </label>
                            <div class="col-7">
                                <div class="d-flex gap-1">
                                    <div class="flex-grow-1"> <input type="text" value="{{$data['lineId']}}"
                                            class="form-control" name="line-token" placeholder="-" disabled></div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#lineIdModal">แก้ไข</button>
                                </div>
                                @error('tel')
                                    <span class="text-danger mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

         
                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ที่อยู่ <a href="" data-bs-toggle="modal" data-bs-target="#addressEditModal"><i class="fa-solid fa-pencil"></i></a></label>
                        </div>

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">ที่อยู่ : </label>

                            <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['address']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">ตำบล : </label>

                            <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['district']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">อำเภอ : </label>

                            <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['area']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">จังหวัด : </label>

                            <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['province']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="dummy" class="col-md-4 col-form-label text-md-end">รหัสไปรษณีย์ : </label>

                            <div class="col-md-7 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="dummy" value="{{$data['postalcode']}}" type="text" disabled class="form-control @error('dummy') is-invalid @enderror" name="dummy" required autocomplete="current-dummy"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="-" class="col-md-4"></label>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
<div class="modal fade" id="editPasswordModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" id="editPassword" action="{{route('setting_updatePassword')}}">
                    @csrf
                    <label for="passwordOld" class="mb-1">รหัสผ่านเก่า : </label>
                    <input type="password" class="form-control mb-2  @error('username') is-invalid @enderror" name="passwordOld" placeholder="รหัสผ่านเก่า" required>
                    @error('passwordOld')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(()=>{
                                $('#editPasswordModal').modal('show');
                            })
                        </script>
                    @enderror
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

<div class="modal fade" id="editNotification" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Line Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('updateLineNotification')}}" method="post" id="editLineNotification">
                    @csrf

                    <label for="lineToken" class="mb-1">Line Notification : </label>
                    <input type="text" name="lineToken" autocomplete="" placeholder="LINE TOKEN" value="{{$lineToken}}" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="editLineNotification">ยืนยัน</button>
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
                <form  action="{{route('setting_updateTel')}}" method="post" id="editTelForm">
                    @csrf
                    <label for="group" class="mb-1">เบอร์โทรศัพท์ :</label>
                    <input type="text" name="tel" value="{{$data['tel']}}" class="form-control" placeholder="เบอร์โทรศัพท์">
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
                <form  action="{{route('setting_updateLineId')}}" method="post" id="lineIdForm">
                    @csrf
                    <label for="group" class="mb-1">LINE ID :</label>
                    <input type="text" name="lineId" class="form-control" value="{{$data['lineId']}}" placeholder="@LINE ID">
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
                <form  action="{{route('setting_updateAddress')}}"  method="post" id="addressEditForm">
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
