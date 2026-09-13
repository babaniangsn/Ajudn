window.addEventListener('load', () => {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch((error) => {
            console.log('Service Worker registration failed:', error);
        });
    }

    let deferredPrompt = null;

    const installButton = document.createElement('button');
    installButton.textContent = 'Installer l\'application';
    installButton.style.position = 'fixed';
    installButton.style.bottom = '20px';
    installButton.style.right = '20px';
    installButton.style.zIndex = '9999';
    installButton.style.display = 'none';
    installButton.style.border = 'none';
    installButton.style.background = '#140035';
    installButton.style.color = '#fff';
    installButton.style.padding = '12px 18px';
    installButton.style.borderRadius = '999px';
    installButton.style.boxShadow = '0 8px 20px rgba(0,0,0,0.25)';
    installButton.style.cursor = 'pointer';

    document.body.appendChild(installButton);

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;
        installButton.style.display = 'block';
    });

    installButton.addEventListener('click', () => {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        deferredPrompt.userChoice.finally(() => {
            installButton.style.display = 'none';
        });
    });
});
