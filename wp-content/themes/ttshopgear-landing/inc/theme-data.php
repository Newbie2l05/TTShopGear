<?php
if (! defined('ABSPATH')) {
	exit;
}

function ttshopgear_get_site_data() {
	static $data = null;

	if (null !== $data) {
		return $data;
	}

	$data = array(
		'nav' => array(
			array(
				'label' => 'GAMING KEYBOARDS',
				'slug' => 'keyboards',
				'submenu' => array('Mechanical', 'Optical', 'Wireless', '65%', 'TKL', 'Full Size'),
			),
			array(
				'label' => 'GAMING MICE',
				'slug' => 'mice',
				'submenu' => array('Wireless', 'Wired', 'Ergonomic', 'Lightweight', 'MMO'),
			),
			array(
				'label' => 'HEADSETS',
				'slug' => 'headsets',
				'submenu' => array('Wireless', 'Wired', '7.1 Surround', 'RGB'),
			),
			array(
				'label' => 'STREAMING',
				'slug' => 'streaming',
				'submenu' => array('Webcams', 'Capture Cards', 'Microphones', 'Lighting'),
			),
			array(
				'label' => 'PC COMPONENTS',
				'slug' => 'components',
				'submenu' => array('RAM', 'PSU', 'Cases', 'Cooling', 'Storage'),
			),
		),
		'footer_links' => array(
			'Products' => array(
				array('label' => 'Gaming Keyboards', 'slug' => 'keyboards'),
				array('label' => 'Gaming Mice', 'slug' => 'mice'),
				array('label' => 'Headsets', 'slug' => 'headsets'),
				array('label' => 'Streaming', 'slug' => 'streaming'),
				array('label' => 'PC Components', 'slug' => 'components'),
				array('label' => 'Accessories', 'slug' => 'accessories'),
			),
			'Support' => array(
				array('label' => 'Downloads', 'slug' => 'downloads'),
				array('label' => 'Knowledge Base', 'slug' => 'kb'),
				array('label' => 'Warranty', 'slug' => 'warranty'),
				array('label' => 'Returns', 'slug' => 'returns'),
				array('label' => 'Contact Us', 'slug' => 'contact'),
				array('label' => 'FAQs', 'slug' => 'faqs'),
			),
			'Company' => array(
				array('label' => 'About Us', 'slug' => 'about'),
				array('label' => 'Careers', 'slug' => 'careers'),
				array('label' => 'Press', 'slug' => 'press'),
				array('label' => 'Partners', 'slug' => 'partners'),
				array('label' => 'Affiliates', 'slug' => 'affiliates'),
			),
			'Legal' => array(
				array('label' => 'Privacy Policy', 'slug' => 'privacy'),
				array('label' => 'Terms of Service', 'slug' => 'terms'),
				array('label' => 'Cookie Policy', 'slug' => 'cookies'),
				array('label' => 'Accessibility', 'slug' => 'accessibility'),
			),
		),
		'slides' => array(
			array(
				'id' => 1,
				'title' => 'K100 PRO',
				'subtitle' => 'GAMING KEYBOARD',
				'description' => 'Optical-mechanical switches with 4000Hz polling rate. RGB per-key lighting with 16.8 million colors.',
				'badge' => 'NEW ARRIVAL',
				'cta' => 'Shop Now',
				'href' => '/keyboards/k100-pro',
				'gradient' => 'primary',
				'accent' => 'primary',
			),
			array(
				'id' => 2,
				'title' => 'SCIMITAR ELITE',
				'subtitle' => 'WIRELESS GAMING MOUSE',
				'description' => '26,000 DPI optical sensor. Sub-1ms SLIPSTREAM wireless. 110+ hours battery life.',
				'badge' => 'BEST SELLER',
				'cta' => 'Explore',
				'href' => '/mice/scimitar-elite',
				'gradient' => 'accent',
				'accent' => 'accent',
			),
			array(
				'id' => 3,
				'title' => 'VIRTUOSO PRO',
				'subtitle' => 'PREMIUM HEADSET',
				'description' => 'Open-back acoustic design. Broadcast-quality detachable microphone. 50mm drivers.',
				'badge' => 'PRO SERIES',
				'cta' => 'Learn More',
				'href' => '/headsets/virtuoso-pro',
				'gradient' => 'mixed',
				'accent' => 'primary',
			),
		),
		'features' => array(
			array('icon' => 'zap', 'title' => 'Lightning Fast', 'description' => 'Sub-1ms response time on all gaming peripherals'),
			array('icon' => 'shield', 'title' => '2 Year Warranty', 'description' => 'Extended coverage on all products'),
			array('icon' => 'truck', 'title' => 'Free Shipping', 'description' => 'On orders over $99'),
			array('icon' => 'headphones', 'title' => '24/7 Support', 'description' => 'Expert gaming support anytime'),
			array('icon' => 'refresh', 'title' => '30-Day Returns', 'description' => 'Hassle-free return policy'),
			array('icon' => 'award', 'title' => 'Award Winning', 'description' => 'Top-rated gaming gear'),
		),
		'categories' => array(
			'keyboards' => array(
				'slug' => 'keyboards',
				'icon' => 'keyboard',
				'name' => 'Gaming Keyboards',
				'menu_label' => 'Keyboards',
				'description' => 'Mechanical & Optical',
				'count' => '120+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Gaming Keyboards Built for Competitive Speed',
				'hero_description' => 'Optical and mechanical boards with tournament-grade response, premium switches and iconic RGB profiles tuned for esports setups.',
				'filters' => array('Mechanical', 'Optical', 'Wireless', '65%', 'TKL', 'Full Size'),
				'stats' => array(
					array('value' => '0.1ms', 'label' => 'Actuation response'),
					array('value' => '8K', 'label' => 'Polling ready'),
					array('value' => '16.8M', 'label' => 'RGB colors'),
				),
			),
			'mice' => array(
				'slug' => 'mice',
				'icon' => 'mouse',
				'name' => 'Gaming Mice',
				'menu_label' => 'Mice',
				'description' => 'Wireless & Wired',
				'count' => '85+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Gaming Mice with Precision at Every Flick',
				'hero_description' => 'From ultra-light esports mice to macro-loaded MMO workhorses, every model is tuned for reliable tracking and low-latency input.',
				'filters' => array('Wireless', 'Wired', 'Ergonomic', 'Lightweight', 'MMO'),
				'stats' => array(
					array('value' => '26K', 'label' => 'Max DPI sensor'),
					array('value' => '<1ms', 'label' => 'Wireless latency'),
					array('value' => '110h', 'label' => 'Battery life'),
				),
			),
			'headsets' => array(
				'slug' => 'headsets',
				'icon' => 'headphones',
				'name' => 'Headsets',
				'menu_label' => 'Headsets',
				'description' => '7.1 Surround Sound',
				'count' => '60+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Headsets Tuned for Immersion and Clear Comms',
				'hero_description' => 'Open-back reference sound, low-latency wireless audio and broadcast-ready microphones for ranked play, streaming and work.',
				'filters' => array('Wireless', 'Wired', '7.1 Surround', 'RGB'),
				'stats' => array(
					array('value' => '50mm', 'label' => 'Custom drivers'),
					array('value' => '24bit', 'label' => 'High fidelity audio'),
					array('value' => '20h', 'label' => 'Comfort sessions'),
				),
			),
			'streaming' => array(
				'slug' => 'streaming',
				'icon' => 'monitor',
				'name' => 'Streaming',
				'menu_label' => 'Streaming',
				'description' => 'Webcams & Capture',
				'count' => '45+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Streaming Gear for Creator-Grade Production',
				'hero_description' => 'Build a cleaner workflow with capture devices, microphones and control surfaces designed for stable streams and polished broadcasts.',
				'filters' => array('Webcams', 'Capture Cards', 'Microphones', 'Lighting'),
				'stats' => array(
					array('value' => '4K60', 'label' => 'Capture support'),
					array('value' => 'Zero', 'label' => 'Workflow friction'),
					array('value' => 'Studio', 'label' => 'Creator ready'),
				),
			),
			'components' => array(
				'slug' => 'components',
				'icon' => 'cpu',
				'name' => 'PC Components',
				'menu_label' => 'Components',
				'description' => 'RAM, PSU & More',
				'count' => '200+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'PC Components That Keep High-End Builds Stable',
				'hero_description' => 'Memory kits, power supplies, cooling and chassis components engineered for sustained performance and cleaner cable-managed setups.',
				'filters' => array('RAM', 'PSU', 'Cases', 'Cooling', 'Storage'),
				'stats' => array(
					array('value' => 'ATX 3.0', 'label' => 'Modern platform'),
					array('value' => '80+ Gold', 'label' => 'Power efficiency'),
					array('value' => 'DDR5', 'label' => 'Next-gen memory'),
				),
			),
			'controllers' => array(
				'slug' => 'controllers',
				'icon' => 'gamepad',
				'name' => 'Controllers',
				'menu_label' => 'Controllers',
				'description' => 'PC & Console',
				'count' => '30+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Controllers for Cross-Platform Play',
				'hero_description' => 'Responsive thumbsticks, durable triggers and low-latency wireless for players who switch between PC, console and cloud gaming.',
				'filters' => array('Wireless', 'Hall Effect', 'PC', 'Console'),
				'stats' => array(
					array('value' => 'Hall', 'label' => 'Stick precision'),
					array('value' => 'Low', 'label' => 'Input latency'),
					array('value' => 'Hybrid', 'label' => 'Platform support'),
				),
			),
			'accessories' => array(
				'slug' => 'accessories',
				'icon' => 'award',
				'name' => 'Accessories',
				'menu_label' => 'Accessories',
				'description' => 'Pads, Cables & More',
				'count' => '70+ Products',
				'badge' => 'CATEGORY',
				'hero_title' => 'Accessories That Complete the Setup',
				'hero_description' => 'Desk mats, cable kits, cleaning essentials and supporting gear that tighten the last 10% of your battlestation.',
				'filters' => array('Mouse Pads', 'Desk Mats', 'Cables', 'Care Kits'),
				'stats' => array(
					array('value' => 'XL', 'label' => 'Desk coverage'),
					array('value' => 'Clean', 'label' => 'Cable finish'),
					array('value' => 'Daily', 'label' => 'Usability upgrades'),
				),
			),
		),
		'products' => array(
			array(
				'id' => 1,
				'slug' => 'k100-keyboard',
				'route_aliases' => array('k100-pro', 'k100-keyboard'),
				'primary_route' => '/keyboards/k100-pro',
				'name' => 'K100 RGB Mechanical Gaming Keyboard',
				'subtitle' => 'Flagship keyboard for competitive play',
				'category_slug' => 'keyboards',
				'category' => 'Keyboards',
				'price' => '229.99',
				'original_price' => '279.99',
				'rating' => 4.8,
				'reviews' => '1,250',
				'badge' => 'Best Seller',
				'badge_class' => 'tt-badge-primary',
				'excerpt' => 'Optical-mechanical actuation, macro control and premium per-key RGB in a tournament-first chassis.',
				'description' => 'K100 RGB is tuned for players who want immediate key response, stable build quality and fast onboard profile switching across demanding titles.',
				'features' => array('Optical-mechanical switches', '4,000Hz polling rate', 'Dedicated macro column', 'Aircraft-grade frame'),
				'specs' => array('Switch Type' => 'Optical-Mechanical', 'Polling Rate' => '4,000Hz', 'Layout' => 'Full Size', 'Lighting' => 'Per-key RGB'),
			),
			array(
				'id' => 2,
				'slug' => 'scimitar-elite',
				'route_aliases' => array('scimitar-elite'),
				'primary_route' => '/mice/scimitar-elite',
				'name' => 'SCIMITAR ELITE Wireless Gaming Mouse',
				'subtitle' => 'MMO control with low-latency wireless',
				'category_slug' => 'mice',
				'category' => 'Mice',
				'price' => '149.99',
				'original_price' => '',
				'rating' => 4.9,
				'reviews' => '892',
				'badge' => 'New',
				'badge_class' => 'tt-badge-accent',
				'excerpt' => 'A 26K sensor, side macro grid and sub-1ms wireless performance for high-action multi-input games.',
				'description' => 'SCIMITAR ELITE balances speed and command density so MMO, MOBA and productivity workflows stay precise without compromise.',
				'features' => array('26,000 DPI optical sensor', '12-button side panel', 'SLIPSTREAM wireless', '110+ hour battery'),
				'specs' => array('Sensor' => '26,000 DPI', 'Connection' => 'Wireless / Wired', 'Buttons' => '16 programmable', 'Battery' => '110+ hours'),
			),
			array(
				'id' => 3,
				'slug' => 'virtuoso-headset',
				'route_aliases' => array('virtuoso-pro', 'virtuoso-headset'),
				'primary_route' => '/headsets/virtuoso-pro',
				'name' => 'VIRTUOSO RGB Wireless Gaming Headset',
				'subtitle' => 'Reference-like sound with creator-grade mic',
				'category_slug' => 'headsets',
				'category' => 'Headsets',
				'price' => '179.99',
				'original_price' => '199.99',
				'rating' => 4.7,
				'reviews' => '2,103',
				'badge' => '',
				'badge_class' => '',
				'excerpt' => 'Comfort-first headset with spacious audio tuning, detachable microphone and polished wireless integration.',
				'description' => 'VIRTUOSO RGB gives streamers and ranked players a premium all-round headset with detailed playback and reliable voice pickup.',
				'features' => array('50mm drivers', 'Detachable broadcast mic', 'Low-latency wireless', 'Comfort memory foam'),
				'specs' => array('Drivers' => '50mm', 'Microphone' => 'Detachable', 'Connection' => 'Wireless / USB', 'Audio' => 'High fidelity'),
			),
			array(
				'id' => 4,
				'slug' => 'vengeance-ram',
				'route_aliases' => array('vengeance-ram'),
				'primary_route' => '/products/vengeance-ram',
				'name' => 'VENGEANCE RGB PRO 32GB DDR5',
				'subtitle' => 'High-frequency DDR5 memory for next-gen builds',
				'category_slug' => 'components',
				'category' => 'Memory',
				'price' => '189.99',
				'original_price' => '',
				'rating' => 4.9,
				'reviews' => '3,421',
				'badge' => 'Popular',
				'badge_class' => 'tt-badge-primary-soft',
				'excerpt' => 'Stable XMP profiles, bright RGB diffusion and consistent thermals for flagship gaming rigs.',
				'description' => 'VENGEANCE RGB PRO DDR5 keeps modern systems responsive with dependable high-speed memory and clean software control.',
				'features' => array('32GB DDR5 kit', 'XMP-ready profiles', 'RGB heat spreader', 'High-speed timings'),
				'specs' => array('Capacity' => '32GB', 'Generation' => 'DDR5', 'Profile' => 'XMP', 'Use Case' => 'Gaming / Creator'),
			),
			array(
				'id' => 5,
				'slug' => 'stream-deck',
				'route_aliases' => array('stream-deck'),
				'primary_route' => '/products/stream-deck',
				'name' => 'ELGATO Stream Deck MK.2',
				'subtitle' => 'Macro automation hub for creators',
				'category_slug' => 'streaming',
				'category' => 'Streaming',
				'price' => '149.99',
				'original_price' => '169.99',
				'rating' => 4.8,
				'reviews' => '1,567',
				'badge' => 'Sale',
				'badge_class' => 'tt-badge-danger',
				'excerpt' => 'One-touch scene switching, audio control and workflow shortcuts in a compact creator desk footprint.',
				'description' => 'Stream Deck MK.2 simplifies complex live workflows into a tactile control surface you can train into daily production.',
				'features' => array('Custom LCD keys', 'Scene switching', 'App and macro triggers', 'Creator ecosystem support'),
				'specs' => array('Keys' => '15 LCD keys', 'Connection' => 'USB', 'Profiles' => 'Multi profile', 'Use Case' => 'Streaming / Automation'),
			),
			array(
				'id' => 6,
				'slug' => 'rm1000x-psu',
				'route_aliases' => array('rm1000x-psu'),
				'primary_route' => '/products/rm1000x-psu',
				'name' => 'RM1000x SHIFT Modular PSU',
				'subtitle' => 'Quiet high-wattage PSU with side connectors',
				'category_slug' => 'components',
				'category' => 'Power Supply',
				'price' => '199.99',
				'original_price' => '',
				'rating' => 4.9,
				'reviews' => '756',
				'badge' => '',
				'badge_class' => '',
				'excerpt' => 'ATX 3.0-ready power delivery with cable management that actually respects tight modern cases.',
				'description' => 'RM1000x SHIFT keeps high-end GPUs and CPUs stable under load while making the final cable pass noticeably cleaner.',
				'features' => array('ATX 3.0 support', 'Fully modular', 'Zero RPM fan mode', 'Side connector layout'),
				'specs' => array('Wattage' => '1000W', 'Efficiency' => '80+ Gold', 'Modularity' => 'Fully Modular', 'Platform' => 'ATX 3.0'),
			),
			array(
				'id' => 7,
				'slug' => 'h150i-cooler',
				'route_aliases' => array('h150i-cooler'),
				'primary_route' => '/products/h150i-cooler',
				'name' => 'iCUE H150i ELITE LCD Cooler',
				'subtitle' => 'Display-equipped AIO for flagship CPUs',
				'category_slug' => 'components',
				'category' => 'Cooling',
				'price' => '289.99',
				'original_price' => '319.99',
				'rating' => 4.7,
				'reviews' => '489',
				'badge' => 'Premium',
				'badge_class' => 'tt-badge-secondary',
				'excerpt' => 'A 360mm all-in-one cooler with LCD pump cap, refined acoustics and strong thermal headroom.',
				'description' => 'H150i ELITE LCD is built for showcase systems that need both thermal performance and premium visual presence.',
				'features' => array('360mm radiator', 'Custom LCD cap', 'Low-noise fans', 'iCUE integration'),
				'specs' => array('Radiator' => '360mm', 'Display' => 'LCD', 'Fans' => '3x PWM', 'Control' => 'Software synced'),
			),
			array(
				'id' => 8,
				'slug' => 'mm700-mousepad',
				'route_aliases' => array('mm700-mousepad'),
				'primary_route' => '/products/mm700-mousepad',
				'name' => 'MM700 RGB Extended Mouse Pad',
				'subtitle' => 'Desk-wide glide surface with clean RGB edge',
				'category_slug' => 'accessories',
				'category' => 'Accessories',
				'price' => '59.99',
				'original_price' => '',
				'rating' => 4.6,
				'reviews' => '2,890',
				'badge' => '',
				'badge_class' => '',
				'excerpt' => 'A large cloth surface that stabilizes mouse movement, unifies desk aesthetics and improves cable-free positioning.',
				'description' => 'MM700 is the finishing layer for streamlined setups that need smooth tracking and a cleaner presentation.',
				'features' => array('Extended desk coverage', 'Cloth tracking surface', 'RGB edge lighting', 'USB passthrough'),
				'specs' => array('Surface' => 'Cloth', 'Size' => 'Extended XL', 'Lighting' => 'RGB edge', 'Use Case' => 'Desk setup'),
			),
		),
		'testimonials' => array(
			array('name' => 'Alex Chen', 'role' => 'Pro Gamer', 'avatar' => 'AC', 'rating' => 5, 'text' => 'The K100 keyboard has completely transformed my competitive gameplay. The optical switches are incredibly responsive.', 'product' => 'K100 RGB Keyboard'),
			array('name' => 'Sarah Miller', 'role' => 'Streamer', 'avatar' => 'SM', 'rating' => 5, 'text' => 'Best streaming setup I have ever used. The audio quality on the VIRTUOSO is crystal clear for my audience.', 'product' => 'VIRTUOSO Headset'),
			array('name' => 'Mike Johnson', 'role' => 'Esports Coach', 'avatar' => 'MJ', 'rating' => 5, 'text' => 'I recommend TTShopGear to all my teams. Reliable, high-performance equipment that gives us the competitive edge.', 'product' => 'SCIMITAR ELITE Mouse'),
		),
		'partners' => array(
			array('name' => 'Team Liquid', 'abbr' => 'TL'),
			array('name' => 'FaZe Clan', 'abbr' => 'FC'),
			array('name' => 'Cloud9', 'abbr' => 'C9'),
			array('name' => 'T1', 'abbr' => 'T1'),
			array('name' => '100 Thieves', 'abbr' => '100T'),
			array('name' => 'G2 Esports', 'abbr' => 'G2'),
		),
		'pages' => array(
			'support' => array(
				'group' => 'Support',
				'badge' => 'SUPPORT',
				'title' => 'Support Center Built for Fast Resolution',
				'description' => 'Troubleshoot devices, request warranty help and find platform setup guides without breaking the visual flow of the storefront.',
				'cards' => array(
					array('icon' => 'headphones', 'title' => 'Live Help', 'description' => 'Get direct guidance for setup issues, firmware questions and product pairing problems.', 'link_label' => 'Contact support', 'link' => 'contact'),
					array('icon' => 'shield', 'title' => 'Warranty Service', 'description' => 'Track eligibility, replacement process and proof-of-purchase requirements.', 'link_label' => 'View warranty', 'link' => 'warranty'),
					array('icon' => 'download', 'title' => 'Drivers & Downloads', 'description' => 'Grab software, manuals and the latest desktop utilities for your gear.', 'link_label' => 'Browse downloads', 'link' => 'downloads'),
				),
				'points' => array('24/7 ticket handling', 'Warranty tracking flow', 'Knowledge base and setup guides'),
			),
			'warranty' => array(
				'group' => 'Support',
				'badge' => 'WARRANTY',
				'title' => 'Warranty Coverage with Clear Next Steps',
				'description' => 'See what is covered, what evidence is needed and how replacement timelines work before you submit a case.',
				'cards' => array(
					array('icon' => 'shield', 'title' => 'Covered Defects', 'description' => 'Manufacturing faults, non-user damage hardware issues and documented functional failure.', 'link_label' => 'Start claim', 'link' => 'contact'),
					array('icon' => 'refresh', 'title' => 'Replacement Flow', 'description' => 'Submit proof, receive review, then move into repair or replacement based on stock and region.', 'link_label' => 'See process', 'link' => 'returns'),
					array('icon' => 'award', 'title' => 'Premium Devices', 'description' => 'Flagship products receive prioritized diagnostics and tailored support checkpoints.', 'link_label' => 'Need help', 'link' => 'support'),
				),
				'points' => array('2-year standard coverage', 'Serial and receipt validation', 'Replacement status updates'),
			),
			'downloads' => array(
				'group' => 'Support',
				'badge' => 'DOWNLOADS',
				'title' => 'Drivers, Firmware and Utility Downloads',
				'description' => 'Access software packages for keyboards, mice, headsets and creator tools in a layout consistent with the rest of the storefront.',
				'cards' => array(
					array('icon' => 'download', 'title' => 'Peripheral Suite', 'description' => 'Control macros, RGB, device profiles and onboard storage synchronization.', 'link_label' => 'Keyboard tools', 'link' => 'keyboards'),
					array('icon' => 'mouse', 'title' => 'Mouse Configurator', 'description' => 'Tune DPI stages, surface calibration and battery behavior for wireless devices.', 'link_label' => 'Mouse lineup', 'link' => 'mice'),
					array('icon' => 'headphones', 'title' => 'Audio Utility', 'description' => 'Manage equalizer presets, sidetone, mic routing and firmware for headsets.', 'link_label' => 'Headset lineup', 'link' => 'headsets'),
				),
				'points' => array('Latest firmware packages', 'Platform setup guides', 'Versioned release notes'),
			),
			'kb' => array(
				'group' => 'Support',
				'badge' => 'KNOWLEDGE BASE',
				'title' => 'Troubleshooting Guides Without Guesswork',
				'description' => 'Step-by-step help for pairing, firmware recovery, performance tuning and system compatibility questions.',
				'cards' => array(
					array('icon' => 'zap', 'title' => 'Performance Fixes', 'description' => 'Resolve latency spikes, polling mismatches and unstable wireless behavior.', 'link_label' => 'Open guide', 'link' => 'support'),
					array('icon' => 'keyboard', 'title' => 'Keyboard Macros', 'description' => 'Create stable profiles, onboard assignments and quick game-specific presets.', 'link_label' => 'See keyboards', 'link' => 'keyboards'),
					array('icon' => 'monitor', 'title' => 'Streaming Setup', 'description' => 'Pair capture cards, webcams and control surfaces into one workflow.', 'link_label' => 'See streaming', 'link' => 'streaming'),
				),
				'points' => array('Pairing guides', 'Performance tuning', 'Compatibility references'),
			),
			'returns' => array(
				'group' => 'Support',
				'badge' => 'RETURNS',
				'title' => 'Returns Designed to Stay Predictable',
				'description' => 'Review your return window, packaging requirements and refund timeline in one consistent support view.',
				'cards' => array(
					array('icon' => 'refresh', 'title' => '30-Day Window', 'description' => 'Most unopened or lightly used items can enter the return flow within 30 days.', 'link_label' => 'Start return', 'link' => 'contact'),
					array('icon' => 'truck', 'title' => 'Shipping Instructions', 'description' => 'Use the approved method and include all accessories to avoid processing delays.', 'link_label' => 'Shipping support', 'link' => 'support'),
					array('icon' => 'award', 'title' => 'Refund Tracking', 'description' => 'Monitor when inspection completes and when payment reversal begins.', 'link_label' => 'View policy', 'link' => 'terms'),
				),
				'points' => array('30-day return policy', 'Inspection-based approval', 'Refund status visibility'),
			),
			'contact' => array(
				'group' => 'Support',
				'badge' => 'CONTACT',
				'title' => 'Talk to a Human When the Setup Needs It',
				'description' => 'For hardware faults, purchase issues or build consultation, route the conversation to the right team quickly.',
				'cards' => array(
					array('icon' => 'headphones', 'title' => 'Technical Support', 'description' => 'Device pairing, software setup, firmware recovery and performance diagnosis.', 'link_label' => 'Open support', 'link' => 'support'),
					array('icon' => 'cart', 'title' => 'Order Help', 'description' => 'Order status, delivery issues, replacement coordination and refund questions.', 'link_label' => 'Track policy', 'link' => 'returns'),
					array('icon' => 'award', 'title' => 'Partnerships', 'description' => 'Media, team sponsorships and affiliate opportunities for organizations and creators.', 'link_label' => 'See partners', 'link' => 'partners'),
				),
				'points' => array('Technical assistance', 'Order and logistics help', 'Partnership inquiries'),
			),
			'faqs' => array(
				'group' => 'Support',
				'badge' => 'FAQ',
				'title' => 'The Most Common Questions, Answered Cleanly',
				'description' => 'Quick answers for shipping, account, compatibility and product lifecycle questions without leaving the theme experience.',
				'cards' => array(
					array('icon' => 'truck', 'title' => 'Shipping', 'description' => 'Understand order processing times, carrier windows and free shipping thresholds.', 'link_label' => 'Shipping help', 'link' => 'support'),
					array('icon' => 'shield', 'title' => 'Warranty', 'description' => 'See standard coverage length and what usually qualifies for service.', 'link_label' => 'Warranty info', 'link' => 'warranty'),
					array('icon' => 'download', 'title' => 'Software', 'description' => 'Know where to get the latest firmware, profiles and utility installers.', 'link_label' => 'Downloads', 'link' => 'downloads'),
				),
				'points' => array('Shipping answers', 'Coverage questions', 'Software update sources'),
			),
			'about' => array(
				'group' => 'Company',
				'badge' => 'COMPANY',
				'title' => 'About TTShopGear',
				'description' => 'A storefront language built around premium gaming hardware, creator tools and stable enthusiast PC components.',
				'cards' => array(
					array('icon' => 'award', 'title' => 'Premium Curation', 'description' => 'We focus on gear that earns its place through reliability, not just marketing volume.', 'link_label' => 'Browse products', 'link' => 'products'),
					array('icon' => 'zap', 'title' => 'Performance First', 'description' => 'Every lineup is presented around latency, comfort, stability and real-world use.', 'link_label' => 'See categories', 'link' => 'keyboards'),
					array('icon' => 'headphones', 'title' => 'Support Mindset', 'description' => 'The store and support experience are designed to feel like one product.', 'link_label' => 'Support center', 'link' => 'support'),
				),
				'points' => array('Curated gaming lineup', 'Performance-led positioning', 'Support and commerce consistency'),
			),
			'careers' => array(
				'group' => 'Company',
				'badge' => 'CAREERS',
				'title' => 'Careers for People Who Care About Product Quality',
				'description' => 'We value operators, builders and support specialists who obsess over the details that users actually notice.',
				'cards' => array(
					array('icon' => 'award', 'title' => 'Product Culture', 'description' => 'Work where product presentation, support and performance all need to align.', 'link_label' => 'About us', 'link' => 'about'),
					array('icon' => 'monitor', 'title' => 'Commerce Systems', 'description' => 'Help shape storefront experiences, routing, content and user workflows.', 'link_label' => 'View store', 'link' => 'products'),
					array('icon' => 'headphones', 'title' => 'Customer Experience', 'description' => 'Join the support side that turns issues into trust-building moments.', 'link_label' => 'Support area', 'link' => 'support'),
				),
				'points' => array('Product-minded team', 'Execution-focused environment', 'Cross-functional ownership'),
			),
			'press' => array(
				'group' => 'Company',
				'badge' => 'PRESS',
				'title' => 'Press and Media Requests',
				'description' => 'A clean route for launch announcements, campaign assets and requests related to creator or esports initiatives.',
				'cards' => array(
					array('icon' => 'award', 'title' => 'Launch Materials', 'description' => 'Product assets, positioning notes and approved launch copy for media usage.', 'link_label' => 'Latest products', 'link' => 'products'),
					array('icon' => 'monitor', 'title' => 'Creator Stories', 'description' => 'Information about streaming setups, creator workflows and collaboration opportunities.', 'link_label' => 'Streaming gear', 'link' => 'streaming'),
					array('icon' => 'headphones', 'title' => 'Media Contact', 'description' => 'Route inquiries that need an official response, quote or product clarification.', 'link_label' => 'Contact', 'link' => 'contact'),
				),
				'points' => array('Launch asset access', 'Media contact path', 'Campaign support'),
			),
			'partners' => array(
				'group' => 'Company',
				'badge' => 'PARTNERS',
				'title' => 'Partnerships for Teams, Creators and Resellers',
				'description' => 'Work with a store experience designed to present products, support and sponsorship opportunities with one consistent tone.',
				'cards' => array(
					array('icon' => 'award', 'title' => 'Esports Teams', 'description' => 'Hardware bundles and support paths for competitive rosters and training facilities.', 'link_label' => 'Headsets', 'link' => 'headsets'),
					array('icon' => 'monitor', 'title' => 'Creators', 'description' => 'Streaming-first gear packages with tools that fit repeat production workflows.', 'link_label' => 'Streaming', 'link' => 'streaming'),
					array('icon' => 'cart', 'title' => 'Resellers', 'description' => 'Catalog consistency and messaging that adapts cleanly across storefront channels.', 'link_label' => 'Shop archive', 'link' => 'products'),
				),
				'points' => array('Esports and creator programs', 'Reseller collaboration', 'Aligned support workflows'),
			),
			'affiliates' => array(
				'group' => 'Company',
				'badge' => 'AFFILIATES',
				'title' => 'Affiliate Opportunities for Credible Gear Recommendations',
				'description' => 'Promote a curated lineup with category pages and product views that feel consistent from first click to final action.',
				'cards' => array(
					array('icon' => 'zap', 'title' => 'High Intent Catalog', 'description' => 'Products are positioned around performance traits that are easy to communicate honestly.', 'link_label' => 'Shop products', 'link' => 'products'),
					array('icon' => 'award', 'title' => 'Premium Positioning', 'description' => 'The storefront keeps a high-end visual system that supports professional affiliate content.', 'link_label' => 'About the brand', 'link' => 'about'),
					array('icon' => 'headphones', 'title' => 'Support Continuity', 'description' => 'Customers land in a consistent support structure after the sale.', 'link_label' => 'Support flow', 'link' => 'support'),
				),
				'points' => array('Performance-led product stories', 'Consistent purchase paths', 'Support continuity after click-through'),
			),
			'privacy' => array(
				'group' => 'Legal',
				'badge' => 'LEGAL',
				'title' => 'Privacy Policy',
				'description' => 'A clean summary route for how purchase, support and newsletter data is handled across the storefront experience.',
				'cards' => array(
					array('icon' => 'shield', 'title' => 'Order Data', 'description' => 'Information necessary for fulfillment, support validation and account communication.', 'link_label' => 'Terms', 'link' => 'terms'),
					array('icon' => 'headphones', 'title' => 'Support History', 'description' => 'Tickets, diagnostics and claim details are used to improve service continuity.', 'link_label' => 'Support', 'link' => 'support'),
					array('icon' => 'download', 'title' => 'Newsletter Consent', 'description' => 'Subscription actions are consent-based and can be revoked through account or support channels.', 'link_label' => 'Newsletter', 'link' => 'support'),
				),
				'points' => array('Order and support data handling', 'Consent-based subscriptions', 'Operational retention principles'),
			),
			'terms' => array(
				'group' => 'Legal',
				'badge' => 'LEGAL',
				'title' => 'Terms of Service',
				'description' => 'Key commercial terms for storefront usage, purchase flow, returns and account behavior presented in the same brand language.',
				'cards' => array(
					array('icon' => 'cart', 'title' => 'Order Terms', 'description' => 'Availability, pricing confirmation and fulfillment expectations for submitted orders.', 'link_label' => 'Shop products', 'link' => 'products'),
					array('icon' => 'refresh', 'title' => 'Returns & Refunds', 'description' => 'Rules around return eligibility, inspection and final refund or replacement decision.', 'link_label' => 'Returns', 'link' => 'returns'),
					array('icon' => 'shield', 'title' => 'Warranty Relationship', 'description' => 'Coverage terms interact with purchase records and product-specific exceptions.', 'link_label' => 'Warranty', 'link' => 'warranty'),
				),
				'points' => array('Commercial usage rules', 'Refund and warranty boundaries', 'Storefront purchase obligations'),
			),
			'cookies' => array(
				'group' => 'Legal',
				'badge' => 'LEGAL',
				'title' => 'Cookie Policy',
				'description' => 'Explain how browsing, analytics and storefront preferences are remembered while keeping the visual experience consistent.',
				'cards' => array(
					array('icon' => 'monitor', 'title' => 'Preference Storage', 'description' => 'Remember category, experience and session preferences for smoother repeat visits.', 'link_label' => 'Shop archive', 'link' => 'products'),
					array('icon' => 'award', 'title' => 'Experience Optimization', 'description' => 'Improve interface responsiveness and conversion flow based on usage patterns.', 'link_label' => 'About', 'link' => 'about'),
					array('icon' => 'shield', 'title' => 'Control & Choice', 'description' => 'Users can manage cookie handling through browser settings and policy controls.', 'link_label' => 'Privacy policy', 'link' => 'privacy'),
				),
				'points' => array('Preference persistence', 'Analytics usage', 'User control mechanisms'),
			),
			'accessibility' => array(
				'group' => 'Legal',
				'badge' => 'LEGAL',
				'title' => 'Accessibility Commitment',
				'description' => 'The storefront aims for clear typography, visible focus states and predictable navigation across product and support content.',
				'cards' => array(
					array('icon' => 'monitor', 'title' => 'Readable UI', 'description' => 'High-contrast text, large section hierarchy and intentional spacing across templates.', 'link_label' => 'Homepage', 'link' => ''),
					array('icon' => 'headphones', 'title' => 'Support Access', 'description' => 'Support routes mirror the same layout logic to reduce confusion during issue resolution.', 'link_label' => 'Support center', 'link' => 'support'),
					array('icon' => 'shield', 'title' => 'Continuous Refinement', 'description' => 'Accessibility improvements are folded into storefront and template updates over time.', 'link_label' => 'Contact', 'link' => 'contact'),
				),
				'points' => array('Readable contrast and typography', 'Predictable layout patterns', 'Focus and keyboard awareness'),
			),
		),
	);

	$data = ttshopgear_localize_site_data($data);

	return $data;
}

