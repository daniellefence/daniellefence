<div style="background-color: rgba(22, 163, 74, 0.9) !important; color: white !important; padding: 12px 0 !important; overflow: hidden !important; position: relative !important; cursor: pointer !important; height: 48px !important; line-height: 24px !important; display: block !important; width: 100% !important; box-sizing: border-box !important;" onclick="window.location='{{ route('reviews') }}'">
    <div style="display: flex; animation: scroll 60s linear infinite; white-space: nowrap; height: 24px; align-items: center;">
        @foreach(\App\Models\Review::where('hidden', false)->orderBy('order', 'asc')->get() as $review)
            <span style="margin: 0 32px; font-weight: bold; font-size: 16px;">{{ $review->name }} ⭐⭐⭐⭐⭐</span>
        @endforeach
        @foreach(\App\Models\Review::where('hidden', false)->orderBy('order', 'asc')->get() as $review)
            <span style="margin: 0 32px; font-weight: bold; font-size: 16px;">{{ $review->name }} ⭐⭐⭐⭐⭐</span>
        @endforeach
    </div>
</div>

<style>
@keyframes scroll {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-50%); }
}

/* Force visibility on larger screens */
@media (min-width: 768px) {
    div[style*="height: 48px"] {
        height: 48px !important;
        display: block !important;
        width: 100% !important;
        overflow: hidden !important;
        position: relative !important;
        z-index: 40 !important;
    }

    div[style*="height: 48px"] > div {
        height: 24px !important;
        display: flex !important;
    }

    div[style*="height: 48px"] span {
        font-size: 16px !important;
        line-height: 24px !important;
        height: 24px !important;
        display: inline-block !important;
    }
}
</style>