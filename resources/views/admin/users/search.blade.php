@foreach($users as $user)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $user->id }}" data-url="{{ route('admin.users.delete-all') }}">
            <i class="{{ request('id') == $user->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ ($users->perPage() * ($users->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ ($user->created_at)->format('d M Y') }}</td>
        <td>
            <img class="table-img rounded-circle" src="{{ asset($user->image ?? 'assets/images/icons/default-user.png') }}" alt="img">
        </td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        @if(request('type') === 'user')
        <td>
            <p>{{ optional($user->plan)->title }} (<small>{{ optional($user->plan)->duration ?? 'N/A' }}</small>)</p>
        </td>
        @endif
        <td class="text-center">
            @can('users-delete')
                <label class="switch">
                    <input type="checkbox" {{ $user->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.users.status', $user->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $user->status == 1 ? 'success' : 'danger' }}">
                    {{ $user->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>

        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#view-modal" class="view-btn" data-bs-toggle="modal"
                           id="user_view_{{ $user->id }}"
                           data-id = "{{ $user->id }}"
                           data-created_at = "{{ ($user->created_at)->format('d M Y') }}"
                           data-image="{{ asset($user->image) }}"
                           data-name = "{{ $user->name }}"
                           data-email = "{{ $user->email }}"
                           data-plan="{{ $user->plan->duration ?? ''  }}"
                           data-status = "{{ $user->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('users-update')
                    <li>
                        <a href="{{ route('admin.users.edit', [ $user->id, 'type' => request('type') ]) }}">
                            <i class="fal fa-edit"></i>
                            {{ __('Edit') }}
                        </a>
                    </li>
                    @endcan
                    @can('users-delete')
                    <li>
                        <a href="{{ route('admin.users.destroy', [ $user->id, 'type' => request('type') ]) }}" class="confirm-action" data-method="DELETE">
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
