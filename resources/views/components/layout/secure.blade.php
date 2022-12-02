<x-layout.base :title="$title ?? null">
    <div class="row">
        <div class="col-xl-9 order-1">
            <div class="h-100 p-md-5 p-sm-4 p-3 mb-5 bg-body rounded-3">
                {{ $slot }}
            </div>
        </div>
        <div class="d-none d-xl-block d-xxl-block col-xl-3 order-0">
            <x-navigation />
        </div>
    </div>
</x-layout.base>