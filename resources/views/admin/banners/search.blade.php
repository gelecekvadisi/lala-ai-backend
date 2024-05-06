@foreach($banners as $banner)
    <tr>
        @can('banners-delete')
            <td class="w-60 checkbox">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $banner->id }}" data-url="{{ route('admin.banner.delete-all') }}">
            </td>
        @endcan
        <td>{{ ($banners->perPage() * ($banners->currentPage() - 1)) + $loop->iteration }}</td>
        <td>
            <img class="table-img" src="{{ asset($banner->image ?? '') }}" alt="banner">
        </td>
        <td>{{ $banner->category->name ?? '' }}</td>
        <td>{{ $banner->title }}</td>
        <td class="text-center">
            @can('banners-update')
                <label class="switch">
                    <input type="checkbox" {{ $banner->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.banners.status', $banner->id)}}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }}">
                    {{ $banner->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('banners-update')
                        <li>
                            <a href="{{ route('admin.banners.edit', $banner->id) }}">
                                <i class="fal fa-edit"></i>
                                Edit
                            </a>
                        </li>
                    @endcan
                    @can('banners-delete')
                        <li>
                            <a href="{{ route('admin.banners.destroy', $banner->id) }}" class="confirm-action" data-method="DELETE">
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
