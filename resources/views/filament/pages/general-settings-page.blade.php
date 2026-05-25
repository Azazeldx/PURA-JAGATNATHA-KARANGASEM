<x-filament-panels::page>
    <form wire:submit="update" id="form" class="fi-sc-form">
        {{ $this->form }}
        <x-filament::actions :actions="$this->getFormActions()" class="fi-sc fi-sc-has-gap fi-grid" />
    </form>   
</x-filament-panels::page>