<section>
    <h2>Các dự án đã dánh dấu</h2>
    <div>
        <div class="scroll-container">
            @foreach($project as $project)
                @if($project->status == 1)
                    <div class="card">
                        <a href="{{ route('project.toggleStar',$project->id) }}" class="d-flex flex-row-reverse" ><i class="fa-solid fa-star" style="color: #FFD43B;"></i></a>
                        
                        <div class="circle" style="background: conic-gradient(rgb(49, 164, 7) {{$project->progress}}%, #e0e0e0 0)">
                            <span class="percentage">{{ $project->progress }}%</span>
                        </div>
                        <a href="{{ route('view.task') }}"class="task-name">{{ $project->projectName }}</a>
                        <a href="{{ route('view.task') }}"class="description">{{ $project->description }}</a>
                    </div>
                
                @endif
            @endforeach
        </div>
    </div>
    
</section>