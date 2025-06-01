<!-- Footer -->
    <footer class="bg-gray-900 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4"><?php bloginfo('name'); ?></h3>
                    <p class="text-gray-400">Precision Trading Signals. Delivered.</p>
                    <div class="flex space-x-4 mt-4"></div>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#about" class="hover:text-blue-400">About Us</a></li>
                        <li><a href="#contact" class="hover:text-blue-400">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="/guides-crypto" class="hover:text-blue-400">Crypto Trading Guide</a></li>
                        <li><a href="/guides-forex" class="hover:text-blue-400">Forex Trading Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="/legal" class="hover:text-blue-400">Terms of Service</a></li>
                        <li><a href="/privacy-policy" class="hover:text-blue-400">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <p class="text-gray-400 text-center">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
