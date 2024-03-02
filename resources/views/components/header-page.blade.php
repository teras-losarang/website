@props(['title' => null, 'options' => []])

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <x-breadcrumb :currentPage="$title ?? 'Dashboard'" :pages="[$options]"></x-breadcrumb>
            </div>
            <h4 class="page-title">{{ $title ?? 'Dashboard' }}</h4>
        </div>
    </div>
</div>
