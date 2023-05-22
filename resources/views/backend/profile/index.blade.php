@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('alert'))
                <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session('alert') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">จัดการโปรไฟล์</div>

                <div class="card-body p-1">
                    <form method="POST" class="p-1" >
                        @csrf
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">ชื่อผู้ใช้ : </label>

                            <div class="col-md-6">
                                <input id="username" type="username" value="{{$self->username}}" disabled class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="current-username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="group" class="col-md-4 col-form-label text-md-end">สถานะ : </label>

                            <div class="col-md-6 d-flex justify-content-between">
                                <div class="flex-grow-1 me-1"><input id="group" type="group" value="{{$groupLabel}}" disabled class="form-control @error('group') is-invalid @enderror" name="group" required autocomplete="current-group"></div>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editGroupModal" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                @error('group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                    </form>
                    
                </div>
            </div>
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
                <form action="{{route('admin.profile_editGroup')}}" method="post" id="editGroup">
                    @csrf
                    <label for="group" class="mb-1">สถานะผู้ใช้ :</label>
                    <select name="group" id="group" class="form-select">
                        <option value="user">ผู้ใช้ปกติ</option>
                        <option value="admin" selected>ผู้ดูแล</option>
                        <option value="ban" class="text-danger">ระงับการใช้งาน</option>
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

<div class="modal fade" id="editPasswordModal" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" id="editPassword" action="{{route('admin.profile_editPassword')}}">
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


@endsection