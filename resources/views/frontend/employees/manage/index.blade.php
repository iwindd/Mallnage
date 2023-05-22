@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>

    <style>
        .hover-slide{
            transform: translateX(60%) !important;
            transition: transform 0.2s ease;
        }

        li.list-group-item:hover .hover-slide{
            transform: translateX(0%) !important;
        }

        li.list-group-item{
            cursor: pointer;
        }
    </style>
    
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('employees')}}" class="text-decoration-none">พนักงาน</a></li>
                <li class="breadcrumb-item active" aria-current="page">แก้ไขพนักงาน {{$data->fullname}}</li>
            </ol>
        </div>
    </nav>

    <div class="container  mt-1 pt-3">
        <section class=" mx-auto">
            <div class="card">
                <div class="card-header">เพิ่มพนักงาน</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('status') }}
                        </div>
                    @endif
                    <form  method="POST"  id="saveProduct">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="row mb-3">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ข้อมูลส่วนตัว</label>
                                </div>
        
                                <div class="row mb-2">
                                    <div class="col-1"></div>
                                    <div class="col-3 d-flex justify-content-end align-items-center">
                                        <label for="fullname">ชื่อ :</label>
                                    </div>
                                    <div class="col-7">
                                       
                                        <input type="text" class="form-control" name="fullname" value="{{$data->fullname}}" placeholder="ชื่อ - นามสกุล" required>
                                        @error('fullname')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-1"></div>
                           
                                </div>
        
                                <div class="row mb-2">
                                    <div class="col-1"></div>
                                    <div class="col-3 d-flex justify-content-end align-items-center">
                                        <label for="username">ชื่อผู้ใช้ :</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control" value="{{$data->username}}"  disabled name="username" value="{{old('username')}}" placeholder="Username" required
                                             >
                                        @error('username')
                                             <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-1"></div>
                                </div>
            
        
                                
                                <div class="row mb-2">
                                    <div class="col-1"></div>
                                    <div class="col-3 d-flex justify-content-end align-items-center">
                                        <label for="password">รหัสผ่าน :</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="d-flex gap-1">
                                            <div class="flex-grow-1"> <input type="password" 
                                                    class="form-control" name="password" value="*****************" disabled placeholder="Password"  required></div> 
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editPasswordModal">แก้ไข</button>
                                        </div>
                                        @error('password')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-1"></div>
                                </div>
    
        
            
        
        
                                <div class="row mb-3">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ช่องทางการติดต่อ</label>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="tel" class="col-md-4 col-form-label text-md-end">เบอร์โทรศัพท์ : </label>
        
                        
        
                                    <div class="col-7">
                                        <div class="d-flex gap-1">
                                            <div class="flex-grow-1"> 
                                                <input type="text" 
                                                    class="form-control" name="tel" value="{{$data->tel}}"  required>
                                            </div>
                                        </div>
                                        @error('tel')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="line_id" class="col-md-4 col-form-label text-md-end">LINE ID : </label>
                                    <div class="col-7">
                                        <div class="d-flex gap-1">
                                            <div class="flex-grow-1"> <input type="text" 
                                                    class="form-control" name="line_id"  value="{{$data->lineId}}"   required></div>
                                        </div>
                                        @error('line_id')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
    
             
                            <div class="col-lg-6 col-md-12">
    
                                <div class="row mb-3">
                                    <label for="dummy" class="col-md-4 col-form-label text-md-end text-muted">ที่อยู่ </label>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">ที่อยู่ : </label>
    
                                    <div class="col-md-7 justify-content-between">
                                        <div class="flex-grow-1 me-1"><input id="dummy"  type="text"  value="{{$data->address}}"  class="form-control @error('dummy') is-invalid @enderror" name="address" required autocomplete="current-dummy"></div>
                                        @error('address')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
    
                                <div class="row mb-3">
                                    <label for="district" class="col-md-4 col-form-label text-md-end">ตำบล : </label>
    
                                    <div class="col-md-7  justify-content-between">
                                        <div class="flex-grow-1 me-1"><input id="dummy"  type="text"   value="{{$data->district}}" class="form-control @error('dummy') is-invalid @enderror" name="district" required autocomplete="current-dummy"></div>
                                        @error('district')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="area" class="col-md-4 col-form-label text-md-end">อำเภอ : </label>
    
                                    <div class="col-md-7  justify-content-between">
                                        <div class="flex-grow-1 me-1"><input id="dummy"  type="text"  value="{{$data->area}}" class="form-control @error('dummy') is-invalid @enderror" name="area" required autocomplete="current-dummy"></div>
                                        @error('area')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label for="province" class="col-md-4 col-form-label text-md-end">จังหวัด : </label>
    
                                    <div class="col-md-7 justify-content-between">
                                        <div class="flex-grow-1 me-1"><input id="dummy"  type="text"   value="{{$data->province}}" class="form-control @error('dummy') is-invalid @enderror" name="province" required autocomplete="current-dummy"></div>
                                        @error('province')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="postalcode" class="col-md-4 col-form-label text-md-end">รหัสไปรษณีย์ : </label>
    
                                    <div class="col-md-7 justify-content-between">
                                        <div class="flex-grow-1 me-1"><input id="dummy"  type="text"  value="{{$data->postalcode}}" class="form-control @error('dummy') is-invalid @enderror" name="postalcode" required autocomplete="current-dummy"></div>
                                        @error('postalcode')
                                            <span class="text-danger mt-1">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="target" value="{{$data->id}}">
    
                                <div class="row mb-3">
                                    <label for="-" class="col-md-4"></label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class=" d-flex gap-1 justify-content-end">
                        <button type="submit" form="saveProduct" class="btn btn-success">บันทึก</button>


                    </div>
                </div>
            </div>
            
        </section>


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
                    <form  method="post" id="editPasswordOnly" action="{{route('employeesEditPassword')}}">
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

                        <input type="hidden" name="target" value="{{$data->id}}">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" form="editPasswordOnly">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
@endsection