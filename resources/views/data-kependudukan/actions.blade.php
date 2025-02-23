<a href="{{ $editUrl }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
<form action="{{ $deleteUrl }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
</form>