function ttshopgear_localize_site_data($data) {
	$data['nav'] = array(
		array(
			'label' => 'BÀN PHÍM GAMING',
			'slug' => 'keyboards',
			'submenu' => array('Cơ', 'Quang học', 'Không dây', '65%', 'TKL', 'Full Size'),
		),
		array(
			'label' => 'CHUỘT GAMING',
			'slug' => 'mice',
			'submenu' => array('Không dây', 'Có dây', 'Công thái học', 'Siêu nhẹ', 'MMO'),
		),
		array(
			'label' => 'TAI NGHE',
			'slug' => 'headsets',
			'submenu' => array('Không dây', 'Có dây', 'Âm thanh 7.1', 'RGB'),
		),
		array(
			'label' => 'STREAMING',
			'slug' => 'streaming',
			'submenu' => array('Webcam', 'Capture Card', 'Microphone', 'Đèn'),
		),
		array(
			'label' => 'LINH KIỆN PC',
			'slug' => 'components',
			'submenu' => array('RAM', 'Nguồn', 'Case', 'Tản nhiệt', 'Lưu trữ'),
		),
	);

	$data['footer_links'] = array(
		'Sản phẩm' => array(
			array('label' => 'Bàn phím gaming', 'slug' => 'keyboards'),
			array('label' => 'Chuột gaming', 'slug' => 'mice'),
			array('label' => 'Tai nghe', 'slug' => 'headsets'),
			array('label' => 'Streaming', 'slug' => 'streaming'),
			array('label' => 'Linh kiện PC', 'slug' => 'components'),
			array('label' => 'Phụ kiện', 'slug' => 'accessories'),
		),
		'Hỗ trợ' => array(
			array('label' => 'Tải xuống', 'slug' => 'downloads'),
			array('label' => 'Kho kiến thức', 'slug' => 'kb'),
			array('label' => 'Bảo hành', 'slug' => 'warranty'),
			array('label' => 'Đổi trả', 'slug' => 'returns'),
			array('label' => 'Liên hệ', 'slug' => 'contact'),
			array('label' => 'Câu hỏi thường gặp', 'slug' => 'faqs'),
		),
		'Công ty' => array(
			array('label' => 'Về chúng tôi', 'slug' => 'about'),
			array('label' => 'Tuyển dụng', 'slug' => 'careers'),
			array('label' => 'Báo chí', 'slug' => 'press'),
			array('label' => 'Đối tác', 'slug' => 'partners'),
			array('label' => 'Affiliate', 'slug' => 'affiliates'),
		),
		'Pháp lý' => array(
			array('label' => 'Chính sách bảo mật', 'slug' => 'privacy'),
			array('label' => 'Điều khoản dịch vụ', 'slug' => 'terms'),
			array('label' => 'Chính sách cookie', 'slug' => 'cookies'),
			array('label' => 'Khả năng truy cập', 'slug' => 'accessibility'),
		),
	);

	$data['slides'] = array(
		array(
			'id' => 1,
			'title' => 'K100 PRO',
			'subtitle' => 'BÀN PHÍM GAMING',
			'description' => 'Switch quang cơ tốc độ cao, polling rate 4000Hz và RGB từng phím cho dàn máy thi đấu chuyên nghiệp.',
			'badge' => 'HÀNG MỚI',
			'cta' => 'Mua ngay',
			'href' => '/keyboards/k100-pro',
			'match_keywords' => array('k100', 'keyboard'),
			'gradient' => 'primary',
			'accent' => 'primary',
		),
		array(
			'id' => 2,
			'title' => 'SCIMITAR ELITE',
			'subtitle' => 'CHUỘT GAMING KHÔNG DÂY',
			'description' => 'Cảm biến 26.000 DPI, kết nối không dây độ trễ thấp và pin bền bỉ cho game thủ cường độ cao.',
			'badge' => 'BÁN CHẠY',
			'cta' => 'Khám phá',
			'href' => '/mice/scimitar-elite',
			'match_keywords' => array('scimitar', 'elite'),
			'gradient' => 'accent',
			'accent' => 'accent',
		),
		array(
			'id' => 3,
			'title' => 'VIRTUOSO PRO',
			'subtitle' => 'TAI NGHE CAO CẤP',
			'description' => 'Thiết kế mở, micro tháo rời chất lượng cao và driver 50mm cho trải nghiệm âm thanh chi tiết.',
			'badge' => 'PRO SERIES',
			'cta' => 'Tìm hiểu thêm',
			'href' => '/headsets/virtuoso-pro',
			'match_keywords' => array('virtuoso', 'pro'),
			'gradient' => 'mixed',
			'accent' => 'primary',
		),
	);

	$data['features'] = array(
		array('icon' => 'zap', 'title' => 'Tốc độ cực nhanh', 'description' => 'Độ phản hồi siêu thấp cho toàn bộ thiết bị gaming'),
		array('icon' => 'shield', 'title' => 'Bảo hành 2 năm', 'description' => 'Chính sách bảo hành rõ ràng và ổn định'),
		array('icon' => 'truck', 'title' => 'Miễn phí vận chuyển', 'description' => 'Áp dụng cho đơn đủ điều kiện'),
		array('icon' => 'headphones', 'title' => 'Hỗ trợ 24/7', 'description' => 'Đội ngũ hỗ trợ am hiểu thiết bị gaming'),
		array('icon' => 'refresh', 'title' => 'Đổi trả 30 ngày', 'description' => 'Quy trình đổi trả minh bạch, gọn gàng'),
		array('icon' => 'award', 'title' => 'Thiết bị nổi bật', 'description' => 'Danh mục tối ưu cho game thủ và streamer'),
	);

	$data['categories']['keyboards']['name'] = 'Bàn phím gaming';
	$data['categories']['keyboards']['menu_label'] = 'Bàn phím';
	$data['categories']['keyboards']['description'] = 'Cơ & quang học';
	$data['categories']['keyboards']['count'] = '120+ sản phẩm';
	$data['categories']['keyboards']['badge'] = 'DANH MỤC';
	$data['categories']['keyboards']['hero_title'] = 'Bàn phím gaming tối ưu cho tốc độ thi đấu';
	$data['categories']['keyboards']['hero_description'] = 'Từ bàn phím 65% gọn nhẹ đến full size cao cấp, mọi lựa chọn đều tập trung vào độ phản hồi, độ bền và cảm giác gõ ổn định.';
	$data['categories']['keyboards']['filters'] = array('Cơ', 'Quang học', 'Không dây', '65%', 'TKL', 'Full Size');
	$data['categories']['keyboards']['stats'] = array(
		array('value' => '0.1ms', 'label' => 'Thời gian phản hồi'),
		array('value' => '8K', 'label' => 'Polling rate sẵn sàng'),
		array('value' => '16.8M', 'label' => 'Màu RGB'),
	);

	$data['categories']['mice']['name'] = 'Chuột gaming';
	$data['categories']['mice']['menu_label'] = 'Chuột';
	$data['categories']['mice']['description'] = 'Không dây & có dây';
	$data['categories']['mice']['count'] = '85+ sản phẩm';
	$data['categories']['mice']['badge'] = 'DANH MỤC';
	$data['categories']['mice']['hero_title'] = 'Chuột gaming chuẩn xác trong từng cú flick';
	$data['categories']['mice']['hero_description'] = 'Danh mục chuột cho FPS, MMO, MOBA và làm việc đa tác vụ với cảm biến chính xác, form cầm thoải mái và độ trễ thấp.';
	$data['categories']['mice']['filters'] = array('Không dây', 'Có dây', 'Công thái học', 'Siêu nhẹ', 'MMO');
	$data['categories']['mice']['stats'] = array(
		array('value' => '26K', 'label' => 'DPI tối đa'),
		array('value' => '<1ms', 'label' => 'Độ trễ không dây'),
		array('value' => '110h', 'label' => 'Thời lượng pin'),
	);

	$data['categories']['headsets']['name'] = 'Tai nghe gaming';
	$data['categories']['headsets']['menu_label'] = 'Tai nghe';
	$data['categories']['headsets']['description'] = 'Âm thanh 7.1';
	$data['categories']['headsets']['count'] = '60+ sản phẩm';
	$data['categories']['headsets']['badge'] = 'DANH MỤC';
	$data['categories']['headsets']['hero_title'] = 'Tai nghe gaming cho âm thanh sống động và giao tiếp rõ nét';
	$data['categories']['headsets']['hero_description'] = 'Từ headset không dây chơi game đến tai nghe phục vụ streaming, mọi lựa chọn đều cân bằng giữa chất âm, micro và độ thoải mái.';
	$data['categories']['headsets']['filters'] = array('Không dây', 'Có dây', 'Âm thanh 7.1', 'RGB');
	$data['categories']['headsets']['stats'] = array(
		array('value' => '50mm', 'label' => 'Driver lớn'),
		array('value' => '24bit', 'label' => 'Âm thanh chi tiết'),
		array('value' => '20h', 'label' => 'Đeo thoải mái lâu dài'),
	);

	$data['categories']['streaming']['name'] = 'Thiết bị streaming';
	$data['categories']['streaming']['menu_label'] = 'Streaming';
	$data['categories']['streaming']['description'] = 'Webcam & capture';
	$data['categories']['streaming']['count'] = '45+ sản phẩm';
	$data['categories']['streaming']['badge'] = 'DANH MỤC';
	$data['categories']['streaming']['hero_title'] = 'Thiết bị streaming cho workflow gọn và chuyên nghiệp';
	$data['categories']['streaming']['hero_description'] = 'Webcam, capture card, microphone và phụ kiện creator giúp góc máy và quy trình lên sóng ổn định hơn.';
	$data['categories']['streaming']['filters'] = array('Webcam', 'Capture Card', 'Microphone', 'Đèn');
	$data['categories']['streaming']['stats'] = array(
		array('value' => '4K60', 'label' => 'Chuẩn capture'),
		array('value' => 'Studio', 'label' => 'Sẵn cho creator'),
		array('value' => 'Live', 'label' => 'Lên sóng ổn định'),
	);

	$data['categories']['components']['name'] = 'Linh kiện PC';
	$data['categories']['components']['menu_label'] = 'Linh kiện';
	$data['categories']['components']['description'] = 'RAM, nguồn & hơn nữa';
	$data['categories']['components']['count'] = '200+ sản phẩm';
	$data['categories']['components']['badge'] = 'DANH MỤC';
	$data['categories']['components']['hero_title'] = 'Linh kiện PC ổn định cho cấu hình hiệu năng cao';
	$data['categories']['components']['hero_description'] = 'Từ RAM DDR5, nguồn ATX 3.0 đến tản nhiệt và case, mọi sản phẩm đều hướng đến độ ổn định và khả năng nâng cấp lâu dài.';
	$data['categories']['components']['filters'] = array('RAM', 'Nguồn', 'Case', 'Tản nhiệt', 'Lưu trữ');
	$data['categories']['components']['stats'] = array(
		array('value' => 'ATX 3.0', 'label' => 'Nền tảng hiện đại'),
		array('value' => '80+ Gold', 'label' => 'Hiệu suất điện năng'),
		array('value' => 'DDR5', 'label' => 'Bộ nhớ thế hệ mới'),
	);

	$data['categories']['controllers']['name'] = 'Tay cầm chơi game';
	$data['categories']['controllers']['menu_label'] = 'Tay cầm';
	$data['categories']['controllers']['description'] = 'PC & console';
	$data['categories']['controllers']['count'] = '30+ sản phẩm';
	$data['categories']['controllers']['badge'] = 'DANH MỤC';
	$data['categories']['controllers']['hero_title'] = 'Tay cầm đa nền tảng cho game thủ PC và console';
	$data['categories']['controllers']['hero_description'] = 'Danh mục tay cầm tối ưu cho cảm giác bấm, độ chính xác và độ bền khi chơi lâu dài.';
	$data['categories']['controllers']['filters'] = array('Không dây', 'Hall Effect', 'PC', 'Console');
	$data['categories']['controllers']['stats'] = array(
		array('value' => 'Hall', 'label' => 'Cảm biến analog'),
		array('value' => 'Low', 'label' => 'Độ trễ thấp'),
		array('value' => 'Hybrid', 'label' => 'Hỗ trợ đa nền tảng'),
	);

	$data['categories']['accessories']['name'] = 'Phụ kiện gaming';
	$data['categories']['accessories']['menu_label'] = 'Phụ kiện';
	$data['categories']['accessories']['description'] = 'Pad, cáp & hơn nữa';
	$data['categories']['accessories']['count'] = '70+ sản phẩm';
	$data['categories']['accessories']['badge'] = 'DANH MỤC';
	$data['categories']['accessories']['hero_title'] = 'Phụ kiện hoàn thiện góc máy gaming';
	$data['categories']['accessories']['hero_description'] = 'Tấm lót, cáp, hub, kê tay và nhiều phụ kiện nhỏ giúp setup đồng bộ và sử dụng thoải mái hơn mỗi ngày.';
	$data['categories']['accessories']['filters'] = array('Mouse Pad', 'Desk Mat', 'Cáp', 'Bộ vệ sinh');
	$data['categories']['accessories']['stats'] = array(
		array('value' => 'XL', 'label' => 'Phủ mặt bàn'),
		array('value' => 'Clean', 'label' => 'Hoàn thiện gọn gàng'),
		array('value' => 'Daily', 'label' => 'Dùng hằng ngày'),
	);

	$data['testimonials'] = array(
		array('name' => 'Minh Quân', 'role' => 'Tuyển thủ FPS', 'avatar' => 'MQ', 'rating' => 5, 'text' => 'Bàn phím K100 cho cảm giác phản hồi rất chắc tay, gõ nhanh và giữ nhịp tốt trong các trận rank căng thẳng.', 'product' => 'K100 RGB'),
		array('name' => 'Thảo Nhi', 'role' => 'Streamer', 'avatar' => 'TN', 'rating' => 5, 'text' => 'Bộ tai nghe và thiết bị streaming ở đây đồng bộ rất tốt, lên hình đẹp và xử lý công việc hàng ngày ổn định.', 'product' => 'VIRTUOSO RGB'),
		array('name' => 'Hoàng Nam', 'role' => 'Huấn luyện viên Esports', 'avatar' => 'HN', 'rating' => 5, 'text' => 'Danh mục gear rõ ràng, sản phẩm dễ chọn, hỗ trợ cũng nhanh nên rất phù hợp để build setup cho cả đội tuyển.', 'product' => 'SCIMITAR ELITE'),
	);

	$data['pages'] = array(
		'support' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'HỖ TRỢ',
			'title' => 'Trung tâm hỗ trợ xử lý nhanh và rõ ràng',
			'description' => 'Từ hướng dẫn cài đặt, lỗi phần mềm đến tư vấn cấu hình và bảo hành, mọi đầu mục đều được tổ chức để người dùng dễ tra cứu.',
			'cards' => array(
				array('icon' => 'headphones', 'title' => 'Hỗ trợ kỹ thuật', 'description' => 'Tư vấn cài đặt, ghép nối thiết bị, lỗi phần mềm và tối ưu hiệu năng sử dụng.', 'link_label' => 'Liên hệ hỗ trợ', 'link' => 'contact'),
				array('icon' => 'shield', 'title' => 'Dịch vụ bảo hành', 'description' => 'Tra điều kiện bảo hành, quy trình đổi mới và xác minh thông tin sản phẩm.', 'link_label' => 'Xem bảo hành', 'link' => 'warranty'),
				array('icon' => 'download', 'title' => 'Driver và tải xuống', 'description' => 'Tải phần mềm, firmware và tài liệu hướng dẫn cho toàn bộ hệ sinh thái thiết bị.', 'link_label' => 'Mở trang tải xuống', 'link' => 'downloads'),
			),
			'points' => array('Hỗ trợ phản hồi nhanh', 'Theo dõi bảo hành rõ ràng', 'Kho hướng dẫn và FAQ đầy đủ'),
		),
		'warranty' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'BẢO HÀNH',
			'title' => 'Chính sách bảo hành minh bạch, dễ theo dõi',
			'description' => 'Nắm rõ điều kiện áp dụng, giấy tờ cần có và các bước xử lý khi sản phẩm gặp lỗi kỹ thuật.',
			'cards' => array(
				array('icon' => 'shield', 'title' => 'Lỗi được hỗ trợ', 'description' => 'Bao gồm lỗi phần cứng do nhà sản xuất và các sự cố phát sinh trong quá trình sử dụng đúng cách.', 'link_label' => 'Gửi yêu cầu', 'link' => 'contact'),
				array('icon' => 'refresh', 'title' => 'Quy trình đổi mới', 'description' => 'Từ kiểm tra tình trạng, tiếp nhận thông tin đến thay thế hoặc sửa chữa theo chính sách.', 'link_label' => 'Xem quy trình', 'link' => 'returns'),
				array('icon' => 'award', 'title' => 'Thiết bị cao cấp', 'description' => 'Một số dòng flagship sẽ có quy trình hỗ trợ ưu tiên và chẩn đoán nhanh hơn.', 'link_label' => 'Cần hỗ trợ thêm', 'link' => 'support'),
			),
			'points' => array('Bảo hành tiêu chuẩn 24 tháng', 'Xác minh bằng serial và hóa đơn', 'Cập nhật tiến độ rõ ràng'),
		),
		'downloads' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'TẢI XUỐNG',
			'title' => 'Kho driver, firmware và tiện ích',
			'description' => 'Tập trung các bản cập nhật và phần mềm cần thiết để bàn phím, chuột, tai nghe và thiết bị streaming hoạt động ổn định.',
			'cards' => array(
				array('icon' => 'download', 'title' => 'Bộ công cụ thiết bị', 'description' => 'Quản lý macro, RGB, hồ sơ thiết bị và đồng bộ cài đặt cho nhiều sản phẩm.', 'link_label' => 'Xem bàn phím', 'link' => 'keyboards'),
				array('icon' => 'mouse', 'title' => 'Phần mềm chuột', 'description' => 'Tinh chỉnh DPI, polling rate, profile lưu sẵn và thời lượng pin cho thiết bị không dây.', 'link_label' => 'Xem chuột', 'link' => 'mice'),
				array('icon' => 'headphones', 'title' => 'Phần mềm âm thanh', 'description' => 'Cập nhật EQ, âm thanh vòm, sidetone và firmware cho tai nghe gaming.', 'link_label' => 'Xem tai nghe', 'link' => 'headsets'),
			),
			'points' => array('Firmware mới nhất', 'Tài liệu cài đặt', 'Bản phát hành theo phiên bản'),
		),
		'kb' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'KIẾN THỨC',
			'title' => 'Kho kiến thức xử lý lỗi và hướng dẫn',
			'description' => 'Tổng hợp các bước cài đặt, xử lý sự cố, cập nhật firmware và tối ưu hiệu năng cho từng nhóm thiết bị.',
			'cards' => array(
				array('icon' => 'zap', 'title' => 'Tối ưu hiệu năng', 'description' => 'Khắc phục hiện tượng trễ, mất kết nối, không nhận profile hoặc polling rate sai.', 'link_label' => 'Xem hỗ trợ', 'link' => 'support'),
				array('icon' => 'keyboard', 'title' => 'Macro bàn phím', 'description' => 'Thiết lập macro, lưu onboard profile và chuyển preset nhanh cho từng tựa game.', 'link_label' => 'Mở danh mục bàn phím', 'link' => 'keyboards'),
				array('icon' => 'monitor', 'title' => 'Thiết lập streaming', 'description' => 'Hướng dẫn kết nối webcam, capture card, micro và phần mềm live stream.', 'link_label' => 'Mở thiết bị streaming', 'link' => 'streaming'),
			),
			'points' => array('Hướng dẫn ghép nối', 'Tối ưu hiệu năng', 'Tài liệu tương thích'),
		),
		'returns' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'ĐỔI TRẢ',
			'title' => 'Đổi trả rõ điều kiện, xử lý gọn',
			'description' => 'Theo dõi thời hạn đổi trả, điều kiện sản phẩm và tiến độ hoàn tiền hoặc đổi mới.',
			'cards' => array(
				array('icon' => 'refresh', 'title' => 'Trong 30 ngày', 'description' => 'Áp dụng cho nhiều sản phẩm còn đủ phụ kiện và đáp ứng điều kiện kiểm tra thực tế.', 'link_label' => 'Gửi yêu cầu', 'link' => 'contact'),
				array('icon' => 'truck', 'title' => 'Hướng dẫn gửi hàng', 'description' => 'Chuẩn bị đóng gói, phụ kiện và hình ảnh để quy trình tiếp nhận diễn ra nhanh hơn.', 'link_label' => 'Xem hỗ trợ', 'link' => 'support'),
				array('icon' => 'award', 'title' => 'Theo dõi hoàn tiền', 'description' => 'Cập nhật trạng thái kiểm tra sản phẩm và mốc thời gian xử lý hoàn tiền.', 'link_label' => 'Xem điều khoản', 'link' => 'terms'),
			),
			'points' => array('Thời hạn 30 ngày', 'Kiểm tra trước khi duyệt', 'Theo dõi tiến độ hoàn tiền'),
		),
		'contact' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'LIÊN HỆ',
			'title' => 'Liên hệ đúng bộ phận, xử lý đúng vấn đề',
			'description' => 'Dành cho lỗi kỹ thuật, vấn đề đơn hàng, hợp tác thương hiệu hoặc tư vấn cấu hình thiết bị.',
			'cards' => array(
				array('icon' => 'headphones', 'title' => 'Kỹ thuật', 'description' => 'Hỗ trợ ghép nối thiết bị, lỗi firmware, không nhận driver hoặc tinh chỉnh hiệu năng.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
				array('icon' => 'cart', 'title' => 'Đơn hàng', 'description' => 'Tra cứu trạng thái giao hàng, hoàn tiền, đổi trả và thông tin thanh toán.', 'link_label' => 'Xem đổi trả', 'link' => 'returns'),
				array('icon' => 'award', 'title' => 'Hợp tác', 'description' => 'Liên hệ về đối tác, tài trợ đội tuyển, creator hoặc chương trình affiliate.', 'link_label' => 'Xem đối tác', 'link' => 'partners'),
			),
			'points' => array('Hỗ trợ kỹ thuật', 'Hỗ trợ đơn hàng', 'Liên hệ hợp tác'),
		),
		'faqs' => array(
			'group' => 'Hỗ trợ',
			'badge' => 'FAQ',
			'title' => 'Câu hỏi thường gặp',
			'description' => 'Tổng hợp nhanh các câu hỏi về vận chuyển, bảo hành, phần mềm và chính sách mua hàng.',
			'cards' => array(
				array('icon' => 'truck', 'title' => 'Vận chuyển', 'description' => 'Thời gian xử lý đơn, đối tác giao hàng và điều kiện miễn phí vận chuyển.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
				array('icon' => 'shield', 'title' => 'Bảo hành', 'description' => 'Điều kiện áp dụng, cách kiểm tra thời hạn và quy trình đổi mới khi gặp lỗi.', 'link_label' => 'Xem bảo hành', 'link' => 'warranty'),
				array('icon' => 'download', 'title' => 'Phần mềm', 'description' => 'Nơi tải driver, firmware và các tiện ích quản lý thiết bị mới nhất.', 'link_label' => 'Xem tải xuống', 'link' => 'downloads'),
			),
			'points' => array('Giải đáp nhanh', 'Chính sách rõ ràng', 'Dễ tra cứu theo nhu cầu'),
		),
		'about' => array(
			'group' => 'Công ty',
			'badge' => 'CÔNG TY',
			'title' => 'Về TTShopGear',
			'description' => 'TTShopGear xây dựng hệ sinh thái bán lẻ gear gaming và linh kiện PC với trọng tâm là hiệu năng, độ ổn định và trải nghiệm rõ ràng.',
			'cards' => array(
				array('icon' => 'award', 'title' => 'Danh mục chọn lọc', 'description' => 'Ưu tiên những sản phẩm thực sự hữu ích cho game thủ, streamer và người dùng chú trọng hiệu năng.', 'link_label' => 'Xem cửa hàng', 'link' => 'products'),
				array('icon' => 'zap', 'title' => 'Tư duy hiệu năng', 'description' => 'Tập trung vào tốc độ phản hồi, cảm giác sử dụng, tính ổn định và khả năng nâng cấp lâu dài.', 'link_label' => 'Xem bàn phím', 'link' => 'keyboards'),
				array('icon' => 'headphones', 'title' => 'Hỗ trợ đồng bộ', 'description' => 'Trải nghiệm bán hàng và hỗ trợ sau mua được thiết kế như một hệ thống thống nhất.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
			),
			'points' => array('Danh mục tập trung hiệu năng', 'Trình bày rõ ràng', 'Hỗ trợ sau bán đồng bộ'),
		),
		'careers' => array(
			'group' => 'Công ty',
			'badge' => 'TUYỂN DỤNG',
			'title' => 'Làm việc cùng đội ngũ yêu chất lượng sản phẩm',
			'description' => 'Chúng tôi tìm kiếm những người chú ý đến chi tiết, trải nghiệm người dùng và khả năng triển khai thực tế.',
			'cards' => array(
				array('icon' => 'award', 'title' => 'Văn hóa sản phẩm', 'description' => 'Mọi quyết định đều xoay quanh chất lượng giao diện, sản phẩm và trải nghiệm sử dụng cuối cùng.', 'link_label' => 'Về chúng tôi', 'link' => 'about'),
				array('icon' => 'monitor', 'title' => 'Thương mại điện tử', 'description' => 'Tham gia xây dựng trải nghiệm mua sắm, cấu trúc nội dung và hành trình người dùng.', 'link_label' => 'Xem cửa hàng', 'link' => 'products'),
				array('icon' => 'headphones', 'title' => 'Trải nghiệm khách hàng', 'description' => 'Biến các vấn đề hỗ trợ thành cơ hội tăng niềm tin với khách hàng.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
			),
			'points' => array('Môi trường thực chiến', 'Ưu tiên chất lượng', 'Làm việc liên phòng ban'),
		),
		'press' => array(
			'group' => 'Công ty',
			'badge' => 'BÁO CHÍ',
			'title' => 'Thông tin báo chí và truyền thông',
			'description' => 'Kênh tiếp nhận yêu cầu về ra mắt sản phẩm, truyền thông thương hiệu và hợp tác với creator hoặc đội tuyển.',
			'cards' => array(
				array('icon' => 'award', 'title' => 'Tài liệu ra mắt', 'description' => 'Bao gồm hình ảnh, mô tả, điểm nổi bật và các ghi chú truyền thông cho từng sản phẩm.', 'link_label' => 'Xem sản phẩm', 'link' => 'products'),
				array('icon' => 'monitor', 'title' => 'Creator & streaming', 'description' => 'Thông tin liên quan đến thiết bị streaming, workflow sản xuất nội dung và case study.', 'link_label' => 'Xem streaming', 'link' => 'streaming'),
				array('icon' => 'headphones', 'title' => 'Liên hệ media', 'description' => 'Dành cho yêu cầu cần phản hồi chính thức, phát ngôn hoặc xác minh thông tin sản phẩm.', 'link_label' => 'Liên hệ', 'link' => 'contact'),
			),
			'points' => array('Tài nguyên truyền thông', 'Đầu mối liên hệ rõ ràng', 'Thông tin sản phẩm nhất quán'),
		),
		'partners' => array(
			'group' => 'Công ty',
			'badge' => 'ĐỐI TÁC',
			'title' => 'Hợp tác cho đội tuyển, creator và reseller',
			'description' => 'Phối hợp cùng TTShopGear để xây dựng chương trình tài trợ, bundle thiết bị hoặc kênh bán hàng phù hợp từng mô hình.',
			'cards' => array(
				array('icon' => 'award', 'title' => 'Đội tuyển Esports', 'description' => 'Tối ưu danh mục và hỗ trợ triển khai gear cho đội hình thi đấu, phòng máy hoặc training room.', 'link_label' => 'Xem tai nghe', 'link' => 'headsets'),
				array('icon' => 'monitor', 'title' => 'Creator', 'description' => 'Thiết bị streaming, audio và workflow creator đồng bộ để hỗ trợ quá trình sản xuất nội dung.', 'link_label' => 'Xem streaming', 'link' => 'streaming'),
				array('icon' => 'cart', 'title' => 'Reseller', 'description' => 'Chuẩn hóa danh mục, nội dung và tuyến sản phẩm cho các kênh bán hàng mở rộng.', 'link_label' => 'Xem cửa hàng', 'link' => 'products'),
			),
			'points' => array('Tài trợ đội tuyển', 'Bundle creator', 'Mở rộng kênh bán'),
		),
		'affiliates' => array(
			'group' => 'Công ty',
			'badge' => 'AFFILIATE',
			'title' => 'Chương trình affiliate cho nội dung chất lượng',
			'description' => 'Phù hợp cho reviewer, creator và publisher muốn giới thiệu gear theo cách rõ ràng, đáng tin cậy và có tính chuyển đổi.',
			'cards' => array(
				array('icon' => 'zap', 'title' => 'Danh mục có định hướng', 'description' => 'Sản phẩm được trình bày theo hiệu năng và tình huống sử dụng, giúp nội dung đánh giá dễ thuyết phục hơn.', 'link_label' => 'Xem cửa hàng', 'link' => 'products'),
				array('icon' => 'award', 'title' => 'Hình ảnh đồng bộ', 'description' => 'Giao diện cửa hàng và trang sản phẩm giữ cảm giác cao cấp, hỗ trợ tốt cho chiến dịch affiliate.', 'link_label' => 'Về thương hiệu', 'link' => 'about'),
				array('icon' => 'headphones', 'title' => 'Hỗ trợ sau bán', 'description' => 'Khách hàng đi từ nội dung review tới hỗ trợ sau mua trên một hệ thống thống nhất.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
			),
			'points' => array('Dễ kể chuyện sản phẩm', 'Trải nghiệm mua hàng rõ ràng', 'Hỗ trợ sau bán mạch lạc'),
		),
		'privacy' => array(
			'group' => 'Pháp lý',
			'badge' => 'PHÁP LÝ',
			'title' => 'Chính sách bảo mật',
			'description' => 'Tóm tắt cách dữ liệu đơn hàng, bảo hành và đăng ký nhận tin được lưu trữ, sử dụng và bảo vệ.',
			'cards' => array(
				array('icon' => 'shield', 'title' => 'Dữ liệu đơn hàng', 'description' => 'Sử dụng cho mục đích giao hàng, xác minh thanh toán và hỗ trợ sau mua.', 'link_label' => 'Xem điều khoản', 'link' => 'terms'),
				array('icon' => 'headphones', 'title' => 'Lịch sử hỗ trợ', 'description' => 'Thông tin hỗ trợ được lưu để tiếp tục xử lý nhanh và chính xác hơn ở các lần liên hệ tiếp theo.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
				array('icon' => 'download', 'title' => 'Đăng ký nhận tin', 'description' => 'Email dùng cho bản tin và ưu đãi chỉ được sử dụng khi có sự đồng ý rõ ràng từ người dùng.', 'link_label' => 'Xem hỗ trợ', 'link' => 'support'),
			),
			'points' => array('Bảo vệ dữ liệu đơn hàng', 'Chỉ dùng khi có mục đích rõ ràng', 'Tôn trọng quyền riêng tư người dùng'),
		),
		'terms' => array(
			'group' => 'Pháp lý',
			'badge' => 'PHÁP LÝ',
			'title' => 'Điều khoản dịch vụ',
			'description' => 'Bao gồm quy định về giá bán, xác nhận đơn hàng, đổi trả, bảo hành và trách nhiệm giữa người mua với cửa hàng.',
			'cards' => array(
				array('icon' => 'cart', 'title' => 'Điều khoản đơn hàng', 'description' => 'Thông tin về xác nhận giá, tồn kho, thời gian xử lý và điều kiện hoàn tất đơn hàng.', 'link_label' => 'Xem sản phẩm', 'link' => 'products'),
				array('icon' => 'refresh', 'title' => 'Đổi trả & hoàn tiền', 'description' => 'Mô tả phạm vi áp dụng, thời hạn và các trường hợp được tiếp nhận hoặc từ chối.', 'link_label' => 'Mở đổi trả', 'link' => 'returns'),
				array('icon' => 'shield', 'title' => 'Bảo hành', 'description' => 'Liên quan đến điều kiện, giới hạn trách nhiệm và yêu cầu xác minh sản phẩm.', 'link_label' => 'Xem bảo hành', 'link' => 'warranty'),
			),
			'points' => array('Quy định mua bán rõ ràng', 'Đổi trả minh bạch', 'Bảo hành có điều kiện cụ thể'),
		),
		'cookies' => array(
			'group' => 'Pháp lý',
			'badge' => 'PHÁP LÝ',
			'title' => 'Chính sách cookie',
			'description' => 'Giải thích cách website ghi nhớ phiên truy cập, tối ưu trải nghiệm và hỗ trợ đo lường hiệu quả sử dụng.',
			'cards' => array(
				array('icon' => 'monitor', 'title' => 'Ghi nhớ tuỳ chọn', 'description' => 'Lưu lại một số cài đặt cần thiết để việc duyệt và mua hàng thuận tiện hơn.', 'link_label' => 'Xem cửa hàng', 'link' => 'products'),
				array('icon' => 'award', 'title' => 'Tối ưu trải nghiệm', 'description' => 'Cookie hỗ trợ phân tích hành vi cơ bản để cải thiện điều hướng và hiệu suất giao diện.', 'link_label' => 'Về chúng tôi', 'link' => 'about'),
				array('icon' => 'shield', 'title' => 'Quyền kiểm soát', 'description' => 'Người dùng có thể tự điều chỉnh cookie thông qua trình duyệt và cài đặt riêng tư.', 'link_label' => 'Xem bảo mật', 'link' => 'privacy'),
			),
			'points' => array('Ghi nhớ phiên truy cập', 'Tối ưu giao diện', 'Người dùng có quyền kiểm soát'),
		),
		'accessibility' => array(
			'group' => 'Pháp lý',
			'badge' => 'PHÁP LÝ',
			'title' => 'Cam kết khả năng truy cập',
			'description' => 'Website ưu tiên độ tương phản tốt, cấu trúc nội dung rõ ràng và trạng thái focus dễ nhận biết để hỗ trợ nhiều nhóm người dùng hơn.',
			'cards' => array(
				array('icon' => 'monitor', 'title' => 'Giao diện dễ đọc', 'description' => 'Cấu trúc chữ, màu sắc và khoảng cách được tối ưu cho việc đọc lâu và thao tác liên tục.', 'link_label' => 'Trang chủ', 'link' => ''),
				array('icon' => 'headphones', 'title' => 'Hỗ trợ đồng bộ', 'description' => 'Các route hỗ trợ, bảo hành và FAQ giữ chung logic hiển thị để giảm cảm giác rối.', 'link_label' => 'Mở hỗ trợ', 'link' => 'support'),
				array('icon' => 'shield', 'title' => 'Liên tục cải thiện', 'description' => 'Những cập nhật về giao diện và template sẽ tiếp tục xem xét yếu tố truy cập trong quá trình phát triển.', 'link_label' => 'Liên hệ', 'link' => 'contact'),
			),
			'points' => array('Tăng độ dễ đọc', 'Điều hướng nhất quán', 'Tiếp tục tối ưu theo thời gian'),
		),
	);

	return $data;
}

function ttshopgear_has_woocommerce() {
	return class_exists('WooCommerce') && post_type_exists('product') && taxonomy_exists('product_cat');
}

function ttshopgear_has_live_products() {
	if (! ttshopgear_has_woocommerce()) {
		return false;
	}

	$count = wp_count_posts('product');

	return isset($count->publish) && (int) $count->publish > 0;
}

function ttshopgear_translate_product_type_label($type) {
	$map = array(
		'simple' => 'Đơn giản',
		'variable' => 'Biến thể',
		'grouped' => 'Nhóm sản phẩm',
		'external' => 'Liên kết ngoài',
	);

	return isset($map[ $type ]) ? $map[ $type ] : ucfirst((string) $type);
}

function ttshopgear_translate_stock_status_label($status) {
	$map = array(
		'instock' => 'Còn hàng',
		'outofstock' => 'Hết hàng',
		'onbackorder' => 'Đặt trước',
	);

	return isset($map[ $status ]) ? $map[ $status ] : ucfirst((string) $status);
}

function ttshopgear_map_wc_term_to_category($term, $fallback = array()) {
	$data = wp_parse_args(
		$fallback,
		array(
			'slug' => $term->slug,
			'icon' => 'award',
			'name' => $term->name,
			'menu_label' => $term->name,
			'description' => $term->description ? wp_strip_all_tags($term->description) : 'Premium catalog category',
			'count' => $term->count . '+ sản phẩm',
			'badge' => 'DANH MỤC',
			'hero_title' => $term->name,
			'hero_description' => $term->description ? wp_strip_all_tags($term->description) : 'Explore the latest products in this category with the same visual language as the homepage.',
			'filters' => array(),
			'stats' => array(
				array('value' => (string) $term->count, 'label' => 'Sản phẩm đang đăng'),
				array('value' => 'Thật', 'label' => 'Đang đồng bộ WooCommerce'),
				array('value' => 'Sẵn', 'label' => 'Sẵn cho storefront'),
			),
			'term_id' => (int) $term->term_id,
			'is_real' => true,
		)
	);

	$data['slug']       = $term->slug;
	$data['name']       = $term->name;
	$data['menu_label'] = ! empty($fallback['menu_label']) ? $fallback['menu_label'] : $term->name;
	$data['count']      = $term->count . '+ sản phẩm';
	$data['term_id']    = (int) $term->term_id;
	$data['is_real']    = true;

	if (! empty($term->description)) {
		$description              = wp_strip_all_tags($term->description);
		$data['description']      = $description;
		$data['hero_description'] = $description;
	}

	if (empty($data['hero_title'])) {
		$data['hero_title'] = $term->name;
	}

	return $data;
}

function ttshopgear_normalize_attached_file_path($path) {
	$path = str_replace('\\', '/', (string) $path);
	$prefix = 'ttshopgear-real-catalog';

	if ('' !== $path && 0 === strpos($path, $prefix) && 0 !== strpos($path, $prefix . '/')) {
		return preg_replace('/^' . preg_quote($prefix, '/') . '(?!\/)/', $prefix . '/', $path, 1);
	}

	return $path;
}

function ttshopgear_get_attachment_image_url_safe($attachment_id, $size = 'large') {
	$attachment_id = (int) $attachment_id;
	if ($attachment_id <= 0) {
		return '';
	}

	$url = wp_get_attachment_image_url($attachment_id, $size);
	if (! empty($url)) {
		return (string) $url;
	}

	$relative = ttshopgear_normalize_attached_file_path(get_post_meta($attachment_id, '_wp_attached_file', true));
	if ('' === $relative) {
		return '';
	}

	$uploads = wp_upload_dir();
	$baseurl = ! empty($uploads['baseurl']) ? untrailingslashit((string) $uploads['baseurl']) : '';
	if ('' === $baseurl) {
		return '';
	}

	$metadata = wp_get_attachment_metadata($attachment_id);
	if (is_array($metadata) && ! empty($metadata['sizes'][ $size ]['file'])) {
		$dirname = trim(str_replace('\\', '/', dirname($relative)), '.\\/');
		$file = (string) $metadata['sizes'][ $size ]['file'];
		return '' !== $dirname ? $baseurl . '/' . $dirname . '/' . $file : $baseurl . '/' . $file;
	}

	return $baseurl . '/' . ltrim($relative, '/');
}

function ttshopgear_pick_product_primary_category_slug($product_id, $fallback_slug = '') {
	if (! ttshopgear_has_woocommerce()) {
		return $fallback_slug;
	}

	$terms = get_the_terms($product_id, 'product_cat');
	if (empty($terms) || is_wp_error($terms)) {
		return $fallback_slug;
	}

	$known_categories = ttshopgear_get_catalog_categories();
	foreach ($terms as $term) {
		if (isset($known_categories[ $term->slug ])) {
			return $term->slug;
		}
	}

	return ! empty($terms[0]->slug) ? $terms[0]->slug : $fallback_slug;
}

function ttshopgear_get_mock_product_by_slug($slug) {
	$data = ttshopgear_get_site_data();

	foreach ($data['products'] as $product) {
		if ($product['slug'] === $slug) {
			return $product;
		}
	}

	return null;
}

function ttshopgear_map_wc_product($wc_product, $fallback = array()) {
	if (! $wc_product instanceof WC_Product) {
		return null;
	}

	$product_id    = $wc_product->get_id();
	$category_slug = ttshopgear_pick_product_primary_category_slug($product_id, ! empty($fallback['category_slug']) ? $fallback['category_slug'] : '');
	$category      = ttshopgear_get_category($category_slug);
	$price         = $wc_product->get_price();
	$regular_price = $wc_product->get_regular_price();
	$description   = $wc_product->get_short_description();
	$categories    = wc_get_product_category_list($product_id, ', ', '', '');
	$rating        = (float) $wc_product->get_average_rating();
	$product_type  = $wc_product->get_type();
	$stock_label   = ttshopgear_translate_stock_status_label($wc_product->get_stock_status());

	if (empty($description)) {
		$description = $wc_product->get_description();
	}

	$description = wp_trim_words(wp_strip_all_tags($description), 28, '...');

	$sku = $wc_product->get_sku();
	if (empty($sku)) {
		$sku = 'N/A';
	}

	return array(
		'id' => $product_id,
		'wp_id' => $product_id,
		'slug' => $wc_product->get_slug(),
		'route_aliases' => array($wc_product->get_slug()),
		'primary_route' => ! empty($category_slug) ? '/' . trim($category_slug, '/') . '/' . $wc_product->get_slug() : '/products/' . $wc_product->get_slug(),
		'name' => $wc_product->get_name(),
		'subtitle' => ! empty($fallback['subtitle']) ? $fallback['subtitle'] : 'Sản phẩm WooCommerce',
		'category_slug' => $category_slug,
		'category' => $category ? $category['menu_label'] : ($categories ? wp_strip_all_tags($categories) : 'Sản phẩm'),
		'price' => wc_format_decimal($price, 2),
		'original_price' => (! empty($regular_price) && (float) $regular_price > (float) $price) ? wc_format_decimal($regular_price, 2) : '',
		'rating' => $rating > 0 ? $rating : 0,
		'reviews' => number_format_i18n((int) $wc_product->get_review_count()),
		'badge' => ! empty($fallback['badge']) ? $fallback['badge'] : ($wc_product->is_on_sale() ? 'Khuyến mãi' : ''),
		'badge_class' => ! empty($fallback['badge_class']) ? $fallback['badge_class'] : ($wc_product->is_on_sale() ? 'tt-badge-danger' : ''),
		'excerpt' => ! empty($description) ? $description : (! empty($fallback['excerpt']) ? $fallback['excerpt'] : 'Xem thêm chi tiết ở trang sản phẩm.'),
		'description' => ! empty($description) ? $description : (! empty($fallback['description']) ? $fallback['description'] : 'Xem thêm chi tiết ở trang sản phẩm.'),
		'features' => array(
			'Tình trạng: ' . $stock_label,
			'SKU: ' . $sku,
			'Loại sản phẩm: ' . ttshopgear_translate_product_type_label($product_type),
			'Danh mục: ' . ($categories ? wp_strip_all_tags($categories) : 'Chưa phân loại'),
		),
		'specs' => array(
			'SKU' => $sku,
			'Tình trạng kho' => $stock_label,
			'Loại' => ttshopgear_translate_product_type_label($product_type),
			'Danh mục' => $categories ? wp_strip_all_tags($categories) : 'Chưa phân loại',
		),
		'image_url' => ttshopgear_get_attachment_image_url_safe($wc_product->get_image_id(), 'large') ?: (string) get_post_meta($product_id, '_ttshopgear_source_image_url', true),
		'cart_url' => $wc_product->add_to_cart_url(),
		'cart_text' => $wc_product->is_purchasable() ? 'Thêm vào giỏ' : 'Xem chi tiết',
		'is_real' => true,
	);
}

function ttshopgear_normalize_product_data($product) {
	if (is_array($product)) {
		return $product;
	}

	if ($product instanceof WC_Product) {
		$fallback = ttshopgear_get_mock_product_by_slug($product->get_slug());
		return ttshopgear_map_wc_product($product, $fallback ? $fallback : array());
	}

	return null;
}

function ttshopgear_get_homepage_data() {
	$data = ttshopgear_get_site_data();
	$homepage_categories = array();

	foreach (array_keys($data['categories']) as $slug) {
		$category = ttshopgear_get_category($slug);
		if ($category) {
			$homepage_categories[] = $category;
		}
	}

	return array(
		'slides' => ttshopgear_enrich_homepage_slides($data['slides']),
		'features' => $data['features'],
		'categories' => $homepage_categories,
		'products' => array_slice(ttshopgear_get_products(), 0, 8),
		'testimonials' => $data['testimonials'],
		'partners' => $data['partners'],
	);
}

function ttshopgear_enrich_homepage_slides($slides) {
	$products = ttshopgear_get_products();

	foreach ($slides as $index => $slide) {
		$keywords = ! empty($slide['match_keywords']) && is_array($slide['match_keywords']) ? $slide['match_keywords'] : array();
		$matched_product = null;

		foreach ($products as $product) {
			if (! is_array($product) || empty($product['name'])) {
				continue;
			}

			$product_name = strtolower((string) $product['name']);
			$is_match = true;

			foreach ($keywords as $keyword) {
				if (false === strpos($product_name, strtolower((string) $keyword))) {
					$is_match = false;
					break;
				}
			}

			if (! $is_match) {
				continue;
			}

			$matched_product = $product;
			break;
		}

		if (! is_array($matched_product)) {
			continue;
		}

		$slides[ $index ]['image_url'] = ! empty($matched_product['image_url']) ? $matched_product['image_url'] : '';
		$slides[ $index ]['product_url'] = ttshopgear_get_product_url($matched_product);
		$slides[ $index ]['subtitle'] = ! empty($slide['subtitle']) ? $slide['subtitle'] : $matched_product['category'];
	}

	return $slides;
}

function ttshopgear_get_header_nav_items() {
	$data = ttshopgear_get_site_data();

	return $data['nav'];
}

function ttshopgear_get_catalog_filter_map() {
	return array(
		'keyboards' => array(
			array('slug' => 'mechanical', 'term_slug' => 'keyboards-mechanical', 'label' => 'Cơ'),
			array('slug' => 'optical', 'term_slug' => 'keyboards-optical', 'label' => 'Quang học'),
			array('slug' => 'wireless', 'term_slug' => 'keyboards-wireless', 'label' => 'Không dây'),
			array('slug' => '65', 'term_slug' => 'keyboards-65', 'label' => '65%'),
			array('slug' => 'tkl', 'term_slug' => 'keyboards-tkl', 'label' => 'TKL'),
			array('slug' => 'full-size', 'term_slug' => 'keyboards-full-size', 'label' => 'Full Size'),
		),
		'mice' => array(
			array('slug' => 'wireless', 'term_slug' => 'mice-wireless', 'label' => 'Không dây'),
			array('slug' => 'wired', 'term_slug' => 'mice-wired', 'label' => 'Có dây'),
			array('slug' => 'ergonomic', 'term_slug' => 'mice-ergonomic', 'label' => 'Công thái học'),
			array('slug' => 'lightweight', 'term_slug' => 'mice-lightweight', 'label' => 'Siêu nhẹ'),
			array('slug' => 'mmo', 'term_slug' => 'mice-mmo', 'label' => 'MMO'),
		),
		'headsets' => array(
			array('slug' => 'wireless', 'term_slug' => 'headsets-wireless', 'label' => 'Không dây'),
			array('slug' => 'wired', 'term_slug' => 'headsets-wired', 'label' => 'Có dây'),
			array('slug' => 'surround-7-1', 'term_slug' => 'headsets-surround-7-1', 'label' => 'Âm thanh 7.1'),
			array('slug' => 'rgb', 'term_slug' => 'headsets-rgb', 'label' => 'RGB'),
		),
		'streaming' => array(
			array('slug' => 'webcam', 'term_slug' => 'streaming-webcam', 'label' => 'Webcam'),
			array('slug' => 'capture-card', 'term_slug' => 'streaming-capture-card', 'label' => 'Capture Card'),
			array('slug' => 'microphone', 'term_slug' => 'streaming-microphone', 'label' => 'Microphone'),
			array('slug' => 'lighting', 'term_slug' => 'streaming-lighting', 'label' => 'Đèn'),
		),
		'components' => array(
			array('slug' => 'ram', 'term_slug' => 'components-ram', 'label' => 'RAM'),
			array('slug' => 'psu', 'term_slug' => 'components-psu', 'label' => 'Nguồn'),
			array('slug' => 'case', 'term_slug' => 'components-case', 'label' => 'Case'),
			array('slug' => 'cooling', 'term_slug' => 'components-cooling', 'label' => 'Tản nhiệt'),
			array('slug' => 'storage', 'term_slug' => 'components-storage', 'label' => 'Lưu trữ'),
		),
	);
}

function ttshopgear_get_category_filter_items($category_slug) {
	$map = ttshopgear_get_catalog_filter_map();

	return isset($map[ $category_slug ]) ? $map[ $category_slug ] : array();
}

function ttshopgear_get_filter_label($category_slug, $filter_slug) {
	foreach (ttshopgear_get_category_filter_items($category_slug) as $item) {
		if ($item['slug'] === $filter_slug) {
			return $item['label'];
		}
	}

	return ttshopgear_humanize_slug($filter_slug);
}

function ttshopgear_get_filter_term_slug($category_slug, $filter_slug) {
	foreach (ttshopgear_get_category_filter_items($category_slug) as $item) {
		if ($item['slug'] === $filter_slug) {
			return $item['term_slug'];
		}
	}

	return '';
}

function ttshopgear_get_footer_link_groups() {
	$data = ttshopgear_get_site_data();

	return $data['footer_links'];
}

function ttshopgear_get_catalog_categories() {
	$data       = ttshopgear_get_site_data();
	$categories = $data['categories'];

	if (! ttshopgear_has_woocommerce()) {
		return $categories;
	}

	foreach ($categories as $slug => $category) {
		$term = get_term_by('slug', $slug, 'product_cat');
		if ($term instanceof WP_Term) {
			$categories[ $slug ] = ttshopgear_map_wc_term_to_category($term, $category);
		}
	}

	$terms = get_terms(
		array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		)
	);

	if (! is_wp_error($terms)) {
		foreach ($terms as $term) {
			if ('uncategorized' === $term->slug) {
				continue;
			}

			if (isset($categories[ $term->slug ])) {
				continue;
			}

			$categories[ $term->slug ] = ttshopgear_map_wc_term_to_category($term);
		}
	}

	return $categories;
}

function ttshopgear_get_category($slug) {
	$categories = ttshopgear_get_catalog_categories();

	return isset($categories[ $slug ]) ? $categories[ $slug ] : null;
}

function ttshopgear_get_products() {
	$data = ttshopgear_get_site_data();

	if (! ttshopgear_has_live_products()) {
		return $data['products'];
	}

	$query = new WP_Query(
		array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC',
			'no_found_rows' => true,
		)
	);

	$items = array();
	foreach ($query->posts as $post) {
		$wc_product = wc_get_product($post->ID);
		if (! $wc_product) {
			continue;
		}

		$fallback = ttshopgear_get_mock_product_by_slug($wc_product->get_slug());
		$items[]  = ttshopgear_map_wc_product($wc_product, $fallback ? $fallback : array());
	}

	wp_reset_postdata();

	return $items ? $items : $data['products'];
}

function ttshopgear_get_product_by_slug($slug) {
	if (ttshopgear_has_woocommerce()) {
		$post = get_page_by_path($slug, OBJECT, 'product');
		if ($post instanceof WP_Post) {
			$wc_product = wc_get_product($post->ID);
			if ($wc_product) {
				$fallback = ttshopgear_get_mock_product_by_slug($slug);
				return ttshopgear_map_wc_product($wc_product, $fallback ? $fallback : array());
			}
		}
	}

	return ttshopgear_get_mock_product_by_slug($slug);
}

function ttshopgear_get_product_by_route($category_slug, $route_slug) {
	if (ttshopgear_has_woocommerce()) {
		$post = get_page_by_path($route_slug, OBJECT, 'product');
		if ($post instanceof WP_Post && has_term($category_slug, 'product_cat', $post)) {
			$wc_product = wc_get_product($post->ID);
			if ($wc_product) {
				$fallback = ttshopgear_get_mock_product_by_slug($route_slug);
				return ttshopgear_map_wc_product($wc_product, $fallback ? $fallback : array());
			}
		}
	}

	foreach (ttshopgear_get_site_data()['products'] as $product) {
		if ($product['category_slug'] !== $category_slug) {
			continue;
		}

		if ($product['slug'] === $route_slug || in_array($route_slug, $product['route_aliases'], true)) {
			return $product;
		}
	}

	return null;
}

function ttshopgear_get_products_by_category($category_slug) {
	if (ttshopgear_has_live_products()) {
		$term = get_term_by('slug', $category_slug, 'product_cat');
		if ($term instanceof WP_Term) {
			$query = new WP_Query(
				array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'posts_per_page' => 24,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => $category_slug,
						),
					),
					'no_found_rows' => true,
				)
			);

			$items = array();
			foreach ($query->posts as $post) {
				$wc_product = wc_get_product($post->ID);
				if (! $wc_product) {
					continue;
				}

				$fallback = ttshopgear_get_mock_product_by_slug($wc_product->get_slug());
				$items[]  = ttshopgear_map_wc_product($wc_product, $fallback ? $fallback : array());
			}

			wp_reset_postdata();

			return $items;
		}
	}

	$items = array();
	foreach (ttshopgear_get_site_data()['products'] as $product) {
		if ($product['category_slug'] === $category_slug) {
			$items[] = $product;
		}
	}

	return $items;
}

