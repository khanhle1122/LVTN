<section>
    <form action="{{ route('project.search') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="query" class="form-controls rounded-start" placeholder="Search">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
</section>