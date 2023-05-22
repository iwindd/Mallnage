@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">เพิ่มผู้ใช้ใหม่</div>
                <div class="card-body">
                    <form  action="{{route('admin.user_add')}}" id="addusersform" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">ชื่อผู้ใช้ : </label>
                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="ชื่อผู้ใช้" required  autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fullname" class="col-md-4 col-form-label text-md-end">ชื่อผู้ดูแล : </label>
                            <div class="col-md-6">
                                <input id="fullname" type="fullname" class="form-control @error('fullname') is-invalid @enderror" name="fullname" placeholder="ชื่อผู้ดูแล" required  autofocus>
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อร้านค้า : </label>
                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="ชื่อร้านค้า" required  autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="group" class="col-md-4 col-form-label text-md-end">สถานะผู้ใช้ :</label>
                            <div class="col-md-6">
                                <select name="group" id="group" class="form-select" >
                                    <option value="user">ผู้ใช้ปกติ</option>
                                    <option value="admin">ผู้ดูแล</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="grade" class="col-md-4 col-form-label text-md-end">ระดับผู้ใช้งาน :</label>
                            <div class="col-md-6">
                                <select name="grade" id="grade" class="form-select">
                                    <option value="basic">Basic</option>
                                    <option value="pro">Pro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="group" class="col-md-4 col-form-label text-md-end">วันหมดอายุ :</label>
                            <div class="col-md-6">
                                <input type="date" name="AccountAge" id="AccountAge" class="form-control" placeholder="dd-mm-yy" required> 
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="line_token" class="col-md-4 col-form-label text-md-end">@LINE TOKEN : </label>
                            <div class="col-md-6">
                                <input id="line_token" placeholder="@LINE TOKEN" type="line_token" class="form-control @error('line_token') is-invalid @enderror" name="line_token"   autofocus>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{route('admin.home')}}">กลับ</a>
                    <button type="submit" class="btn btn-success" form="addusersform">เพิ่มผู้ใช้งาน</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('footer')

<script>
        const getCurrentDate = () => {
            const date = new Date();

            const year = date.getFullYear();
            const day = date.getDate() <= 9 ? (`0${date.getDate()}`) : (date.getDate());
            const month = (date.getMonth()+1) <= 9 ? (`0${date.getMonth()}`) : ((date.getMonth()+1));

            return `${year}-${month}-${day}`
        }

        $(document).ready(() => {
            const AccountAge   = $(`#AccountAge`);
            AccountAge.attr('min', getCurrentDate());

        })

</script>

@endsection