function ttshopgear_get_products_by_category_filter($category_slug, $filter_slug) {
	if (ttshopgear_has_live_products()) {
		$parent_term = get_term_by('slug', $category_slug, 'product_cat');
		$term_slug   = ttshopgear_get_filter_term_slug($category_slug, $filter_slug);
		$child_term  = $term_slug ? get_term_by('slug', $term_slug, 'product_cat') : false;

		if ($parent_term instanceof WP_Term && $child_term instanceof WP_Term && (int) $child_term->parent === (int) $parent_term->term_id) {
			$query = new WP_Query(
				array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'posts_per_page' => 24,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'term_id',
							'terms' => array($child_term->term_id),
						),
					),
					'no_found_rows' => true,
				)
			);

			$items = array();
			foreach ($query->posts as $post) {
				$wc_product = wc_get_product($post->ID);
				if (! $wc_product) {
					continue;
				}

				$fallback = ttshopgear_get_mock_product_by_slug($wc_product->get_slug());
				$items[]  = ttshopgear_map_wc_product($wc_product, $fallback ? $fallback : array());
			}

			wp_reset_postdata();

			return $items;
		}
	}

	return array();
}

function ttshopgear_get_current_product_category_slug($product_id) {
	return ttshopgear_pick_product_primary_category_slug($product_id, '');
}

