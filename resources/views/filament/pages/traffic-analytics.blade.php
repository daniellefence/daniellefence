<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Stats -->
        <div class="fi-section-content-ctn">
            <x-filament-widgets::widgets
                :widgets="$this->getHeaderWidgets()"
                :columns="[
                    'default' => 1,
                    'sm' => 2,
                    'md' => 2,
                    'lg' => 4,
                ]"
            />
        </div>

        <!-- Additional Analytics Widgets -->
        <div class="fi-section-content-ctn">
            <x-filament-widgets::widgets
                :widgets="$this->getFooterWidgets()"
                :columns="$this->getFooterWidgetsColumns()"
            />
        </div>

        <!-- Quick Actions Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        Quick Actions
                    </x-slot>
                    <x-slot name="description">
                        Common analytics tasks and reports.
                    </x-slot>

                    <div class="space-y-4">
                        <x-filament::button
                            tag="a"
                            href="/admin/traffic"
                            icon="heroicon-o-table-cells"
                            color="primary"
                            size="lg"
                            class="w-full"
                        >
                            View Raw Traffic Log
                        </x-filament::button>

                        <x-filament::button
                            tag="a"
                            href="https://analytics.google.com"
                            icon="heroicon-o-chart-bar"
                            color="success"
                            size="md"
                            class="w-full"
                            target="_blank"
                        >
                            Open Google Analytics
                        </x-filament::button>
                    </div>
                </x-filament::section>
            </div>

            <div class="lg:col-span-2">
                <x-filament::section>
                    <x-slot name="heading">
                        Google Analytics Integration
                    </x-slot>

                    <div class="prose dark:prose-invert max-w-none">
                        <p>
                            This analytics dashboard is powered by Google Analytics and provides comprehensive insights into your website performance:
                        </p>
                        <ul>
                            <li><strong>Page Views:</strong> Total number of page views across your website</li>
                            <li><strong>Visitors:</strong> Unique visitors and returning visitor patterns</li>
                            <li><strong>Active Users:</strong> Real-time and historical active user counts (1-day, 7-day, 28-day)</li>
                            <li><strong>Sessions:</strong> User session data and engagement metrics</li>
                            <li><strong>Session Duration:</strong> Average time users spend on your site</li>
                            <li><strong>Most Visited Pages:</strong> Top performing pages on your website</li>
                        </ul>
                        <p>
                            All data is refreshed regularly from your Google Analytics 4 property to provide accurate, real-time insights for data-driven decision making.
                        </p>
                    </div>
                </x-filament::section>
            </div>
        </div>
    </div>
</x-filament-panels::page>