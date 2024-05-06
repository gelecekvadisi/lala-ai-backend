@foreach($plans as $plan)
    <tr>
        @can('plans-delete')
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $plan->id }}" data-url="{{ route('admin.plans.delete-all') }}">
        </td>
        @endcan
        <td>{{ ($plans->perPage() * ($plans->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ $plan->title }}</td>
        <td>{{ $plan->subtitle }}</td>
        <td class="fw-bold text-dark">{{ $plan->price }}</td>
        <td>{{ str_replace("_", " ", $plan->duration) }}</td>
        <td>{{ ($plan->created_at)->format('d M Y') }}</td>
        <td class="text-center w-150">
            @can('plans-update')
                <label class="switch">
                    <input type="checkbox" {{ $plan->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.plans.status', $plan->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $plan->status == 1 ? 'success' : 'danger' }}">
                    {{ $plan->status == 1 ? 'Active' : 'Deactive' }}
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
                        <a href="#view-modal" class="view-btn"
                            data-bs-toggle="modal"
                            id="plan_view_{{ $plan->id }}"
                            data-id = "{{ $plan->id }}"
                            data-title = "{{ $plan->title }}"
                            data-subtitle = "{{ $plan->subtitle }}"
                            data-price = "{{ $plan->price }}"
                            data-duration = "{{ $plan->duration }}"
                            data-status="{{ $plan->status }}">

                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('plans-update')
                    <li>
                        <a href="{{ route('admin.plans.edit', $plan->id) }}">
                            <i class="fal fa-pencil-alt"></i>
                            {{ __('Edit') }}
                        </a>
                    </li>
                    @endcan
                    @can('plans-delete')
                    <li>
                        <a href="{{ route('admin.plans.destroy', $plan->id) }}" class="confirm-action" data-method="DELETE">
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
