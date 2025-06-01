<?php
/*
Template Name: Guides Crypto
*/
get_header();

// Include modals
get_template_part('modals');
?>
<main>
    <!-- Crypto Guide Content Here -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-4xl mx-auto py-16 px-4">
        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 gradient-text">Crypto Trading Guide</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Master the essentials of crypto trading with our comprehensive, easy-to-follow guide. Learn strategies, risk management, and get started with confidence.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-coins text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">What is Crypto Trading?</h2>
                <p class="text-gray-300">Crypto trading involves buying and selling cryptocurrencies like Bitcoin, Ethereum, and others to profit from price movements. It can be done on various exchanges and requires understanding of market trends, technical analysis, and risk management.</p>
            </div>
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-user-shield text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Getting Started</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li>Choose a reputable crypto exchange (e.g., Binance, Coinbase).</li>
                    <li>Secure your account with strong passwords and 2FA.</li>
                    <li>Start with small amounts and never invest more than you can afford to lose.</li>
                </ul>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-lightbulb text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Basic Strategies</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li><b>Day Trading:</b> Buying and selling within the same day to profit from short-term price movements.</li>
                    <li><b>HODLing:</b> Holding assets for the long term, regardless of volatility.</li>
                    <li><b>Scalping:</b> Making many small trades to capture minor price changes.</li>
                </ul>
            </div>
            <div class="bg-gray-800 rounded-lg p-8 shadow-lg flex flex-col items-center">
                <i class="fas fa-shield-alt text-blue-400 text-4xl mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Risk Management</h2>
                <ul class="list-disc ml-6 text-gray-300 text-left">
                    <li>Always use stop-loss orders to limit potential losses.</li>
                    <li>Diversify your portfolio to reduce risk.</li>
                    <li>Stay updated with news and market trends.</li>
                </ul>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-8 shadow-lg mb-12">
            <h2 class="text-2xl font-semibold mb-4 text-center">Useful Resources</h2>
            <ul class="list-disc ml-6 text-blue-400">
                <li><a href="https://www.binance.com/en/learn" target="_blank">Binance Academy</a></li>
                <li><a href="https://www.coindesk.com/learn/" target="_blank">Coindesk Learn</a></li>
            </ul>
        </div>        <div class="text-center">
            <a href="<?php echo esc_url(home_url('/guides-forex')); ?>" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium transition duration-300 glow">Read Forex Trading Guide</a>
        </div>
    </main>

        </div>
    </section>
</main>
<?php get_footer(); ?>
