@foreach($suggestions as $suggestion)
    <tr>
        @can('suggestions-delete')
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $suggestion->id }}" data-url="{{ route('admin.suggestions.delete-all') }}">
        </td>
        @endcan
        <td>{{ ($suggestions->perPage() * ($suggestions->currentPage() - 1)) + $loop->iteration }}</td>
        <td class="text-start">{{ Str::limit($suggestion->suggestions, 80) }}</td>
        <td>{{ $suggestion->category->name ?? '' }}</td>
        <td class="text-center w-150">
            @can('suggestions-update')
                <label class="switch">
                    <input type="checkbox" {{ $suggestion->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.suggestions.status', $suggestion->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $suggestion->status == 1 ? 'success' : 'danger' }}">
                    {{ $suggestion->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#view-modal" class="view-btn" data-bs-toggle="modal"
                           id="suggestion_view_{{ $suggestion->id }}"
                           data-id = "{{ $suggestion->id }}"
                           data-suggestions = "{{ $suggestion->suggestions }}"
                           data-category="{{ $suggestion->category->name ?? '' }}"
                           data-status = "{{ $suggestion->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('suggestions-update')
                        <li>
                            <a href="{{ route('admin.suggestions.edit', $suggestion->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('suggestions-delete')
                        <li>
                            <a href="{{ route('admin.suggestions.destroy', $suggestion->id) }}" class="confirm-action" data-method="DELETE">
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
