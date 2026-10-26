<?php
get_header();
?>

<main>
    <section class="relative bg-white text-white overflow-hidden flex items-center min-h-[60vh]" style="padding:140px 0 80px;">
        <div class="absolute -top-[200px] -right-[200px] w-[600px] h-[600px] rounded-full pointer-events-none" style="background:radial-gradient(circle, rgba(212,168,67,0.08) 0%, transparent 70%);"></div>
        <div class="container text-center relative z-[2]">
            <p class="text-[120px] font-extrabold leading-none mb-4 text-[var(--gold)]">404</p>
            <h1 class="text-[2.5rem] font-bold mb-4 text-dark-green">Page Not Found</h1>
            <p class="text-[1.1rem] mb-8 max-w-[500px] mx-auto leading-7 text-[var(--text-on-dark-soft)]">The page you're looking for doesn't exist or has been moved.</p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-gold">
                Back to Home
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>