@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">ลงทะเบียน</div>

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{route("signupAdd")}}">
                        @csrf

                        
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="row mb-1">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">บัญชี</label>
                                </div>
                           
                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-form-label text-md-end">ชื่อผู้ใช้ : </label>
        
                                    <div class="col-md-6">
                                        <input id="username" type="username"  class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">รหัสผ่าน : </label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password"  required autocomplete="current-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">ยืนยันรหัสผ่าน : </label>
        
                                    <div class="col-md-6">
                                        <input id="password_confirmation" type="password" placeholder="Confirm password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password_confirmation">
        
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
        
                                <div class="row mb-1">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ข้อมูลส่วนตัว</label>
                                </div>  
        
                                <div class="row mb-3">
                                    <label for="fullname" class="col-md-4 col-form-label text-md-end">ชื่อ : </label>
        
                                    <div class="col-md-6">
                                        <input id="fullname" type="text" placeholder="ชื่อ - นามสกุล" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}" name="fullname" required autocomplete="current-fullname">
        
                                        @error('fullname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="cooperativeName" class="col-md-4 col-form-label text-md-end">ชื่อร้านค้า : </label>
        
                                    <div class="col-md-6">
                                        <input id="cooperativeName" type="text"  placeholder="ชื่อบริษัท"class="form-control @error('cooperativeName') is-invalid @enderror" value="{{ old('cooperativeName') }}" name="cooperativeName" required autocomplete="current-cooperativeName">
        
                                        @error('cooperativeName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                <div class="row mb-3">
                                    <label for="tel_phone" class="col-md-4 col-form-label text-md-end">เบอร์โทรศัพท์ : </label>
    
                                    <div class="col-md-6">
                                        <input id="tel_phone" type="text" placeholder="หมายเลขโทรศัพท์" class="form-control @error('tel_phone') is-invalid @enderror" value="{{ old('tel_phone') }}" name="tel_phone" required autocomplete="current-tel_phone">
    
                                        @error('tel_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="lineId" class="col-md-4 col-form-label text-md-end">ID LINE : </label>
    
                                    <div class="col-md-6">
                                        <input id="lineId" type="text" placeholder="ID LINE" class="form-control @error('lineId') is-invalid @enderror" name="lineId" value="{{ old('lineId') }}" required autocomplete="current-lineId">
    
                                        @error('lineId')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-lg-6 col-md-12">
                                                        
                       {{--          <div class="row mb-1">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ช่องทางการติดต่อ</label>
                                </div>   --}}
    
    
                                <div class="row mb-1">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ที่อยู่</label>
                                </div>  
    
                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">ที่อยู่ : </label>
    
                                    <div class="col-md-6">
                                        <input id="address" placeholder="ที่อยู่ (บ้านเลขที่/หมู่ที่/ซอย/ถนน)" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" name="address" required autocomplete="current-address">
    
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="district" class="col-md-4 col-form-label text-md-end">ตำบล : </label>
    
                                    <div class="col-md-6">
                                        <input id="district" placeholder="ตำบล" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district') }}" required autocomplete="current-district">
    
                                        @error('district')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="area" class="col-md-4 col-form-label text-md-end">อำเภอ : </label>
    
                                    <div class="col-md-6">
                                        <input id="area" placeholder="อำเภอ" type="text" class="form-control @error('area') is-invalid @enderror" name="area" required value="{{ old('area') }}" autocomplete="current-area">
    
                                        @error('area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                
                                <div class="row mb-3">
                                    <label for="Province" class="col-md-4 col-form-label text-md-end">จังหวัด : </label>
    
                                    <div class="col-md-6">
                                        <input id="Province" placeholder="จังหวัด" type="text" class="form-control @error('Province') is-invalid @enderror" name="Province"  value="{{ old('Province') }}"required autocomplete="current-area">
    
                                        @error('Province')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="PostalCode" class="col-md-4 col-form-label text-md-end">รหัสไปรษณีย์ : </label>
    
                                    <div class="col-md-6">
                                        <input id="PostalCode" placeholder="รหัสไปรษณีย์" type="text" class="form-control @error('PostalCode') is-invalid @enderror"  value="{{ old('PostalCode') }}" name="PostalCode" required autocomplete="current-PostalCode">
    
                                        @error('PostalCode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success float-end">
                            ลงทะเบียน
                        </button>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
