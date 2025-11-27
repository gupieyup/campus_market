<style>
	/* Minimal fallback for tokped-container so footer lays out correctly
	   even on pages that don't include the Home inline CSS. */
	.tokped-container {
		/* make the top part wider */
		max-width: 1400px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 1rem;
		padding-right: 1rem;
	}
	@media (min-width: 768px) {
		.tokped-container { padding-left: 2rem; padding-right: 2rem; }
	}
</style>

<footer class="bg-white border-t border-gray-200 mt-12 pt-16 pb-10">
	<div class="tokped-container">
		<div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
			<div class="md:col-span-1">
				<div class="flex items-center gap-2 text-[#FF9894] mb-4">
					<i class="fa-solid fa-bag-shopping text-2xl"></i>
					<span class="font-bold text-xl">SiToko</span>
				</div>
					<p class="text-gray-500 text-sm leading-relaxed">
						Platform jual beli aman dan terpercaya untuk semua di seluruh Indonesia.
				</p>
			</div>
			<div>
				<h5 class="font-bold text-gray-800 mb-4">Tentang Kami</h5>
				<ul class="space-y-2 text-sm text-gray-500">
					<li><a href="#" class="hover:text-pink-500 transition">Hak Kekayaan Intelektual</a></li>
					<li><a href="#" class="hover:text-pink-500 transition">Karir</a></li>
					<li><a href="#" class="hover:text-pink-500 transition">Blog</a></li>
				</ul>
			</div>
			<div>
				<h5 class="font-bold text-gray-800 mb-4">Bantuan</h5>
				<ul class="space-y-2 text-sm text-gray-500">
					<li><a href="#" class="hover:text-pink-500 transition">Pusat Bantuan</a></li>
					<li><a href="#" class="hover:text-pink-500 transition">Syarat & Ketentuan</a></li>
					<li><a href="#" class="hover:text-pink-500 transition">Kebijakan Privasi</a></li>
				</ul>
			</div>
			<div>
				<h5 class="font-bold text-gray-800 mb-4">Ikuti Kami</h5>
				<div class="flex gap-3">
					<a href="#" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-pink-500 hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
					<a href="#" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-pink-500 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
					<a href="#" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-pink-500 hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
				</div>
			</div>
		</div>
			<div class="border-t border-gray-100 pt-8 text-center text-sm text-gray-400 font-medium">
				&copy; {{ date('Y') }} SiToko. Dibuat dengan <i class="fa-solid fa-heart text-pink-400 mx-1"></i> oleh Kita.
			</div>
	</div>
</footer>
