@extends('tenant.admin.admin-master')
@section('title')
    {{__('All Campaign')}}
@endsection
@section('style')
    <x-datatable.css />
    <x-bulk-action.css />
    <link rel="stylesheet" href="{{global_asset('assets/landlord/admin/css/materialdesignicons.min.css')}}">

    <style>
         .campaign_image img{
             width: 100px;
         }
    </style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="margin-top-40">
                    <x-flash-msg/>
                    <x-error-msg/>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex flex-wrap justify-content-between">
                            <h4 class="header-title mb-4">{{__('All Campaign')}}</h4>
                            @can('campaign-create')
                                <div class="text-right">
                                    <a href="{{ route('tenant.admin.campaign.new') }}" class="btn btn-primary">{{ __('Add New Campaign') }}</a>
                                </div>
                            @endcan
                        </div>
                        @can('campaign-delete')
                            <x-bulk-action.dropdown />
                        @endcan
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                <x-bulk-action.th />
                                <th>{{__('ID')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                @foreach($all_campaigns as $campaign)
                                    <tr>
                                        <x-bulk-action.td :id="$campaign->id" />
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $campaign->title }}
                                        </td>

                                        <td>
                                            <div class="campaign_image" style="width: 80px">
                                                {!! render_image_markup_by_attachment_id($campaign?->campaignImage?->id, 'rounded', 'thumb', false) !!}
                                            </div>
                                        </td>

                                        <td>
                                            <x-status-span :status="$campaign->status"/>
                                        </td>
                                        <td>
                                            @if($campaign->id != 1)
                                                @can('campaign-delete')
                                                    <x-delete-popover :url="route('tenant.admin.campaign.delete', $campaign->id)"/>
                                                @endcan
                                            @endif
                                            @can('campaign-edit')
                                                <x-table.btn.edit :route="route('tenant.admin.campaign.edit', $campaign->id)" />
                                            @endcan
                                            <a target="_blank" class="btn btn-info btn-xs mb-3 mr-1"
                                               href="{{ route('frontend.products.campaign', ['id' => $campaign->id, 'slug' => \Str::slug($campaign->title)]) }}">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <x-datatable.js />
    <x-table.btn.swal.js />
    <x-bulk-action.js :route="route('tenant.admin.campaign.bulk.action')" />

    <script>
        $(document).ready(function () {
            $(document).on('click','.campaign_edit_btn',function(){
                let el = $(this);
                let id = el.data('id');
                let name = el.data('name');
                let modal = $('#campaign_edit_modal');

                modal.find('#campaign_id').val(id);
                modal.find('#edit_name').val(name);

                modal.show();
            });
        });
    </script>
@endsection
