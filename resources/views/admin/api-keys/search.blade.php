@foreach($api_keys as $key)
    <tr>
        @can('api-keys-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $key->id }}" data-url="{{ route('admin.api-keys.delete-all') }}">
            </td>
        @endcan
        <td>{{ ($api_keys->perPage() * ($api_keys->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ $key->title }}</td>
        <td>{{ $key->key }}</td>
        <td class="text-center w-150">
            @can('api-keys-update')
                <label class="switch">
                    <input type="checkbox" {{ $key->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.api-keys.status', $key->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $key->status == 1 ? 'success' : 'danger' }}">
                    {{ $key->status == 1 ? 'Active' : 'Deactive' }}
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
                           id="api_key_view_{{ $key->id }}"
                           data-id = "{{ $key->id }}"
                           data-key = "{{ $key->key }}"
                           data-title = "{{ $key->title }}"
                           data-status = "{{ $key->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>

                    @can('api-keys-update')
                    <li>
                        <a href="{{ route('admin.api-keys.edit', $key->id) }}">
                            <i class="fal fa-edit"></i>
                            {{ __('Edit') }}
                        </a>
                    </li>
                    @endcan
                    @can('api-keys-delete')
                    <li>
                        <a href="{{ route('admin.api-keys.destroy', $key->id) }}" class="confirm-action" data-method="DELETE">
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
