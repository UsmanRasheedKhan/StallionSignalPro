<?php /*
Template Name: Front Page
*/ ?>
<?php get_header(); ?>
<!-- modals.php is already included in header.php -->

<!-- Main Content -->
<body class="bg-gray-900 text-gray-100 font-sans">
    <!-- Hero Section -->
    <section id="home" class="pt-28 pb-20 md:pt-36 md:pb-28 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        <span class="gradient-text">Unlock Your Crypto Potential with Stallion Signal Pro</span>
                        <!-- <span class="block"></span> -->
                    </h1>
                    <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-lg">
                        Join Our Free Telegram Group and Start Earning Today
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">                        <a href="#pricing" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium text-center transition duration-300 glow">
                            Get Started
                        </a>
                        <a href="#about" class="px-8 py-3 border border-indigo-500 text-indigo-500 hover:bg-indigo-500 hover:text-white rounded-md font-medium text-center transition duration-300">
                            Learn More
                        </a>
                    </div>
                </div>                <div class="md:w-1/2 relative">                    <!-- Trading Video Only -->
                    <div class="relative max-w-md mx-auto">
                        <div class="absolute -inset-1 bg-indigo-500 rounded-lg blur opacity-75 animate-pulse-slow"></div>
                        <div class="relative bg-gray-800 rounded-lg overflow-hidden">                            <video id="hero-video" class="rounded-lg w-full h-64 object-cover" autoplay loop playsinline controls poster="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1470&q=80">
                                <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/video.mp4'); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6 rounded-lg bg-gray-700">                    <div class="text-3xl font-bold text-indigo-400 mb-2">95%</div>
                    <div class="text-gray-300">Win Rate</div>
                </div>
                <div class="p-6 rounded-lg bg-gray-700">
                    <div class="text-3xl font-bold text-indigo-400 mb-2">24/7</div>
                    <div class="text-gray-300">Monitoring</div>
                </div>
                <div class="p-6 rounded-lg bg-gray-700">
                    <div class="text-3xl font-bold text-indigo-400 mb-2">10,000+</div>
                    <div class="text-gray-300">Active Users</div>
                </div>
                <div class="p-6 rounded-lg bg-gray-700">
                    <div class="text-3xl font-bold text-indigo-400 mb-2">0.5s</div>
                    <div class="text-gray-300">Signal Speed</div>
                </div>
            </div>
        </div>    </section>    <!-- Image Carousel Section -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">Trading <span class="gradient-text">Markets</span></h2>
                <p class="max-w-2xl mx-auto text-gray-400">Explore the global markets we analyze to provide you with the best trading opportunities.</p>
            </div>

            <div class="relative max-w-5xl mx-auto">
                <!-- Carousel container -->
                <div id="image-carousel" class="overflow-hidden rounded-lg shadow-xl">
                    <div id="carousel-slides" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Slide 1 -->
                        <div class="carousel-slide min-w-full">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1470&q=80" alt="Cryptocurrency Trading" class="w-full h-80 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end">
                                    <div class="p-6 text-white">
                                        <h3 class="text-xl font-bold">Cryptocurrency Markets</h3>
                                        <p class="text-sm mt-2">Trade Bitcoin, Ethereum, and other leading cryptocurrencies</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-slide min-w-full">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&w=1470&q=80" alt="Stock Market" class="w-full h-80 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end">
                                    <div class="p-6 text-white">
                                        <h3 class="text-xl font-bold">Stock Markets</h3>
                                        <p class="text-sm mt-2">Global equities and indices with precise entry and exit points</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="carousel-slide min-w-full">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=1470&q=80" alt="Forex Trading" class="w-full h-80 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end">
                                    <div class="p-6 text-white">
                                        <h3 class="text-xl font-bold">Forex Markets</h3>
                                        <p class="text-sm mt-2">Currency pairs and forex trading opportunities with high success rates</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="carousel-slide min-w-full">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1605792657660-596af9009e82?auto=format&fit=crop&w=1470&q=80" alt="Commodity Trading" class="w-full h-80 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end">
                                    <div class="p-6 text-white">
                                        <h3 class="text-xl font-bold">Commodity Markets</h3>
                                        <p class="text-sm mt-2">Gold, Silver, Oil, and other high-value commodity trading signals</p>
                                    </div>
                                </div>
                            </div>
                        </div>                    </div>

                    <!-- Navigation arrows -->
                    <button id="prev-slide" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none hover:bg-opacity-70">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="next-slide" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none hover:bg-opacity-70">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Carousel dots -->
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50"></button>
                    </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Indicator dots -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50 focus:outline-none carousel-dot-active"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                        <button class="carousel-dot w-2 h-2 rounded-full bg-white bg-opacity-50 focus:outline-none"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Why Choose <span class="gradient-text">Stallion Signal Pro</span>?</h2>
                <p class="max-w-2xl mx-auto text-gray-400">Our cutting-edge technology and expert team deliver unparalleled trading signals to help you succeed in the volatile crypto market.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">                <div class="bg-gray-800 p-8 rounded-lg transition duration-300">                    <div class="w-14 h-14 bg-indigo-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bolt text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Lightning Fast Signals</h3>
                    <p class="text-gray-400">Our AI systems analyze market data in real-time, delivering signals faster than any human trader could.</p>
                </div>                <div class="bg-gray-800 p-8 rounded-lg transition duration-300">
                    <div class="w-14 h-14 bg-indigo-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Community Highlight</h3>
                    <p class="text-gray-400">Over 20,000 active members generating consistent income and financial success</p>
                </div>                <div class="bg-gray-800 p-8 rounded-lg transition duration-300">
                    <div class="w-14 h-14 bg-indigo-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Mission Statement</h3>
                    <p class="text-gray-400">Empowering individuals to achieve financial independence through expert crypto trading signals and personalized support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Offered Section -->
    <section id="services" class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">                <h2 class="text-3xl font-bold mb-4">Services <span class="gradient-text">Stallion Signal Pro</span> Offers</h2>
                <p class="max-w-2xl mx-auto text-gray-400">We provide a simple 3-step process designed to make profitable trading accessible for everyone, regardless of experience level</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="relative">
                    <div class="bg-gray-700 p-8 rounded-lg h-full">                        <div class="absolute -top-5 -left-5 w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold">1</div>
                        <h3 class="text-xl font-bold mb-3">Accurate Crypto Signals</h3>
                        <p class="text-gray-400 mb-4">Expert-curated signals with a proven success rate</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gray-700 p-8 rounded-lg h-full">
                        <div class="absolute -top-5 -left-5 w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold">2</div>
                        <h3 class="text-xl font-bold mb-3">One-on-One Mentorship</h3>
                        <p class="text-gray-400 mb-4">Personalized sessions to guide your trading journey</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gray-700 p-8 rounded-lg h-full">
                        <div class="absolute -top-5 -left-5 w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold">3</div>
                        <h3 class="text-xl font-bold mb-3">Educational Resources</h3>
                        <p class="text-gray-400 mb-4">Comprehensive guides and tutorials for all skill levels</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Simple, Transparent <span class="gradient-text">Pricing</span></h2>
                <p class="max-w-2xl mx-auto text-gray-400">Choose the plan that fits your trading style and budget.</p>
            </div>            <div class="grid md:grid-cols-4 gap-8 max-w-5xl mx-auto">                <!-- Free Plan -->
                <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700" data-plan="free">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Free</h3>
                        <p class="text-gray-400 mb-6">Perfect for beginners</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold">$0</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>1-2 signals per week</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>Email notifications</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>Basic risk management</span></li>
                            <li class="flex items-center text-gray-500"><i class="fas fa-times text-red-500 mr-2"></i><span>No Telegram alerts</span></li>
                            <li class="flex items-center text-gray-500"><i class="fas fa-times text-red-500 mr-2"></i><span>No premium signals</span></li>
                        </ul>
                        <a href="https://t.me/YourTelegramGroup" target="_blank" class="pricing-button w-full py-2 px-4 border border-indigo-500 text-indigo-500 hover:bg-indigo-500 hover:text-white rounded-md font-medium transition duration-300 text-center block">Join Telegram</a>
                    </div>
                </div>
                <!-- Crypto VIP Plan -->
                <div class="bg-gray-800 rounded-lg overflow-hidden border-2 border-indigo-500 transform scale-105 relative" data-plan="crypto_vip">
                    <div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">POPULAR</div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Crypto VIP</h3>
                        <p class="text-gray-400 mb-6">For serious crypto traders</p>
                        <div class="mb-6 flex items-center space-x-2">
                            <span class="text-2xl font-bold text-gray-400 line-through">$30</span>
                            <span class="text-4xl font-bold text-green-400">$15</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>3-5 crypto signals per week</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>Instant Telegram alerts</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>Advanced risk management</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i><span>Priority support</span></li>
                        </ul>
                        <button class="pricing-button w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition duration-300 glow" data-plan="crypto_vip">Get Started</button>
                    </div>
                </div>
                <!-- Forex Plan (Coming Soon) -->
                <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 opacity-60 relative" data-plan="forex">
                    <div class="absolute top-0 left-0 w-full flex justify-center">
                        <span class="bg-yellow-400 text-yellow-900 font-bold px-3 py-1 rounded-b-lg text-xs shadow-lg">Coming Soon</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-400">Forex</h3>
                        <p class="text-gray-500 mb-6">Professional forex signals</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-400">$49</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>All major forex pairs</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Instant alerts</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Advanced risk management</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>24/7 support</span></li>
                        </ul>
                        <button class="w-full py-2 px-4 bg-gray-600 text-gray-300 rounded-md font-medium transition duration-300 cursor-not-allowed" disabled>Coming Soon</button>
                    </div>
                </div>
                <!-- Gold Plan (Coming Soon) -->
                <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 opacity-60 relative" data-plan="gold">
                    <div class="absolute top-0 left-0 w-full flex justify-center">
                        <span class="bg-yellow-400 text-yellow-900 font-bold px-3 py-1 rounded-b-lg text-xs shadow-lg">Coming Soon</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-400">Gold</h3>
                        <p class="text-gray-500 mb-6">Exclusive gold trading signals</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-400">$99</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Gold & precious metals</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Instant alerts</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Premium support</span></li>
                            <li class="flex items-center"><i class="fas fa-check text-gray-500 mr-2"></i><span>Market insights</span></li>
                        </ul>
                        <button class="w-full py-2 px-4 bg-gray-600 text-gray-300 rounded-md font-medium transition duration-300 cursor-not-allowed" disabled>Coming Soon</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Frequently Asked <span class="gradient-text">Questions</span></h2>                <p class="max-w-2xl mx-auto text-gray-400">Everything you need to know about Stallion Signal Pro.</p>
            </div>
            <div class="max-w-3xl mx-auto">                <!-- FAQ Item 1 -->
                <div class="mb-4">
                    <div class="border-b border-gray-700 pb-4">                        <button class="faq-question flex justify-between items-center w-full text-left font-medium text-white hover:text-indigo-400 focus:outline-none">
                            <span>How accurate are Stallion Signal Pro's trading signals?</span>
                            <i class="fas fa-chevron-down text-indigo-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-400 hidden">
                            <p>Our signals have a consistent win rate of 90-95% based on backtesting and live trading results. The exact accuracy varies by market conditions, but we're proud to maintain one of the highest success rates in the industry.</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-600 mt-4 pt-2 opacity-20"></div>
                </div>                <!-- FAQ Item 2 -->
                <div class="mb-4">
                    <div class="border-b border-gray-700 pb-4">                        <button class="faq-question flex justify-between items-center w-full text-left font-medium text-white hover:text-indigo-400 focus:outline-none">
                            <span>What markets do you cover?</span>
                            <i class="fas fa-chevron-down text-indigo-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-400 hidden">
                            <p>We primarily focus on major cryptocurrency pairs (BTC, ETH, etc.) against USD and USDT on top exchanges like Binance, Coinbase, and Kraken. We also provide signals for select altcoins with strong technical setups.</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-600 mt-4 pt-2 opacity-20"></div>
                </div>                <!-- FAQ Item 3 -->
                <div class="mb-4">
                    <div class="border-b border-gray-700 pb-4">                        <button class="faq-question flex justify-between items-center w-full text-left font-medium text-white hover:text-indigo-400 focus:outline-none">
                            <span>How quickly are signals delivered?</span>
                            <i class="fas fa-chevron-down text-indigo-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-400 hidden">
                            <p>Our AI systems detect trading opportunities in real-time, with alerts typically delivered within 0.5 seconds of signal generation. Telegram subscribers receive instant push notifications, while email delivery may take 1-2 minutes.</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-600 mt-4 pt-2 opacity-20"></div>
                </div>                <!-- FAQ Item 4 -->
                <div class="mb-4">
                    <div class="border-b border-gray-700 pb-4">                        <button class="faq-question flex justify-between items-center w-full text-left font-medium text-white hover:text-indigo-400 focus:outline-none">
                            <span>Can I test the service before subscribing?</span>
                            <i class="fas fa-chevron-down text-indigo-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-400 hidden">
                            <p>Yes! We offer a free plan with limited signals so you can evaluate our service. Additionally, all paid plans come with a 7-day money-back guarantee if you're not completely satisfied.</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-600 mt-4 pt-2 opacity-20"></div>
                </div>                <!-- FAQ Item 5 -->
                <div class="mb-4">
                    <div class="border-b border-gray-700 pb-4">                        <button class="faq-question flex justify-between items-center w-full text-left font-medium text-white hover:text-indigo-400 focus:outline-none">
                            <span>What's included in each signal?</span>
                            <i class="fas fa-chevron-down text-indigo-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-400 hidden">
                            <p>Every signal includes: the trading pair, precise entry price, take-profit targets (usually 2-3 levels), stop-loss level, and the rationale behind the trade. VIP members also receive detailed technical analysis and alternative scenarios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- Testimonial Reviews Section -->
    <section id="testimonials" class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">What Our <span class="gradient-text">Clients</span> Say</h2>
                <p class="max-w-2xl mx-auto text-gray-400">Don't take our word for it. See what our clients have to say about our trading signals.</p>
            </div>              <!-- Review Images Grid - Only 4 Reviews Shown -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="review-image-container rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 shadow-lg cursor-pointer bg-gray-800" onclick="openReviewModal('review1')">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/review1.jpg'); ?>" alt="Client Review 1" class="w-full h-auto object-contain p-4">
                </div>
                <div class="review-image-container rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 shadow-lg cursor-pointer bg-gray-800" onclick="openReviewModal('review2')">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/review2.jpg'); ?>" alt="Client Review 2" class="w-full h-auto object-contain p-4">
                </div>
                <div class="review-image-container rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 shadow-lg cursor-pointer bg-gray-800" onclick="openReviewModal('review3')">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/review3.jpg'); ?>" alt="Client Review 3" class="w-full h-auto object-contain p-4">
                </div>
                <div class="review-image-container rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 shadow-lg cursor-pointer bg-gray-800" onclick="openReviewModal('review4')">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/review4.jpg'); ?>" alt="Client Review 4" class="w-full h-auto object-contain p-4">
                </div>
                <!-- Fifth review (review5.jpg) intentionally hidden -->
            </div>
              <!-- Enhanced Review Modal -->
            <div id="review-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-900 opacity-90"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-indigo-500/30">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl leading-6 font-medium text-white flex items-center">
                                    <span class="gradient-text mr-2">Client</span> Testimonial
                                </h3>
                                <button id="close-review-modal" class="text-gray-400 hover:text-white p-1 rounded-full hover:bg-gray-700 transition-colors">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-6 flex justify-center">
                                <img id="review-modal-image" src="" alt="Client Review" class="max-w-full max-h-[75vh] object-contain rounded-md shadow-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-indigo-900 to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">            <h2 class="text-3xl font-bold mb-6">Ready to Transform Your Trading?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">Join thousands of traders who trust Stallion Signal Pro for accurate, timely signals that deliver consistent profits.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#pricing" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-medium transition duration-300 glow">
                    Choose Your Plan
                </a>
                <a href="#contact" class="px-8 py-3 border border-indigo-500 text-indigo-500 hover:bg-indigo-500 hover:text-white rounded-md font-medium transition duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <h2 class="text-3xl font-bold mb-4">Get In <span class="gradient-text">Touch</span></h2>
                    <p class="text-gray-400 mb-8 max-w-md">
                        Have questions or need assistance? Our support team is available 24/7 to help you with anything related to our service.
                    </p>
                    <div class="space-y-6">                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-white">Email Us</h3>
                                <p class="text-gray-400">support@stallionsignalpro.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <i class="fab fa-telegram text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-white">Telegram</h3>
                                <p class="text-gray-400">@stallionsupport</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-white">Call Us</h3>
                                <p class="text-gray-400">+1 (555) 123-4567</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">                    <div class="bg-gray-700 p-8 rounded-lg">
                        <h3 class="text-xl font-bold mb-6">Send Us a Message</h3>
                        <form id="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="process_contact_form">
                            <?php wp_nonce_field('contact_form_nonce', 'contact_form_nonce'); ?>
                            <div class="mb-4">                                <label for="contact_name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                                <input type="text" id="contact_name" name="contact_name" class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div class="mb-4">
                                <label for="contact_email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                                <input type="email" id="contact_email" name="contact_email" class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>                            <div class="mb-4">
                                <label for="contact_subject" class="block text-sm font-medium text-gray-300 mb-1">Subject</label>
                                <input type="text" id="contact_subject" name="contact_subject" class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div class="mb-4">
                                <label for="contact_message" class="block text-sm font-medium text-gray-300 mb-1">Message</label>
                                <textarea id="contact_message" name="contact_message" rows="4" class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required></textarea>
                            </div>
                            <div id="contact-form-success" class="hidden mb-4 p-3 bg-green-800 text-green-200 rounded-md">
                                Your message has been sent successfully! We'll get back to you soon.
                            </div>
                            <div id="contact-form-error" class="hidden mb-4 p-3 bg-red-800 text-red-200 rounded-md">
                                There was a problem sending your message. Please try again.
                            </div>                            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition duration-300">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Enhanced styles for review images */
