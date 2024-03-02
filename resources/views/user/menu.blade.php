<x-col sm="4" lg="4" xl="4" md="4" class="accordion">
    <x-card class="accordion-item active">
        <x-slot:header>
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button p-0" data-bs-toggle="collapse"
                    data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                    List Role
                </button>
            </h2>
        </x-slot:header>
        <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body p-0">
                <div class="demo-inline-spacing mt-3">
                    <div class="list-group">
                        <a href="{{ route('web.user.admin.index') }}" @class([
                            'list-group-item list-group-item-action',
                            'active' => request()->route()->named('web.user.admin.index'),
                        ])>Admin</a>
                        <a href="{{ route('web.user.customer.index') }}" @class([
                            'list-group-item list-group-item-action',
                            'active' => request()->route()->named('web.user.customer.index'),
                        ])>Customer</a>
                        <a href="{{ route('web.user.courier.index') }}" @class([
                            'list-group-item list-group-item-action',
                            'active' => request()->route()->named('web.user.courier.index'),
                        ])>Kurir</a>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
</x-col>
