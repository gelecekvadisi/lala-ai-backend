@foreach($buy_credits as $buy_credit)
    <tr>
        @can('buy-credits-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $buy_credit->id }}" data-url="{{ route('admin.buy-credits.delete-all') }}">
            </td>
        @endcan
        <td>{{ ($buy_credits->perPage() * ($buy_credits->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ $buy_credit->title }}</td>
        <td class="fw-bold text-dark">{{ $buy_credit->price }}</td>
        <td class="fw-bold text-dark">{{ $buy_credit->reward }}</td>
        <td>{{ $buy_credit->description }}</td>
        <td class="text-center w-150">
            @can('buy-credits-update')
                <label class="switch">
                    <input type="checkbox" {{ $buy_credit->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.buy-credits.status', $buy_credit->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $buy_credit->status == 1 ? 'success' : 'danger' }}">
                    {{ $buy_credit->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('buy-credits-update')
                        <li>
                            <a href="{{ route('admin.buy-credits.edit', $buy_credit->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('buy-credits-delete')
                        <li>
                            <a href="{{ route('admin.buy-credits.destroy', $buy_credit->id) }}" class="confirm-action" data-method="DELETE">
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
