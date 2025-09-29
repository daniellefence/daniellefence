<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Expert Insights & Tips"
        subtitle="Fencing • Outdoor Living • Design Ideas"
        description="Stay informed with the latest trends, maintenance tips, and design inspiration from Central Florida's fencing and outdoor living experts."
        :background-image="asset('images/fence2.webp')"
        cta="Get Expert Advice"
        :cta-url="route('contact')"
        />

    <!-- Blog Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <livewire:blogs lazy/>
    </x-modern-section>

    <!-- Newsletter CTA -->
    <x-modern-cta
        title="Stay Updated with Expert Tips"
        description="Get the latest fencing trends, maintenance tips, and design inspiration delivered to your inbox."
        button-text="Contact for Updates"
        :button-url="route('contact')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
