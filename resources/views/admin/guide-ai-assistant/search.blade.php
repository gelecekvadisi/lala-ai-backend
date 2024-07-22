@foreach($guideAiAssistant as $guideAiAssistant)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $guideAiAssistant->id }}" data-url="{{ route('admin.guide-ai-assistant.delete-all') }}">
        </td>
        <td>{{-- {{ ($guideAiAssistant->perPage() * ($guideAiAssistant->currentPage() - 1)) + $loop->iteration }} --}}</td>
        <td>{{ $guideAiAssistant->name ?? '' }}</td>
        <td>{{ $guideAiAssistant->image_name ?? '' }}</td>
        <td>{{ $guideAiAssistant->assistant_id ?? '' }}</td>
        <td>{{ Str::limit($guideAiAssistant->inputs, 80) }}</td>
        <td>{{ Str::limit($guideAiAssistant->instructions_generator, 80) }}</td>
        <td>{{ $guideAiAssistant->spreadsheet_name ?? '' }}</td>
        <td>{{ $guideAiAssistant->spreadsheet_id ?? '' }}</td>
        <td class="text-center w-150">
                <label class="switch">
                    <input type="checkbox" {{ $guideAiAssistant->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('admin.guide-ai-assistant.status', $guideAiAssistant->id)}}">
                    <span class="slider round"></span>
                </label>
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#view-modal" class="view-btn" data-bs-toggle="modal"
                           id="guide_ai_assistant_view_{{ $guideAiAssistant->id }}"
                           data-id = "{{ $guideAiAssistant->id }}"
                           data-name = "{{ $guideAiAssistant->name }}"
                           data-image-name = "{{ $guideAiAssistant->image_name }}"
                           data-assistant-id = "{{ $guideAiAssistant->assistant_id }}"
                           data-inputs = "{{ $guideAiAssistant->inputs }}"
                           data-instructions-generator = "{{ $guideAiAssistant->instructions_generator }}"
                           data-spreadsheet-name = "{{ $guideAiAssistant->spreadsheet_name }}"
                           data-spreadsheet-id = "{{ $guideAiAssistant->spreadsheet_id }}"
                           data-status = "{{ $guideAiAssistant->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                        <li>
                            <a href="{{ route('admin.guide-ai-assistant.edit', $guideAiAssistant->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.guide-ai-assistant.destroy', $guideAiAssistant->id) }}" class="confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
