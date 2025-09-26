<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Customer Reviews"
        subtitle="Real Stories • Verified Experiences"
        description="See what our customers say about their experience with Danielle Fence. Over 100,000 families served with 97% customer satisfaction."
        :background-image="Vite::asset('resources/images/reviews-hero.webp')"
        cta="Share Your Experience"
        :cta-url="route('request-a-quote')"
        />

    <!-- Reviews Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <livewire:reviews wire:key="reviews{{rand(0,10000)}}" lazy/>
    </x-modern-section>

    <!-- Trust CTA -->
    <x-modern-cta
        title="Join Thousands of Satisfied Customers"
        description="Experience the quality and service that has made us Central Florida's most trusted fencing company for {{ date('Y') - 1976 }}+ years."
        button-text="Get Your Free Estimate"
        :button-url="route('request-a-quote')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
