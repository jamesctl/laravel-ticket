{{-- <a href="{{ route('admin.ticket.edit', $item->id) }}"><i
    class="bx bx-edit-alt"></i>
</a> --}}
<a href="javascript:void(0);" data-toggle="modal" data-target="#editModal" onclick="openEditModal({{ $item->id }})">
    <i class="bx bx-edit-alt"></i>
</a>


{{ html()->form('delete', route('admin.ticket.destroy', $item->id))->class('d-inline')->open() }}
<button class="btn text-danger confirm-button p-0">
    <i class="bx bx-x"></i>
</button>
{{ html()->form()->close() }}