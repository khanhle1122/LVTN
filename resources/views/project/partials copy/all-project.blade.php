
<section>
    <h2 class="mt-4">Các dự án </h2>
    <div>
        <div class="d-flex flex-wrap ms-4">
            @foreach($project as $project)
            
                <div class="card  mt-4 me-4">
                    <a href="{{ route('project.toggleStar',$project->id) }}" class="d-flex flex-row-reverse" ><i class="fa-solid fa-star" @if( $project->status == 1) style="color: #FFD43B; @endif "></i></a>
                    
                    <div class="circle" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                        <span class="percentage">{{ $project->progress }}%</span>
                    </div>
                    <a href="{{ route('view.task') }}" class="task-name">{{ $project->projectName }}</a>
                    <a href="{{ route('view.task') }}" class="description">{{ $project->description }}</a>
                </div>
            
            
            @endforeach
        </div>
    </div>
</section>