function ttshopgear_get_static_page($slug) {
	$data = ttshopgear_get_site_data();

	return isset($data['pages'][ $slug ]) ? $data['pages'][ $slug ] : null;
}

function ttshopgear_get_page_slug_url($slug) {
	if (empty($slug)) {
		return home_url('/');
	}

	if ('products' === $slug) {
		return ttshopgear_get_shop_url();
	}

	if (ttshopgear_get_category($slug)) {
		return ttshopgear_get_category_url($slug);
	}

	$page = get_page_by_path($slug);
	if ($page instanceof WP_Post) {
		return get_permalink($page);
	}

	return home_url('/' . trim($slug, '/'));
}

function ttshopgear_get_shop_url() {
	if (function_exists('wc_get_page_permalink')) {
		$url = wc_get_page_permalink('shop');
		if ($url && '-1' !== $url) {
			return $url;
		}
	}

	return home_url('/products');
}

function ttshopgear_get_category_url($slug, $child = '') {
	$path = trim($slug, '/');
	if (! empty($child)) {
		$path .= '/' . trim($child, '/');
	}

	return home_url('/' . $path);
}

function ttshopgear_get_product_url($product) {
	if (! empty($product['wp_id'])) {
		return get_permalink((int) $product['wp_id']);
	}

	if (! empty($product['slug']) && post_type_exists('product')) {
		$post = get_page_by_path($product['slug'], OBJECT, 'product');
		if ($post instanceof WP_Post) {
			return get_permalink($post);
		}
	}

	if (! empty($product['primary_route'])) {
		return home_url($product['primary_route']);
	}

	return home_url('/products/' . $product['slug']);
}

function ttshopgear_humanize_slug($slug) {
	$label = str_replace(array('-', '_'), ' ', (string) $slug);

	return ucwords($label);
}
