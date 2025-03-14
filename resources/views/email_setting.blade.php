<x-filament::page>
    <x-filament::form :action="route('filament.pages.email-setting.submit')">
        {{ $this->form }}
        
        <x-filament::button type="submit" color="primary">Save Settings</x-filament::button>
    </x-filament::form>
</x-filament::page>
