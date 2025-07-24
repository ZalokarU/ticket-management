<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            {{ $this->form }}

            @if($selectedTemplate)
                <div class="flex gap-4 mt-6">
                    <x-filament::button
                        color="success"
                        wire:click="previewTemplate"
                        icon="heroicon-o-eye"
                    >
                        Preview Template
                    </x-filament::button>

                    <x-filament::button
                        color="danger"
                        wire:click="resetTemplate"
                        icon="heroicon-o-arrow-path"
                        wire:confirm="Are you sure you want to reset this template to default settings?"
                    >
                        Reset to Default
                    </x-filament::button>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-lg font-semibold mb-3">Live Preview:</h4>
                    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2"
                         style="background-color: {{ $selectedTemplate->background_color }};
                                color: {{ $selectedTemplate->text_color }};
                                font-family: {{ $selectedTemplate->design_settings['font_family'] ?? 'Arial, sans-serif' }};
                                border-style: {{ $selectedTemplate->design_settings['border_style'] ?? 'solid' }};">

                        @if($selectedTemplate->design_settings['header_text'] ?? null)
                            <div class="text-center text-sm font-bold mb-2 uppercase tracking-wide">
                                {{ $selectedTemplate->design_settings['header_text'] }}
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-xl font-bold mb-2">{{ ucfirst($selectedTemplate->category) }} Event</h3>
                            <p class="text-sm opacity-75 mb-4">Template: {{ $selectedTemplate->name }}</p>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div><strong>Event:</strong> Sample Event Title</div>
                            <div><strong>Venue:</strong> Sample Venue</div>
                            <div><strong>Date:</strong> {{ now()->addWeek()->format('M d, Y g:i A') }}</div>
                            <div><strong>Price:</strong> $50.00</div>

                            @if($selectedTemplate->personalization)
                                <div class="border-t pt-2 mt-2">
                                    <div class="text-xs opacity-60 mb-1">Personalization Fields:</div>
                                    <div><strong>Field 1:</strong> Sample Data 1</div>
                                    <div><strong>Field 2:</strong> Sample Data 2</div>
                                    <div><strong>Field 3:</strong> Sample Data 3</div>
                                </div>
                            @endif
                        </div>

                        @if($selectedTemplate->design_settings['show_qr_code'] ?? true)
                            <div class="text-center mt-4">
                                <div class="inline-block w-16 h-16 bg-black opacity-10 rounded"></div>
                                <div class="text-xs mt-1 opacity-60">QR Code</div>
                            </div>
                        @endif

                        @if($selectedTemplate->design_settings['footer_text'] ?? null)
                            <div class="text-center text-xs mt-4 opacity-60">
                                {{ $selectedTemplate->design_settings['footer_text'] }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
