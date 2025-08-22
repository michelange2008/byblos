<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('common.Appearance')" :subheading=" __('common.Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('common.Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('common.Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('common.System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
