<div id="app-toast" class="fixed right-6 bottom-6 z-50 hidden">
    <div class="min-w-[240px] max-w-[360px] flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border transition-all duration-300"
         data-variant="info">
        <div id="app-toast-icon" class="mt-0.5 text-lg"></div>
        <div class="flex-1">
            <div id="app-toast-title" class="text-sm font-semibold"></div>
            <div id="app-toast-msg" class="text-sm text-gray-700"></div>
        </div>
        <button id="app-toast-close" class="ml-2 text-gray-400 hover:text-gray-600">&times;</button>
    </div>
</div>
<script>
(function(){
    const toast = document.getElementById('app-toast');
    const wrap = toast?.querySelector('div[data-variant]');
    const icon = document.getElementById('app-toast-icon');
    const title = document.getElementById('app-toast-title');
    const msg = document.getElementById('app-toast-msg');
    const closeBtn = document.getElementById('app-toast-close');
    let timer = null;

    const variants = {
        success: { border: 'border-green-200', bg: 'bg-green-50', text: 'text-green-800', icon: '✅', title: 'Berhasil' },
        error:   { border: 'border-rose-200',  bg: 'bg-rose-50',  text: 'text-rose-800',   icon: '❌', title: 'Gagal' },
        warn:    { border: 'border-yellow-200',bg: 'bg-yellow-50',text: 'text-yellow-800', icon: '⚠️', title: 'Perhatian' },
        info:    { border: 'border-blue-200',  bg: 'bg-blue-50',  text: 'text-blue-800',   icon: 'ℹ️', title: 'Info' },
    };

    function setVariant(v){
        const vv = variants[v] || variants.info;
        wrap.className = `min-w-[240px] max-w-[360px] flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border ${vv.bg} ${vv.border}`;
        title.className = `text-sm font-semibold ${vv.text}`;
        msg.className = `text-sm text-gray-700`;
        icon.textContent = vv.icon;
        if (!title.textContent) title.textContent = vv.title;
    }

    window.notify = function({ message='', heading='', variant='info', timeout=3000 }={}){
        if (!toast || !wrap) return;
        title.textContent = heading || '';
        msg.textContent = message || '';
        setVariant(variant);
        toast.classList.remove('hidden');
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        requestAnimationFrame(() => {
            toast.style.transition = 'opacity 200ms ease, transform 200ms ease';
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });
        if (timer) clearTimeout(timer);
        if (timeout && timeout > 0) {
            timer = setTimeout(hideToast, timeout);
        }
    };

    function hideToast(){
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        setTimeout(()=>{ toast.classList.add('hidden'); }, 200);
    }

    closeBtn?.addEventListener('click', hideToast);
})();
</script>
