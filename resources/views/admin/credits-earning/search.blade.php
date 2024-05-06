@foreach($credits_earnings as $earning)
    <tr>
        @can('credits_earnings-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $earning->id }}" data-url="{{ route('admin.credits-earning.delete-all') }}">
                <i class="{{ request('id') == $earning->id ? 'fas fa-bell text-red' : '' }}"></i>
            </td>
        @endcan
        <td>{{ ($credits_earnings->perPage() * ($credits_earnings->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ optional($earning->user)->name }}</td>
        <td>{{ $earning->platform }}</td>
        <td>{{ $earning->credits }}</td>
        <td>{{ $earning->price }}</td>
        <td>{{ formatted_date($earning->created_at) }}</td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#view-modal" class="view-btn" data-bs-toggle="modal"
                           id="credits_earning_{{ $earning->id }}"
                           data-id = "{{ $earning->id }}"
                           data-user = "{{ optional($earning->user)->name }}"
                           data-platform="{{ $earning->platform }}"
                           data-credits = "{{ $earning->credits }}"
                           data-price = "{{ $earning->price }}"
                           data-created_at = "{{ formatted_date($earning->created_at) }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('credits_earnings-delete')
                        <li>
                            <a href="{{ route('admin.credits-earning.destroy', $earning->id) }}" class="confirm-action" data-method="DELETE">
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
