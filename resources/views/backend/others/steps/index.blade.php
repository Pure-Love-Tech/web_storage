@extends('backend.layouts.grid')
@section('title', $active . ' | ' . admin_trans('How It Works Steps'))
@section('link', route('admin.steps.create'))
@section('language', true)
@section('content')
    <div class="card">
        <table class="table w-100 ask-datatable">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ admin_trans('#') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Language') }}</th>
                    <th class="tb-w-20x">{{ admin_trans('Title') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Published date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($steps as $step)
                    <tr class="item">
                        <td>{{ $step->id }}</td>
                        <td><a href="{{ route('admin.settings.languages.translates', $step->lang) }}"><i
                                    class="fas fa-language me-2"></i>{{ $step->language->name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.steps.edit', $step->id) }}"
                                class="text-dark">{{ shortertext($step->title, 40) }}</a>
                        </td>
                        <td>{{ dateFormat($step->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.steps.edit', $step->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.steps.destroy', $step->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                    class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
