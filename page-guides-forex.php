<?php
/*
Template Name: Guides Forex
*/
get_header();

// Include modals
get_template_part('modals');
?>
<main>
    <!-- Forex Guide Content Here -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-4xl mx-auto py-16 px-4">
        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 gradient-text">Forex Trading Guide</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Learn the fundamentals and advanced strategies of forex trading. This guide covers everything you need to know to start trading currencies with confidence.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-globe text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">What is Forex Trading?</h2>
                <p class="text-gray-300">Forex trading is the act of buying and selling currencies on the foreign exchange market with the aim of making a profit. The forex market is the largest and most liquid market in the world.</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-user-shield text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Getting Started</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li>Choose a regulated forex broker (e.g., OANDA, IG, Forex.com).</li>
                    <li>Understand currency pairs and how they are quoted.</li>
                    <li>Practice with a demo account before trading real money.</li>
                </ul>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-lightbulb text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Popular Strategies</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li><b>Scalping:</b> Making many quick trades to capture small price movements.</li>
                    <li><b>Day Trading:</b> Opening and closing trades within the same day.</li>
                    <li><b>Swing Trading:</b> Holding positions for several days to capture medium-term trends.</li>
                </ul>
            </div>
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-shield-alt text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Risk Management</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li>Use stop-loss and take-profit orders to manage risk.</li>
                    <li>Never risk more than 1-2% of your capital on a single trade.</li>
                    <li>Keep up with economic news and events that affect currency prices.</li>
                </ul>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-8 shadow-lg mb-12">
            <h2 class="text-2xl font-semibold mb-4 text-center">Useful Resources</h2>
            <ul class="list-disc ml-6 text-blue-400">
                <li><a href="https://www.babypips.com/learn/forex" target="_blank">BabyPips Forex Education</a></li>
                <li><a href="https://www.investopedia.com/forex-trading-4427704" target="_blank">Investopedia Forex Guide</a></li>
            </ul>
        </div>
        <div class="text-center">
            <a href="<?php echo esc_url(home_url('/guides-crypto')); ?>" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium transition duration-300 glow">Read Crypto Trading Guide</a>
        </div>    </div>
    </section>
</main>
<?php get_footer(); ?>
