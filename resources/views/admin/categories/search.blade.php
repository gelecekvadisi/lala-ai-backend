@foreach($categories as $category)
    <tr>
        @can('categories-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $category->id }}" data-url="{{ route('admin.categories.delete-all') }}">
            </td>
        @endcan
        <td>{{ ($categories->perPage() * ($categories->currentPage() - 1)) + $loop->iteration }}</td>
        <td>{{ $category->name }}</td>
        <td><img class="table-img" src="{{ asset($category->image ?? 'assets/img/icon/no-image.svg') }}" alt="icon"></td>
        <td class="text-center w-150">
            @can('categories-update')
                <label class="switch">
                    <input type="checkbox" {{ $category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.categories.status', $category->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $category->status == 1 ? 'success' : 'danger' }}">
                    {{ $category->status == 1 ? 'Active' : 'Deactive' }}
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
                            id="category_view_{{ $category->id }}"
                            data-id = "{{ $category->id }}"
                            data-name = "{{ $category->name }}"
                            data-image="{{ asset($category->image) }}"
                            data-status = "{{ $category->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    @can('categories-update')
                        <li>
                            <a href="{{ route('admin.categories.edit', $category->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('categories-delete')
                        <li>
                            <a href="{{ route('admin.categories.destroy', $category->id) }}" class="confirm-action" data-method="DELETE">
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
