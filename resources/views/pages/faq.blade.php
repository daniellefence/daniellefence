<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Frequently Asked Questions"
        subtitle="Expert Answers • Helpful Resources"
        description="Get answers to the most common questions about fencing, outdoor kitchens, installation processes, and our services."
        :background-image="Vite::asset('resources/images/faq-hero.webp')"
        cta="Get Personal Help"
        :cta-url="route('contact')"
        />

    <!-- FAQ Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <livewire:faq lazy/>
    </x-modern-section>

    <!-- Still Have Questions CTA -->
    <x-modern-cta
        title="Still Have Questions?"
        description="Our expert team is ready to provide personalized answers and guidance for your specific project needs."
        button-text="Contact Our Experts"
        :button-url="route('contact')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
