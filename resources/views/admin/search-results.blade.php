@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
  
    <div class="row ">
        {{-- không có kết quả --}}
        @if($projects->isEmpty() && $users->isEmpty() && $files->isEmpty() && $divisions->isEmpty() && $clients->isEmpty() && $tasks->isEmpty())   
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body"> 
                  <div class="py-12">
              
                      <div class="h2">Kết quả tìm kiếm cho từ khóa: "{{ $query }}"</div>
                        <div class="mt-3">Không tìm thấy</div>
                      
                  </div>
                </div>
            </div>
          </div>
          {{-- có kết quả --}}
          @else
          <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body"> 
                  <div class="py-12">
              
                      <div class="h2">Kết quả tìm kiếm cho từ khóa: "{{ $query }}"</div>
  
                      
                  </div>
                </div>
            </div>
          </div>
          @if($projects->isNotEmpty())

          <div class="col-md-12 col-xl-12 mt-4">
              <div class="card">
                  <div class="card-body"> 
                        <div class="py-12">
                            <h3>Dự án</h3>
    
        
                            
                            <div class="row">
                                @foreach($projects as $project)
                                <div class="col-2 border mt-3 p-1 pb-3" style="width:180px">
                                    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
                                        <div class="card_k  ">
                                            <div class=" ">
                                                <div>
                                                    <a href="{{ route('project.toggleStar',$project->id) }}" class="float-end me-2 " > @if( $project->toggleStar == 1) <i class="fa-solid fa-star" style="color: #FFD43B;"></i> @else <i class="fa-regular fa-star" ></i>  @endif </a>
                                                    
                                                </div>
                                                <div class="circle-k me-3" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                                                    <span class="percentage_k">{{ $project->progress }}%</span>
                                                </div>
                                                
                                                <div class="">
                                                    @if($project->status==1)
                                                    <span class=" text-success">Đã hoàng thành</span>
                                                    @endif
                                    
                                                    <div class="ms-1">Mã: {{ $project->projectCode }}</div>
                                                    <div class="ms-1"><a class="text-dark" href="{{ route('view.task',$project->id) }}">{{ $project->projectName  }}</a> </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                
                                
                                @endforeach
                            </div>
                        </div>
                    </div>
              </div>
              
            </div>
            @endif
            @if($users->isNotEmpty())

            <div class="col-md col-xl mt-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="py-12">
                        <h3>Người dùng</h3>
                                <ul>
                                    @foreach($users as $user)
                                        <li>{{ $user->name }} - {{ $user->email }}</li>
                                    @endforeach
                                </ul>

                                
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($files->isNotEmpty())
            <div class="col-md col-xl mt-4">
                <div class="card">
                    <div class="card-body"> 
                        <h3>Tài liệu</h3>
                        <div class="py-12 mt-2">
                            @foreach($files as $file)
                                @php
                                    // Lấy đuôi mở rộng của file
                                    $extension = pathinfo($file->filePath, PATHINFO_EXTENSION);
                                @endphp
                                    <div class="row">
                                        <div class=" col-10">
                                            <i class="text-muted icon-sm ms-4"  data-feather="file"></i>
                                            {{-- <a href="{{ Storage::url( $file->filePath ) }}" target="_blank" class="mx-2">{{ $file->fileName }}</a> --}}
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                                            <!-- Hiển thị trực tiếp trên trình duyệt -->
                                                <a href="{{ Storage::url($file->filePath) }}" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                            @else
                                                <!-- Sử dụng Google Docs Viewer cho file không hỗ trợ -->
                                                <a href="https://docs.google.com/viewer?url={{ urlencode(Storage::url($file->filePath)) }}&embedded=true" target="_blank" class="mx-2">{{ $file->fileName }}</a>
                                            @endif
                                        </div>
                                        <div class="col-1">
                                            
                                        </div>
                                        <div class="col-1 d-flex">
                                            <div>
                                                <a href="{{ Storage::url($file->filePath) }} " download>
                                                    <i class="icon-sm text-danger ms-1 me-2" data-feather="download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($clients->isNotEmpty())

            <div class="col-md col-xl mt-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="py-12">
                        <h3>Khách hành</h3>
                                <ul>
                                    @foreach($clients as $client)
                                        <li>{{ $client->name }}</li>
                                    @endforeach
                                </ul>

                                
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($divisions->isNotEmpty())

            <div class="col-md col-xl mt-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="py-12">
                            <h3>Nhóm </h3>
                            <div class="mt-2">
                                @foreach($divisions as $division)
                                    <div class=" ms-2">
                                        <span>{{ $division->divisionName }}</span>
                                        <div>
                                            @foreach(App\Models\User::where('divisionID',$division->id)->get() as $user)
                                                <div class="ms-5">{{ $user->name }}</div>

                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                                
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($tasks->isNotEmpty())

            <div class="col-md col-xl mt-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="py-12">
                        <h3>Công việc</h3>
                                <ul>
                                    @foreach($tasks as $task)
                                        <li>{{ $task->task_name }}</li>
                                    @endforeach
                                </ul>

                                
                        </div>
                    </div>
                </div>
            </div>
            @endif


        @endif
      
    </div>
</div>
@endsection