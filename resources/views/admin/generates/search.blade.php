@foreach($generates as $generate)
    <tr>
        @can('generates-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $generate->id }}" data-url="{{ route('admin.generates.delete-all') }}">
                <i class="{{ request('id') == $generate->id ? 'fas fa-bell text-red' : '' }}"></i>
            </td>
        @endcan
        <td>{{ ($generates->perPage() * ($generates->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ optional($generate->user)->name }}</td>
        {{-- <td>{{ optional($generate->category)->name ?? 'N/A' }}</td> --}}
        <td>{{ $generate->title }}</td>
        <td>
            <div class="badge bg-{{ $generate->type == 'text' ? 'success' : 'danger' }}">
                {{ ucfirst($generate->type) }}
            </div>
        </td>
        <td class="text-{{ $generate->cost_credits ? 'danger' : 'success' }} fw-bold">{{ $generate->cost_credits ? '-'.$generate->cost_credits : 'N/A' }}</td>
        <td>{{ formatted_date($generate->created_at) }}</td>
            <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('admin.generates.show', $generate->id) }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('generates-delete')
                        <li>
                            <a href="{{ route('admin.generates.destroy', $generate->id) }}" class="confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </td>
    </tr>

@endforeach