.review-image-container {
    display: flex;
    align-items: center; 
    justify-content: center;
    height: 400px; /* Increased height to accommodate full image content */
    background-color: #1f2937; /* Slightly lighter than background for contrast */
    padding: 16px;
    border: 1px solid rgba(107, 114, 128, 0.3); /* Subtle border */
}

.review-image-container img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain; /* Ensures full image is visible without cropping */
    transition: transform 0.3s ease;
    margin: 0; /* Reset any margin that might affect sizing */
}

.review-image-container:hover img {
    transform: scale(1.02); /* Subtle zoom on hover */
}

/* Modal image styles */
#review-modal-image {
    background-color: #1f2937;
    padding: 8px;
    border-radius: 4px;
}
</style>

<script>
// JavaScript for handling review modal functionality and pricing button interactions
document.addEventListener('DOMContentLoaded', function() {
    // Review Modal Functionality
    const reviewModal = document.getElementById('review-modal');
    const modalImage = document.getElementById('review-modal-image');
    const closeReviewButton = document.getElementById('close-review-modal');
    
    // Function to open the review modal with the selected image
    window.openReviewModal = function(reviewId) {
        const imagePath = '<?php echo esc_url(get_template_directory_uri()); ?>/assets/' + reviewId + '.jpg';
        modalImage.src = imagePath;
        modalImage.alt = 'Client Review';
        reviewModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    };
    
    // Close review modal when clicking the close button
    if (closeReviewButton) {
        closeReviewButton.addEventListener('click', function() {
            reviewModal.classList.add('hidden');
            document.body.style.overflow = ''; // Re-enable scrolling
        });
    }
    
    // Close review modal when clicking outside the modal content
    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === reviewModal) {
                reviewModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }
    
    // Login Modal Functionality
    const loginModal = document.getElementById('login-modal');
    const closeLoginButton = document.getElementById('close-login-modal');
      // Function to open the login modal
    window.openLoginModal = function(selectedPlan = '') {
        if (loginModal) {
            // Update the login redirect URL to include the profile page and selected plan if provided
            if (selectedPlan) {
                const loginRedirect = document.getElementById('login-redirect');
                const loginSelectedPlan = document.getElementById('login-selected-plan');
                
                if (loginRedirect) {
                    loginRedirect.value = '<?php echo esc_url(home_url('/profile')); ?>?selected_plan=' + encodeURIComponent(selectedPlan);
                }
                
                if (loginSelectedPlan) {
                    loginSelectedPlan.value = selectedPlan;
                }
            }
            
            loginModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    };
    
    // Close login modal when clicking the close button
    if (closeLoginButton) {
        closeLoginButton.addEventListener('click', function() {
            loginModal.classList.add('hidden');
            document.body.style.overflow = '';
        });
    }
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (reviewModal && !reviewModal.classList.contains('hidden')) {
                reviewModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            if (loginModal && !loginModal.classList.contains('hidden')) {
                loginModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
    });
    
    // Pricing button functionality
    const pricingButtons = document.querySelectorAll('.pricing-button');
    pricingButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const planName = this.getAttribute('data-plan');
            if (planName === 'free') {
                // Let the anchor redirect to Telegram
                return;
            }
            if (planName === 'forex' || planName === 'gold') {
                e.preventDefault();
                return false;
            }
            e.preventDefault();
            // Check if the user is logged in
            const isLoggedIn = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;
            if (isLoggedIn) {
                window.location.href = '<?php echo esc_url(home_url('/profile')); ?>?selected_plan=' + encodeURIComponent(planName);
            } else {
                openLoginModal(planName);
                sessionStorage.setItem('selected_plan', planName);
            }
        });
    });
    // Telegram integration in header
    const telegramHeaderBtn = document.getElementById('telegram-header-btn');
    if (telegramHeaderBtn) {
        telegramHeaderBtn.addEventListener('click', function(e) {
            const isLoggedIn = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;
            if (!isLoggedIn) {
                e.preventDefault();
                openLoginModal();
            }
        });
    }
});
</script>

<?php get_footer(); ?>
