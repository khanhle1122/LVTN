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
                      <div class="row">
                        @foreach($projects as $project)
                        <div class="col-2 ms-3  mt-3 p-1 pb-3" style="width:170px">
                          <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
                              <div class="card_k border shadow ">
                                  <div class=" ">
                                      
                                      <a href="{{ route('view.task',$project->id) }}">
                                          <div class="circle-k me-3" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                                              <span class="percentage_k">{{ $project->progress }}%</span>
                                          </div>
                                      </a>
                                      
                                      <div class="pt-3 ps-3 pb-3">
                                          
                          
                                          <div class="ms-1"><a class="text-dark" href="{{ route('view.task',$project->id) }}">Mã: {{ $project->projectCode }}</a></div>
                                          <div class="ms-1"><a class="text-dark" href="{{ route('view.task',$project->id) }}">{{ $project->projectName  }}</a> </div>
                                          @if($project->status==1)
                                          <span class="ms-1 text-success">Đã hoàng thành</span>
                                          @elseif($project->status==0)
                                          <span class="ms-1 text-primary">Đang tiến hành</span>
                                          @elseif($project->status==2)
                                          <span class="ms-1 text-danger">Đã tạm dừng</span>
                                          @else 
                                          <span class="ms-1 text-warning">Đã tạm dừng</span>
                                          @endif
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
      
    </div>
</div>
@endsection