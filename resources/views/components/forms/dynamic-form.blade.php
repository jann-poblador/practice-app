{{-- resources/views/components/forms/dynamic-form.blade.php --}}
@props([
    'action' => '#',
    'method' => 'POST',
    'title' => 'Form',
    'submitText' => 'Submit',
    'cancelUrl' => null,
    'fields' => [],
    'model' => null,
    'enctype' => null,
])

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ $title }}</h2>

    <form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
        @if ($enctype) enctype="{{ $enctype }}" @endif>
        @csrf

        @if ($method !== 'GET' && $method !== 'POST')
            @method($method)
        @endif

        <div class="space-y-4">
            @foreach ($fields as $field)
                <div class="form-group">
                    <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $field['label'] }}
                        @if ($field['required'] ?? false)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>

                    @switch($field['type'])
                        @case('text')
                        @case('email')

                        @case('password')
                        @case('number')

                        @case('date')
                        @case('datetime-local')

                        @case('url')
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                value="{{ old($field['name'], $model->{$field['name']} ?? ($field['value'] ?? '')) }}"
                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror"
                                @if ($field['required'] ?? false) required @endif
                                @if ($field['readonly'] ?? false) readonly @endif
                                @if ($field['disabled'] ?? false) disabled @endif />
                        @break

                        @case('textarea')
                            <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="{{ $field['rows'] ?? 4 }}"
                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror"
                                @if ($field['required'] ?? false) required @endif @if ($field['readonly'] ?? false) readonly @endif
                                @if ($field['disabled'] ?? false) disabled @endif>{{ old($field['name'], $model->{$field['name']} ?? ($field['value'] ?? '')) }}</textarea>
                        @break

                        @case('select')
                            <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror"
                                @if ($field['required'] ?? false) required @endif
                                @if ($field['disabled'] ?? false) disabled @endif>
                                @if ($field['placeholder'] ?? false)
                                    <option value="">{{ $field['placeholder'] }}</option>
                                @endif
                                @foreach ($field['options'] ?? [] as $value => $label)
                                    <option value="{{ $value }}" @if (old($field['name'], $model->{$field['name']} ?? ($field['value'] ?? '')) == $value) selected @endif>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        @break

                        @case('checkbox')
                            <div class="flex items-center">
                                <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                    value="{{ $field['value'] ?? 1 }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    @if (old($field['name'], $model->{$field['name']} ?? false)) checked @endif
                                    @if ($field['disabled'] ?? false) disabled @endif />
                                <span class="ml-2 text-sm text-gray-600">{{ $field['description'] ?? '' }}</span>
                            </div>
                        @break

                        @case('radio')
                            <div class="space-y-2">
                                @foreach ($field['options'] ?? [] as $value => $label)
                                    <div class="flex items-center">
                                        <input type="radio" name="{{ $field['name'] }}"
                                            id="{{ $field['name'] }}_{{ $value }}" value="{{ $value }}"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                            @if (old($field['name'], $model->{$field['name']} ?? ($field['value'] ?? '')) == $value) checked @endif
                                            @if ($field['disabled'] ?? false) disabled @endif />
                                        <label for="{{ $field['name'] }}_{{ $value }}"
                                            class="ml-2 text-sm text-gray-600">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @break

                        @case('file')
                            <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror"
                                @if ($field['required'] ?? false) required @endif
                                @if ($field['accept'] ?? false) accept="{{ $field['accept'] }}" @endif
                                @if ($field['multiple'] ?? false) multiple @endif />
                            @if ($field['help'] ?? false)
                                <p class="text-xs text-gray-500 mt-1">{{ $field['help'] }}</p>
                            @endif
                        @break

                        @case('hidden')
                            <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}">
                        @break
                    @endswitch

                    @error($field['name'])
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    @if (($field['help'] ?? false) && $field['type'] !== 'file')
                        <p class="text-gray-500 text-xs mt-1">{{ $field['help'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            @if ($cancelUrl)
                <a href="{{ $cancelUrl }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            @endif
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                {{ $submitText }}
            </button>
        </div>
    </form>
</div>
