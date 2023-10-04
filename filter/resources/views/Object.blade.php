<div>
    @foreach ($objectList as $object)
        <div class="filter-card">
            <h3>{{ $object->name }}</h3>
        </div>
    @endforeach
</div>
