@foreach($subscribers as $subscriber)
    <tr>
        @can('subscribers-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $subscriber->id }}" data-url="{{ route('admin.subscribers.delete-all') }}">
                <i class="{{ request('id') == $subscriber->id ? 'fas fa-bell text-red' : '' }}"></i>
            </td>
        @endcan
        <td>{{ ($subscribers->perPage() * ($subscribers->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ optional($subscriber->user)->name }}</td>
        <td>{{ optional($subscriber->plan)->title }}</td>
        <td>{{ optional($subscriber->plan)->price }}</td>
        <td>{{ formatted_date($subscriber->will_expire) }}</td>
        <td>{{ formatted_date($subscriber->created_at) }}</td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('subscribers-delete')
                        <li>
                            <a href="{{ route('admin.subscribers.destroy', $subscriber->id) }}" class="confirm-action" data-method="DELETE">
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
